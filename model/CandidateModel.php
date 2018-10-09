<?php

include "Connections.php";
include 'AppLib.php';
class CandidateModel{
    private $conn;
    private $connection;
    public function __construct(){
        
        $this->connection = new Connection();
        $this->conn = $this->connection->createConnection();
    }

    public function __destruct(){
        $this->connection->closeConnection($this->conn);
    }


    // function to fetch questions for test
    public function fetch_question($data){
        //print_r($data);
        $question_set = $data->question_set;
        if($this->conn == null){
            echo "DATABASE ERROR";
            return;
        }
        //echo "inside filter";
        //$questions = array();
        $sql = "SELECT `question_id`, `negative` FROM `question_paper` WHERE `status`= 1 and `qp_id` = '$question_set' ";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_array($res);
            $str = $row['question_id'];
            $arr = explode(",", $str);
            $arr_size = sizeof($arr);

            for($i = 0; $i < $arr_size; $i++){
                $sql_arr = "SELECT `question`, `option1`, `option2` ,`option3` ,`option4`,`correct_ans`,`priority`,`question_id` FROM `question_master` WHERE `question_master`.`question_id` = $arr[$i] ";
                $res_arr = mysqli_query($this->conn, $sql_arr);
                if(mysqli_num_rows($res_arr)>0){
                    $rows = mysqli_fetch_array($res_arr);
                    $question[] = array("question"=>$rows[0], 
                                        "option1"=>$rows[1], 
                                        "option2"=>$rows[2], 
                                        "option3"=>$rows[3],
                                        "option4"=>$rows[4],
                                        "correct_ans"=>$rows[5],
                                        "priority"=>$rows[6],
                                        "question_id"=>$rows[7]);
                }
                
            }
            //print_r($arr);
            $question[$arr_size] = $row['negative'];
        }
        echo json_encode($question);        
    }


    // Function to submit Test result in table

    function submit_result($data){
        if($data==null){
            echo "ERROR";
            return;
        }

        if($this->conn == null){
            echo "DATABASE ERROR";
            return;
        }
        //print_r($data);
        $createDate = Format::getCurrentDateTime();
        //echo $createDate;
        $user_id = $data->userId;
        $total_question = $data->total_question;
        $total_marks = $data->total_marks;
        $attempted_question = $data->attempted_question;
        $correct_ans = $data->correct_ans;
        $obtain_mark = $data->obtain_marks;
        $wrong_ans = $data->wrong_ans;
        $test_code = $data->test_code;
        $rows;
        // Get passing Marks from question_paper table
        $sql_passing = "SELECT `passing_marks` FROM `question_paper` WHERE `qp_id` = '$test_code'";
        $res_passing = mysqli_query($this->conn, $sql_passing);
        if(mysqli_num_rows($res_passing)>0){
            $rows = mysqli_fetch_array($res_passing);
            //echo $rows[0];
            $rows = $rows[0];
            // Percentages get by student
            $passing_per = ceil(($obtain_mark / $total_marks) * 100);
            if(ceil($passing_per)>$rows){
                $result = "PASS";
            }
            else{
                $result = "FAIL";
            }
           
        }

        // Insert data into test_result to add users test result
        $sql = "INSERT INTO `test_result` ( `qp_id`, 
                                            `candidate_id`, 
                                            `total_questions`, 
                                            `total_marks`, 
                                            `attempted_question`, 
                                            `correct_answer`, 
                                            `wrong_answer`, 
                                            `obtain_marks`, 
                                            `passing_percentages`,
                                            `percentage`,
                                            `result`,
                                            `date_time`)
                                            VALUES('$test_code', 
                                            '$user_id', 
                                            '$total_question', 
                                            '$total_marks',
                                            '$attempted_question', 
                                            '$correct_ans', 
                                            '$wrong_ans',
                                            '$obtain_mark', 
                                             $rows,
                                            $passing_per,
                                            '$result',
                                            '$createDate')";
        
        $res = mysqli_query($this->conn, $sql);
        if($res){
            echo "SUCCESS";
        }     
        else{
            echo mysqli_error($this->conn);
        }                          


    }
    
    
    // function to check Question set is available or not
    function check_question_set($data){
        $question_set_number = $data->question_set_number;
        //echo $question_set_number;
        $question_set_number;
        $sql = "SELECT `qp_id`,`negative`, `total_question`, `time` FROM `question_paper` WHERE `qp_id` = '$question_set_number'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $res = array("negative"=>$rows[1], "total"=>$rows[2],"time"=>$rows[3]);
            //print_r($res);
            echo json_encode($res);
        }
        else{
            echo json_encode("FAILED");
            //echo mysqli_error($this->conn);
        }
    }


    // show result of tests given by Candidates on results.php for users

    public function show_result(){
        $test_code = $data->test_code;
        $result = array();
        $sql = "SELECT `user_master`.`email`,
                        `user_master`.`fname`,
                        `user_master`.`lname`,
                        `test_result`.`total_questions`, 
                        `test_result`.`total_marks`, 
                        `test_result`.`attempted_question`, 
                        `test_result`.`correct_answer`, 
                        `test_result`.`wrong_answer`, 
                        `test_result`.`obtain_marks`,
                        `test_result`.`candidate_id` ,
                        `test_result`.`date_time`,
                        `test_result`.`result_id`
                    FROM `test_result` 
                    INNER JOIN `user_master` ON `test_result`.`candidate_id` = `user_master`.`user_id`";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $result[] = array("email"=>$rows[0],
                                "firstName"=>$rows[1],
                                "lastName"=>$rows[2], 
                                "total_question"=>$rows[3], 
                                "total_marks" =>$rows[4], 
                                "attempted_question"=>$rows[5], 
                                "correct_answer"=>$rows[6], 
                                "wrong_answer"=>$rows[7], 
                                "obtain_marks"=>$rows[8],
                                "candidate_id"=>$rows[9],
                                "date"=>$rows[10],
                                "result_id"=>$rows[11]);
            }
            echo json_encode($result);
            
        }
        else{
            echo mysqli_error($this->conn);
        }

    
    }   

    // Function to show all candidates created by registrar itself for their organization 

    public function show_all_candidates($data){
        $result = [];
        $user_id = $data->userId;
        $sql = "SELECT `user_master`.`user_id`,`user_master`.`fname`,`user_master`.`lname`,`user_master`.`email`, `user_master`.`mobile`, `user_master`.`status`  FROM `user_master` WHERE `user_master`.`register_by` = '$user_id' AND `status` = 1";  // AND `status` = 1
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $name = $rows[1]. " " .$rows[2];
                $result[] = array("user_id"=>$rows[0], "name"=>$name, "email"=>$rows[3], "mobile"=>$rows[4], "status"=>$rows[5]);
            } 
            echo json_encode($result);
        }
        else{
            echo "No Records Found";
        }
    }


    // Function to edit Candidate Information
    function editUserCandidateInfo($data){
        $user_id = $data->user_id;

        $sql = "SELECT `fname`, `lname`, `email`, `mobile`, `gender`, `college_name`,`company_name`,`user_id` FROM `user_master` WHERE `user_id` = '$user_id'";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $result[] = array("fname"=>$rows[0],
                         "lname"=>$rows[1],
                         "email"=>$rows[2],
                         "mobile"=>$rows[3], 
                         "gender"=>$rows[4], 
                         "college_name"=>$rows[5],
                         "company_name"=>$rows[6],
                         "user_id"=>$rows[7]);
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
            echo "FAILED";
        }
    }


    // Function to update Candidate Information
    public function update_info($data){
        $user_id = $data->user_id;
        $first_name = $data->first_name;
        $last_name = $data->last_name;
        $mobile = $data->mobile;
        $gender = $data->gender;
        $organization = $data->organization;

        $sql = "UPDATE `user_master` SET `fname`='$first_name',`lname`='$last_name',`mobile`='$mobile',`gender`='$gender',`college_name`='$organization' WHERE `user_id` = '$user_id' ";
        $res = mysqli_query($this->conn, $sql);
        if($res){
            echo "SUCCESS";
        }
        else{
            echo mysqli_error($this->conn);
            echo "FAILED";
        }
    
    }


    // Function to filter data in users_candidate by name, email or mobile number
    public function filterInfo($data){
        //print_r($data);

        $user_id = $data->userId;
        $userType = $data->userType;

        if($userType != "ADMIN"){
            $userId = "AND `register_by` = '$user_id'";
        }
        else{
            $userId = "";
        }
        $inputText = $data->inputText;
        $fname = $data->fname;
        $lname = $data->lname;
        $filter = "";
        $filterBy = $data->filterBy;

        if($filterBy=="name" && $fname != "" && $lname == ""){
            $filter = "(`fname` LIKE '%$fname%')";
        }
        if($filterBy=="name" && $fname != "" && $lname != ""){
            $filter = "(`fname` LIKE '%$fname%' AND `lname` LIKE '%$lname%')";
        }
        
        $sql = "";
        //$fname = 
        //$inputText = $data->inputText;
        if($filterBy == "name"){
            $sql = "SELECT `user_id`, `fname`, `lname`, `email`, `mobile`, `user_type` from `user_master` where $filter AND `status` = 1 " .$userId. " ORDER BY '$filterBy' ASC";
        }
        else{
            $sql = "SELECT `user_id`, `fname`, `lname`, `email`, `mobile`, `user_type` from `user_master` where `$filterBy` LIKE '%$inputText%' AND `status` = 1 " .$userId. " ORDER BY '$filterBy' ASC";
        }
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $name = $rows[1]. " " .$rows[2]; 
                $result[]= array("user_id"=>$rows[0],
                                "name"=>$name, 
                                "email"=>$rows[3],
                                "mobile"=>$rows[4],
                                "user_type"=>$rows[5]
                            );
            }
            echo json_encode($result);
        }
        else{
           echo mysqli_error($this->conn);
            echo "EMPTY";
        }

    }

    // function to search user by date (from date - to date)
    public function search_by_date($data){
        //print_r($data);
        $filterBy = $data->filterBy;
        $from_date = $data->from_date;
        $to_date = $data->to_date;
        $user_id = $data->userId;
        $userType = $data->userType;
        if($userType != "ADMIN"){
            $userId = "AND `register_by` = '$user_id'";
        }
        else{
            $userId = "";
        }

        $sql = "";
        $result = [];
        if($filterBy == "date"){
            if(!empty($from_date) && empty($to_date)){
                $sql = "SELECT `user_id`, `fname`, `lname`, `email`, `mobile`, `user_type` from `user_master` where `status` = 1 AND `created` >= '$from_date' " . $userId;
            }
            if(!empty($to_date) && empty($from_date)){
                $sql = "SELECT `user_id`, `fname`, `lname`, `email`, `mobile`, `user_type` from `user_master` where `status` = 1 AND `created` <= '$to_date' " . $userId;
            }
            if(!empty($from_date) && !empty($to_date)){
                $sql = "SELECT `user_id`, `fname`, `lname`, `email`, `mobile`, `user_type` FROM `user_master` WHERE `status` = 1 AND `created` BETWEEN '$from_date' AND '$to_date' " . $userId;
            }
        }
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $name = $rows[1]. " " .$rows[2]; 
                $result[]= array("user_id"=>$rows[0],
                                "name"=>$name, 
                                "email"=>$rows[3],
                                "mobile"=>$rows[4],
                                "user_type"=>$rows[5]
                            );
            }
            echo json_encode($result);
        }
        else{
           echo mysqli_error($this->conn);
            echo "EMPTY";
        }
        
    }

    // function for filter data by user type
     public function filter_by_users($data){
        $userType = $data->userType;
        if($userType != "ADMIN"){
            $userId = "AND `register_by` = '$userId'";
        }
        else{
            $userId = "";
        }

        $user_type = $data->user_type;
        $sql = "SELECT `user_id`, `fname`, `lname`, `email`, `mobile`, `user_type` FROM `user_master` WHERE `user_type` = '$user_type' " . $userId . "ORDER BY `user_type`";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $name = $rows[1]. " " .$rows[2]; 
                $result[]= array("user_id"=>$rows[0],
                                "name"=>$name, 
                                "email"=>$rows[3],
                                "mobile"=>$rows[4],
                                "user_type"=>$rows[5]
                            );
            }
            echo json_encode($result);
        }
        else{
           echo mysqli_error($this->conn);
            echo "EMPTY";
        }


     }

    public function getTimer($data){
        $paper_id = $data->test_code;
        $sql = "SELECT `time` FROM `question_paper` WHERE `qp_id` = '$paper_id'";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_array($res);
            echo json_encode($row[0]);
        }
        else{
            echo "ERROR";
        }
    }

    // check result after test submitted 
    public function check_result($data){
        //print_r($data);
        $user_type = $data->userType;
        $user_id = $data->userId;
        $result = array();
        // check candidate is created by any of the user or not 
        $sql = "SELECT 
                        `test_result`.`total_questions`, 
                        `test_result`.`total_marks`, 
                        `test_result`.`attempted_question`, 
                        `test_result`.`correct_answer`, 
                        `test_result`.`wrong_answer`, 
                        `test_result`.`obtain_marks`,
                        `test_result`.`passing_percentages`,
                        `test_result`.`percentage`,
                        `test_result`.`result`,
                        `question_paper`.`negative`
                    FROM `test_result` 
                    INNER JOIN `user_master` ON `test_result`.`candidate_id` = `user_master`.`user_id` AND `user_master`.`user_id` = 'STU02'
                    INNER JOIN `question_paper` ON `question_paper`.`qp_id` = `test_result`.`qp_id`";
            $res = mysqli_query($this->conn, $sql);
            if(mysqli_num_rows($res)>0){

                $rows = mysqli_fetch_array($res);
                $result = array("total_questions"=>$rows[0],
                                "total_marks"=>$rows[1],
                                "attempted_question"=>$rows[2], 
                                "correct_answer"=>$rows[3], 
                                "wrong_answer" =>$rows[4], 
                                "obtain_marks"=>$rows[5], 
                                "passing_percentages"=>$rows[6], 
                                "percentage"=>$rows[7], 
                                "result"=>$rows[8],
                                "negative"=>$rows[9],
                                );   
                echo json_encode($result);              
            }
            else{
                //echo "FAILED";
                echo mysqli_error($this->conn);
            }
    }


    // Function to get user name while showing result after submitted test for employees and students only
    public function get_user_name($data){
        $user_id = $data->userId;
        $sql = "SELECT `fname`, `lname` FROM `user_master` WHERE `user_id` = '$user_id'";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $result = array("first_name"=>$rows[0],
                            "last_name"=>$rows[1]
                            );
            echo json_encode($result);
        }
        else{
            //echo "FAILED";
            echo mysqli_error($this->conn);
        }
    } 


}
?>