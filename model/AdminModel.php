
<?php
/*  AdminModel
    Roshan Bagde 
    17-April-2018
*/

include "Connections.php";
include 'AppLib.php';
// Reference the dompdf namespase


class AdminModel{
    private $conn;
    private $connection;
    public function __construct(){
        //session_start();
        $this->connection = new Connection();
        $this->conn = $this->connection->createConnection();   
        $this->format = new Format(); 
         
    }

    public function __destruct(){
        $this->connection->closeConnection($this->conn);
    }

   
    // function for count questions to show on admin dashboard
    public function question_count(){
        $sql = "SELECT (select count(*) from `question_master` where `status` = 1) AS que_count,
                       (select count(*) from `subject_master` where `subject_name` != 'RANDOM') AS sub_count FROM dual ";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $result = array("question_count"=> $rows[0], "subject_count"=>$rows[1]);
            }
            echo json_encode($result);
           }
        }
    
    //  Function for show test count on admin dashboard
    public function test_count(){
        $res_arr = array();
        $sql = "SELECT COUNT(*) AS TOTAL, COUNT(IF(`test_type`='SUB007',1,null)) AS 'SUB', COUNT(IF(`test_type`!='SUB007',1,null)) AS 'random' FROM `question_paper` WHERE `status`=1";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $result = array("total"=>$rows[0],
                                "subject"=>$rows[1],
                                "random"=>$rows[2]);
            }
            echo json_encode($result);
        }

    }

    // Function for users count on show on admin dashboard 
    public function user_count(){
        $sql = "SELECT COUNT(*) AS TOTAL, 
		               COUNT(IF(`user_type`='QUESTION_BANK',1,null)) AS 'ques_bank', 
                       COUNT(IF(`user_type`='QUESTION_PAPER',1,null)) AS 'ques_paper', 
                       COUNT(IF(`user_type`='CANDIDATE',1,null)) AS 'candidate'
                       FROM `user_master` WHERE `status` = 1 AND `user_type` != 'ADMIN'";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows=mysqli_fetch_array($res);
            $result = array("total"=>$rows[0], "ques_bank"=>$rows[1], "ques_paper"=>$rows[2], "candidate"=>$rows[3]);
            echo json_encode($result);
        }
    }

    // Function for Subjects count on show on admin dashboard 
    public function subject_count(){
        $sql = "SELECT COUNT(*) AS TOTAL FROM `subject_master` WHERE `subject_name` != 'RANDOM' ";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows=mysqli_fetch_array($res);
            $result = array("total"=>$rows[0]);
            echo json_encode($result);
        }
    }

    // Function for results count on show on admin dashboard 
    public function result_count(){
        $sql = "SELECT COUNT(*) AS TOTAL 
                       FROM `test_result`, `user_master` WHERE `user_master`.`user_id` = `test_result`.`candidate_id`";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows=mysqli_fetch_array($res);
            $result = array("total"=>$rows[0]);
            echo json_encode($result);
        }
    }

    // show result of tests given by Candidates on results.php
    // check user_type is ADMIN or other

    public function show_result($data){
        //print_r($data);
        $user_id = $data->userId;
        $user_type = $data->userType;
        $sql = "";
        $result = array();
        if($user_type=="ADMIN"){
            $sql = "SELECT `user_master`.`email`,
                            `user_master`.`fname`,
                            `user_master`.`lname`,
                            `test_result`.`total_questions`, 
                            `test_result`.`total_marks`, 
                            `test_result`.`attempted_question`, 
                            `test_result`.`correct_answer`, 
                            `test_result`.`wrong_answer`, 
                            `test_result`.`obtain_marks`,
                            `test_result`.`passing_percentages`,
                            `test_result`.`percentage`,
                            `test_result`.`result`,
                            `test_result`.`candidate_id` ,
                            `test_result`.`date_time`,
                            `test_result`.`result_id`,
                            `test_result`.`qp_id`
                        FROM `test_result` 
                        INNER JOIN `user_master` 
                        ON `test_result`.`candidate_id` = `user_master`.`user_id`";
        }
        else
        {
            $sql = "SELECT `user_master`.`email`,
                            `user_master`.`fname`,
                            `user_master`.`lname`,
                            `test_result`.`total_questions`, 
                            `test_result`.`total_marks`, 
                            `test_result`.`attempted_question`, 
                            `test_result`.`correct_answer`, 
                            `test_result`.`wrong_answer`, 
                            `test_result`.`obtain_marks`,
                            `test_result`.`passing_percentages`,
                            `test_result`.`percentage`,
                            `test_result`.`result`,
                            `test_result`.`candidate_id` ,
                            `test_result`.`date_time`,
                            `test_result`.`result_id`,
                            `test_result`.`qp_id`
                        FROM `test_result` 
                        INNER JOIN `user_master` 
                        ON `test_result`.`candidate_id` = `user_master`.`user_id` 
                        AND `user_master`.`register_by` = '$user_id'";
        }
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
                                "passing_percentage"=>$rows[9],
                                "percentage"=>$rows[10],
                                "result"=>$rows[11],
                                "candidate_id"=>$rows[12],
                                "date"=>$rows[13],
                                "result_id"=>$rows[14],
                                "qp_id"=>$rows[15]
                            );
            }
            echo json_encode($result);
            
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    // The users who have user type as REGISTRAR show their college name
    public function show_college_name(){
        $sql = "SELECT `college_name`, `user_id` FROM `user_master` WHERE `user_type`='REGISTRAR'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $result[] = array("college_name" => strtoupper($rows[0]),"user_id"=>$rows[1]);
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    // function to filter result data and show on result.php
    public function filter_result($data){
        //print_r($data);
        $user_id = $data->userId;
        $user_type = $data->userType;
        $result = array();
        $college_name = $data->college_name;
        $testcode = $data->testcode;
        $username = $data->username;
        $from_date = $data->from_date;
        $to_date= $data->to_date;
        $test_code = $data->test_code; // Modal input value to test code
        $a = 0;
        $res = [];
       
        if($user_type=="ADMIN"){

            $sql = "SELECT `user_master`.`email`,
                        `user_master`.`fname`,
                        `user_master`.`lname`,
                        `test_result`.`total_questions`, 
                        `test_result`.`total_marks`, 
                        `test_result`.`attempted_question`, 
                        `test_result`.`correct_answer`, 
                        `test_result`.`wrong_answer`, 
                        `test_result`.`obtain_marks` ,
                        `test_result`.`passing_percentages`,
                        `test_result`.`percentage`,
                        `test_result`.`result`,
                        `test_result`.`candidate_id`, 
                        `test_result`.`date_time`,
                        `test_result`.`result_id`,
                        `test_result`.`qp_id`
                    FROM `test_result`,`user_master` 
                    WHERE `user_master`.`user_id` = `test_result`.`candidate_id`";
        }
        else{
            $sql = "SELECT `user_master`.`email`,
                        `user_master`.`fname`,
                        `user_master`.`lname`,
                        `test_result`.`total_questions`, 
                        `test_result`.`total_marks`, 
                        `test_result`.`attempted_question`, 
                        `test_result`.`correct_answer`, 
                        `test_result`.`wrong_answer`, 
                        `test_result`.`obtain_marks` ,
                        `test_result`.`passing_percentages`,
                        `test_result`.`percentage`,
                        `test_result`.`result`,
                        `test_result`.`candidate_id`, 
                        `test_result`.`date_time`,
                        `test_result`.`result_id`,
                        `test_result`.`qp_id`
                    FROM `test_result`,`user_master` 
                    WHERE `user_master`.`user_id` = `test_result`.`candidate_id` 
                    AND `user_master`.`register_by` = '$user_id'";
        }
        if(!empty($test_code)){
            $sql = $sql . " AND `test_result`.`qp_id` = '$test_code'";
        }
        if(!empty($college_name)){
            $sql = $sql . " AND `user_master`.`register_by` = '$college_name'";  // college name having registrar id
        }
        if(!empty($testcode)){
            $sql = $sql . " AND `test_result`.`qp_id` LIKE '%$testcode%'";
        }
        if(!empty($username)){
            $sql = $sql . " AND `user_master`.`fname` LIKE '%$username%'";
        }
        if(!empty($from_date) && empty($to_date)){
            $fromdate = $from_date.' 00:00:00';
			$todate = $from_date.' 23:59;59';
			$sql = $sql." AND (`test_result`.`date_time` between '$fromdate' and '$todate')";
        }
        if(!empty($to_date) && empty($from_date)){
            $sql = $sql." AND (`test_result`.`date_time` between '2015/01/01' and '$to_date')";
        }
        if(empty($from_date) && empty($to_date)){

        }
        if(!empty($from_date) && !empty($to_date)){
            $sql = $sql." AND (`test_result`.`date_time` between '$from_date' and '$to_date')";
        }
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
                                "passing_percentage"=>$rows[9],
                                "percentage"=>$rows[10],
                                "result"=>$rows[11],
                                "candidate_id"=>$rows[12],
                                "date"=>$rows[13],
                                "result_id"=>$rows[14],
                                "qp_id"=>$rows[15]
                            );
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    // Function to open filtered result in pdf format and then give option to download it
    function download_pdf($data){

        $user_id = $data->userId;
        $user_type = $data->userType;
        $result = array();
        $college_name = $data->college_name;
        $coll_name = "";
        $testcode = $data->testcode;
        $username = $data->username;
        $from_date = $data->from_date;
        $to_date= $data->to_date;
        $test_code = $data->test_code; // Modal input value to test code
        $a = 0;
        $res = [];
        if(!empty($college_name)){
            $sql_cn = "SELECT `college_name` FROM `user_master` WHERE `user_master`.`user_id` = '$college_name' ";
            $res_cn = mysqli_query($this->conn, $sql_cn);
            if(mysqli_num_rows($res_cn)>0){
                $rows = mysqli_fetch_array($res_cn);
                $coll_name = $rows[0];
            }
        }

        if($user_type=="ADMIN"){

            $sql = "SELECT `user_master`.`email`,
                        `user_master`.`fname`,
                        `user_master`.`lname`,
                        `test_result`.`total_questions`, 
                        `test_result`.`total_marks`, 
                        `test_result`.`attempted_question`, 
                        `test_result`.`correct_answer`, 
                        `test_result`.`wrong_answer`, 
                        `test_result`.`obtain_marks` ,
                        `test_result`.`passing_percentages`,
                        `test_result`.`percentage`,
                        `test_result`.`result`,
                        `test_result`.`candidate_id`, 
                        `test_result`.`date_time`,
                        `test_result`.`result_id`,
                        `test_result`.`qp_id`
                    FROM `test_result`,`user_master` 
                    WHERE `user_master`.`user_id` = `test_result`.`candidate_id`";
        }
        else{
            $sql = "SELECT `user_master`.`email`,
                        `user_master`.`fname`,
                        `user_master`.`lname`,
                        `test_result`.`total_questions`, 
                        `test_result`.`total_marks`, 
                        `test_result`.`attempted_question`, 
                        `test_result`.`correct_answer`, 
                        `test_result`.`wrong_answer`, 
                        `test_result`.`obtain_marks` ,
                        `test_result`.`passing_percentages`,
                        `test_result`.`percentage`,
                        `test_result`.`result`,
                        `test_result`.`candidate_id`, 
                        `test_result`.`date_time`,
                        `test_result`.`result_id`,
                        `test_result`.`qp_id`
                        
                    FROM `test_result`,`user_master` 
                    WHERE `user_master`.`user_id` = `test_result`.`candidate_id` 
                    AND `user_master`.`register_by` = '$user_id'";
        }
        if(!empty($test_code)){
            $sql = $sql . " AND `test_result`.`qp_id` = '$test_code'";
        }
        if(!empty($college_name)){
            $sql = $sql . " AND `user_master`.`register_by` = '$college_name'";  // college name having registrar id
        }
        if(!empty($testcode)){
            $sql = $sql . " AND `test_result`.`qp_id` LIKE '%$testcode%'";
        }
        if(!empty($username)){
            $sql = $sql . " AND `user_master`.`fname` LIKE '%$username%'";
        }
        if(!empty($from_date) && empty($to_date)){
            $fromdate = $from_date.' 00:00:00';
			$todate = $from_date.' 23:59;59';
			$sql = $sql." AND (`test_result`.`date_time` between '$fromdate' and '$todate')";
        }
        if(!empty($to_date) && empty($from_date)){
            $sql = $sql." AND (`test_result`.`date_time` between '2015/01/01' and '$to_date')";
        }
        if(empty($from_date) && empty($to_date)){

        }
        if(!empty($from_date) && !empty($to_date)){
            $sql = $sql." AND (`test_result`.`date_time` between '$from_date' and '$to_date')";
        }
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
                                "passing_percentage"=>$rows[9],
                                "percentage"=>$rows[10],
                                "result"=>$rows[11],
                                "candidate_id"=>$rows[12],
                                "date"=>$rows[13],
                                "result_id"=>$rows[14],
                                "qp_id"=>$rows[15]
                            );
            }
            $total_users = sizeof($result);
            $result['college_name']= $coll_name;
            $result['total_users'] = $total_users;
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    // Function for view more data of result data on 
    public function view_more($data){
        
        $id = $data->id;
        //echo $id;
        $sql = "SELECT `user_master`.`email`,
                        `user_master`.`fname`,
                        `user_master`.`lname`,
                        `test_result`.`total_questions`, 
                        `test_result`.`total_marks`, 
                        `test_result`.`attempted_question`, 
                        `test_result`.`correct_answer`, 
                        `test_result`.`wrong_answer`, 
                        `test_result`.`obtain_marks`,
                        `test_result`.`passing_percentages`,
                        `test_result`.`percentage`,
                        `test_result`.`result`,
                        `test_result`.`candidate_id` ,
                        `test_result`.`date_time`,
                        `test_result`.`result_id`,
                        `test_result`.`qp_id`
                    FROM `test_result` 
                    INNER JOIN `user_master` 
                    ON `test_result`.`candidate_id` = `user_master`.`user_id` 
                    AND `test_result`.`result_id` = '$id'";

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
                                "passing_percentage"=>$rows[9],
                                "percentage"=>$rows[10],
                                "result"=>$rows[11],
                                "candidate_id"=>$rows[12],
                                "date"=>$rows[13],
                                "result_id"=>$rows[14],
                                "qp_id"=>$rows[15]
                            );
            }
            echo json_encode($result);
            
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    /* --------------------------   Admin Pages ------------------------------- */

    /* --------------------------  Change Password ----------------------------- */ 

    public function change_password($data){
        $old_pass = $data->old_pass;
        $new_pass = $data->new_pass;
        $sql_old_pass = "SELECT `password` FROM `user_master` WHERE `user_type` = 'ADMIN'";
        $res_old_pass = mysqli_query($this->conn,$sql_old_pass);
        if(mysqli_num_rows($res_old_pass)>0){
            $rows = mysqli_fetch_array($res_old_pass);
            if($old_pass == $rows[0]){
                $sql_update_pass = "UPDATE `user_master` SET `password` =  '$new_pass' WHERE `user_type` = 'ADMIN'";
                $res = mysqli_query($this->conn, $sql_update_pass);
                if($res == 1){
                    echo "TRUE";
                }
                else{
                    echo "FALSE";
                }
            }
            else{
                echo "INCORRECT";
            }
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    /* --------------------------  Subject Master ----------------------------- */ 

    // Function to show all subjects from subject_master table
    public function show_all_subjects(){
        $result = [];
        $sql = "SELECT `subject_id`,`subject_name` FROM `subject_master` WHERE `status` = 1 AND `subject_name` != 'RANDOM'";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $result[] = array("subject_id"=>$rows[0], "subject_name"=>$rows[1]);
            } 
            echo json_encode($result);
        }
        else{
            echo "No Records Found";
        }
    }

    // Function to add new subject to the Subject Master table
    public function add_subject($data){
        $subject_name = $data->subject;
        $subject_id = $this->getSubjectId();
        $sub_name = strtoupper($subject_name);
        //echo $sub_name;
        $sql_check = "SELECT `subject_name` FROM `subject_master` WHERE `subject_name` = '$sub_name'";
        $res_check = mysqli_query($this->conn, $sql_check);
        if(mysqli_num_rows($res_check)>0){
            echo "ALREADY EXSISTS";
        }else{
            $sql = "INSERT INTO `subject_master`(`subject_id`, `subject_name`,`status`) VALUES ('$subject_id','$sub_name',1)";
            $res = mysqli_query($this->conn, $sql);
            if($res){
                echo "SUCCESS";
            }
            else{
                echo "FAILED";
            }
        }
    }

    // Function to get subject id
    public function getSubjectId(){
        $sql = "SELECT `subject_id` FROM `subject_master` ORDER BY `subject_id` DESC LIMIT 1";
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)>0)
        {
            $rows = mysqli_fetch_array($result);
            //print_r($rows);
            $currentId = $rows['subject_id'];
            return ++$currentId;
            //echo $currentId;
        } 
        return "SUB001";
    }

    // Function to Remove Subject from subject_master table
    public function remove_subject($data){
        $sql = "UPDATE  `subject_master` SET `status`= 0 WHERE `subject_id` = '$data->id'";
        $res = mysqli_query($this->conn, $sql);
        if($res){
            echo "SUCCESS";
        }
        else{
            echo "FAILED";
            mysqli_error($this->conn);
        }
    }

    // Function to Update Subject name in subject master
    public function update_subject($data){
        $sub_name = $data->sub_name;
        $sub_id = $data->id;
        $sql = "UPDATE `subject_master` SET `subject_name` = '$sub_name' WHERE `subject_id` = '$sub_id' AND `status` = 1 ";
        $res = mysqli_query($this->conn,$sql);
        if($res){
            echo "SUCCESS";
        }
        else{
            echo "FAILED";
            echo mysqli_error($this->conn);
        }
    }

    // Function to search subject by keywords entered
    public function search_by_subject($data){
        //print_r($data);
        $keyword = $data->keyword;
        //echo $keyword;
        $sql = "SELECT DISTINCT `subject_id`, `subject_name` 
                FROM `subject_master` 
                WHERE `subject_name` 
                LIKE '%$keyword%' 
                AND `status` = 1";

        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $result[] = array("subject_id"=>$rows[0], "subject_name"=>$rows[1]);
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    /* --------------------------  User Master ----------------------------- */  

    // Function to show all users 
    public function show_all_users(){
        $result = [];
        $sql = "SELECT `user_master`.`user_id`,`user_master`.`fname`,`user_master`.`lname`,`user_master`.`email`, `user_master`.`mobile`, `user_master`.`status`, `user_master`.`user_type`  FROM `user_master` WHERE `user_type` != 'ADMIN' AND `status` = 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $name = $rows[1]. " " .$rows[2];
                $result[] = array("user_id"=>$rows[0], "name"=>$name, "email"=>$rows[3], "mobile"=>$rows[4], "status"=>$rows[5], "user_type"=>$rows[6]);
            } 
            echo json_encode($result);
        }
        else{
            echo "No Records Found";
        }
    }


    // Function to remove user 
    public function remove_user($data){
        $sql = "DELETE FROM `user_master` WHERE `user_id` = '$data->id'";
        $res = mysqli_query($this->conn, $sql);
        if($res){
            echo "SUCCESS";
        }
        else{
            echo "FAILED";
            echo mysqli_error($this->conn);
        }
    }

    // Function to edit Candidate Information
    function editUserInfo($data){
        $user_id = $data->user_id;
        $user_type = $data->user_type;

        $sql_check_permission = "SELECT DISTINCT(`candidate_id`) FROM `user_permissions` WHERE `candidate_id` = '$user_id'";
        $res_check_permission = mysqli_query($this->conn, $sql_check_permission);
        if(mysqli_num_rows($res_check_permission)==1){
            $sql = "SELECT `user_master`.`fname`, 
                        `user_master`.`lname`, 
                        `user_master`.`email`, 
                        `user_master`.`mobile`, 
                        `user_master`.`user_type`, 
                        `user_master`.`status`, 
                        `user_master`.`user_id`, 
                        `user_master`.`created`,
                        `user_permissions`.`access_question_bank`,
                        `user_permissions`.`create_question_bank`, 
                        `user_permissions`.`generate_test`,
                        `user_permissions`.`create_user`,
                        `user_permissions`.`view_result` 
                FROM `user_master`,`user_permissions` 
                WHERE `user_master`.`user_id` = '$user_id' 
                AND `user_permissions`.`candidate_id`='$user_id'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res)>0){
                $rows = mysqli_fetch_array($res);
                $result[] = array("fname"=>$rows[0],
                            "lname"=>$rows[1],
                            "email"=>$rows[2],
                            "mobile"=>$rows[3], 
                            "user_type"=>$rows[4], 
                            "status"=>$rows[5],
                            "user_id"=>$rows[6],
                            "created"=>$rows[7],
                            "access_question_bank"=>$rows[8],
                            "create_question_bank"=>$rows[9],
                            "generate_test"=>$rows[10],
                            "create_user"=>$rows[11],
                            "view_result"=>$rows[12]);
                echo json_encode($result);
            }
            else{
                echo mysqli_error($this->conn);
                echo "FAILED";
            }
        }
        else{
            $sql = "SELECT `user_master`.`fname`, 
                        `user_master`.`lname`, 
                        `user_master`.`email`, 
                        `user_master`.`mobile`, 
                        `user_master`.`user_type`, 
                        `user_master`.`status`, 
                        `user_master`.`user_id`,
                        `user_master`.`created` 
                    FROM `user_master` 
                    WHERE `user_master`.`user_id` = '$user_id'";    
            $res = mysqli_query($this->conn, $sql);
            if(mysqli_num_rows($res)>0){
                $rows = mysqli_fetch_array($res);
                $result[] = array("fname"=>$rows[0],
                            "lname"=>$rows[1],
                            "email"=>$rows[2],
                            "mobile"=>$rows[3], 
                            "user_type"=>$rows[4], 
                            "status"=>$rows[5],
                            "user_id"=>$rows[6],
                            "created"=>$rows[7]
                        ); 
                        echo json_encode($result);
            }else{
                echo mysqli_error($this->conn);
                echo "FAILED";
            }    
        }   
    }

    // Function to update Candidate Information
    public function updateUserInfo($data){
        $user_id = $data->user_id;
        $first_name = $data->first_name;
        $last_name = $data->last_name;
        $mobile = $data->mobile;
        $user_type = $data->user_type;
        $permission = $data->permission;
        $status = $data->status;
        //echo $status;
        $createDate = Format::getCurrentDateTime();
        $lastActivity = Format::getCurrentDateTime();
        $correct = 0;
        // check if Empty permissions or not 
        if(empty($permission)){
            
            $sql = "UPDATE `user_master` SET `fname`='$first_name',`lname`='$last_name',`mobile`='$mobile', `user_type` = '$user_type', `status` = '$status'  WHERE `user_id` = '$user_id'";
            //return;
            $res = mysqli_query($this->conn, $sql);
            if($res){
                echo "SUCCESS";
            }
            else{
                echo mysqli_error($this->conn);
                echo "FAILED";
            }
        }

        // Check if Permissions are set 
        if(!empty($permission)){
            // Insert data in User Permissions table   
            $sql = "UPDATE `user_master` SET `fname`='$first_name',`lname`='$last_name',`mobile`='$mobile', `user_type` = '$user_type', `status` = '$status' WHERE `user_id` = '$user_id'";    
            $res = mysqli_query($this->conn, $sql);
            if($res){
                $correct = 1;
            }
            else{
                echo mysqli_error($this->conn);
                echo "FAILED";
            }

            $gt=0;$cqb=0;$cu=0;$aqb=0;$vr=0;
            $candidateId = $this->getCandidateId($user_id);

            $permissionId = $this->getPermissionId();
            for($i = 0 ; $i < count($permission) ; $i++){
                if($permission[$i]=="GENERATE_TEST"){
                    $gt = 1;
                }
                if($permission[$i]=="CREATE_QUESTION_BANK"){
                    $cqb = 1;
                }
                if($permission[$i]=="CREATE_USER"){
                    $cu = 1;
                }
                if($permission[$i]=="ACCESS_QUESTION_BANK"){
                    $aqb = 1;
                }
                if($permission[$i]=="VIEW_RESULT"){
                    $vr = 1;
                }
            }
            
            // if candidate id is 0 then insert new Entry
            if($candidateId!=0){
                echo $candidateId;
                $sql_permission = "INSERT INTO `user_permissions` (`permission_id`,`candidate_id`, `generate_test`,`create_question_bank`,`access_question_bank`,`create_user`,`view_result`,`created_at`) VALUES ('$permissionId','$user_id','$gt','$cqb','$aqb','$cu','$vr','$createDate')";
                $res_permission = mysqli_query($this->conn,$sql_permission);

                if($res_permission > 0){
                    if($correct==1){
                        echo "SUCCESS"; //successful user creation message
                    }
                }
                else{
                    echo mysqli_error($this->conn);
                }
            } 

            // if candidate id is available then update The record
            if($candidateId==0){
                $sql_permission = "UPDATE `user_permissions` SET `generate_test` = '$gt', `create_question_bank` = '$cqb', `access_question_bank` = '$aqb', `create_user` = '$cu', `view_result` = '$vr', `last_activity` = '$lastActivity'";
                $res_permission = mysqli_query($this->conn, $sql_permission);
                if($res_permission){
                    echo "SUCCESS";
                }
                else{
                    echo "FAILED";
                    echo mysqli_error($this->conn);
                }
            }
        }
    }


    /* --------------------------   Users Pages(Heigher) ------------------------------- */

    public function show_result_count($data){
        $user_id = $data->userId;
        $sql = "SELECT COUNT(*) AS `result_count` FROM `test_result`, `user_master` WHERE `test_result`.`candidate_id` = `user_master`.`user_id` AND `user_master`.`register_by` = '$user_id'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0)
        {
            $rows = mysqli_fetch_array($res);
            echo $rows[0];
        }
        else{
            echo mysqli_error($this->conn);
            echo "FAILED";
        }
    }

    
    public function show_candidate_count($data){
        $user_id = $data->userId;
        $sql = "SELECT COUNT(*) AS `candidate_count` FROM `user_master` WHERE `user_master`.`register_by` = '$user_id' && `status`= '1'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0)
        {
            $rows = mysqli_fetch_array($res);
            echo $rows[0];
        }
        else{
            echo mysqli_error($this->conn);
            echo "FAILED";
        }
    }

    public function getPermissionId(){
        $sql = "SELECT `permission_id` FROM `user_permissions` ORDER BY `permission_id` DESC LIMIT 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            return ++$rows[0];
        }
        return 1;
    }

    public function getCandidateId($user_id){
        $sql = "SELECT `candidate_id` FROM `user_permissions` WHERE `candidate_id` = '$user_id' ORDER BY `last_activity` DESC";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            return $rows[0];
        }
        return 0;
    }

    // Get users Pagination
    public function getUsersPagination($data){        
        $page = 0;
        //echo isset($data->page);
        if(!isset($data->page)){
            $page = 1;
        }
        else{
            $page = $data->page;
        }
        $i= 0;
        $result_arr = array();
        $sql = "SELECT count(*) AS `total` FROM `user_master` WHERE `status` = 1";
        $total_rec =mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($total_rec)>0)        
        {
            // Total Records present in table having status is equal to 1
            $row = mysqli_fetch_array($total_rec);
            
            $rpp = 15;                               // rpp = rows per page
            //$total_pages = floor($total_rec/$rpp); 
            $total_pages = ceil($row['total'] / $rpp);
            //echo $total_pages;
            $rsf=($page * $rpp)-$rpp;               // rsf = row start from 

            $limit = "$rsf,$rpp";

            $sql = "SELECT DISTINCT `fname`, `lname`,`email`,`mobile`,`user_type`, `user_id` from `user_master` where `user_master`.`user_type` != 'ADMIN' AND `status` = 1 ORDER BY `user_id` LIMIT $limit";
            $result = mysqli_query($this->conn, $sql);
           
             if(mysqli_num_rows($result)>0){
                while($rows = mysqli_fetch_array($result)){
                    $name = $rows[0]. " " .$rows[1]; 
                     $result_arr[] = array("name"=>$name,
                                    "email"=>$rows[2],
                                    "mobile"=>$rows[3],
                                    "user_type"=>$rows[4],
                                    "user_id"=>$rows[5]
                                );
                }
                $rpp = sizeof($result_arr);
                $result_arr['total_pages'] = $total_pages;
                $result_arr['total_rec'] = $row['total'];
                $result_arr['record_per_page'] = $rpp;
                $result_arr['row_start_from'] = $rsf;
                $result_arr['page_no'] = $page;
                echo json_encode($result_arr);
             }
        }  
    }

}
?>