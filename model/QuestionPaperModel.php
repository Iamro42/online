<?php
include "Connections.php";
include 'AppLib.php';
class QuestionPaperModel{
    private $conn;
    private $connection;
    public function __construct(){
        //session_start();
        $this->connection = new Connection();
        $this->conn = $this->connection->createConnection();   
         
    }

    public function __destruct(){
        $this->connection->closeConnection($this->conn);
    }

    public function filterData($data){
        // print_r($data);
        $subject = $data->subject;
        $que_type = $data->que_type;
        $sort = $data->sort;
        $limit = $data->limit;

        if($limit != 0){
            $limit = "LIMIT ". $limit;
        }

        if($que_type=="random"){
            $sql = "SELECT `question`, `correct_ans` FROM `question_master` `subject_id`='$subject' ORDER BY RAND(), `question` ASC $limit";
            $res = mysqli_query($this->conn, $sql);
            if(mysqli_num_rows($res)>0){
                while($rows=mysqli_fetch_array($res))
                {
                    $result[] = array("question"=>$rows[0],"correct_ans"=>$rows[1]);
                }
                echo json_encode($result);
            }
        }
    }


    // function for Sort values according Input ( This solution needs proper filtration )

    public function create_normal_test($data){
        $created_by = $data->userId;
        $easy = $data->easy;
        $medium = $data->medium;
        $hard = $data->hard;
        $sub = $data->sub;
        $time = $data->time;
        $negative = $data->negative;
        $passing_marks = $data->passing_marks;
        $createDate = Format::getCurrentDateTime();
        $ct = 0;
        $result = array();
        if($easy==""){
            $easy = 0;
        }
        if($medium==""){
            $medium = 0;
        }
        if($hard==""){
            $hard = 0;
        }

        $sql_e = "SELECT `question_id` FROM `question_master` WHERE (`priority` = 1 AND `status`= 1) AND `subject_id`= '$sub' ORDER BY RAND() LIMIT $easy ";
        $res = mysqli_query($this->conn, $sql_e);

        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $ct++;
                array_push($result,$rows[0]);
               
            }
            if($ct < $easy){
                echo "EASY ";
            }
        }
        $sql_m = "SELECT `question_id` FROM `question_master` WHERE (`priority` = 2 AND `status`= 1) AND `subject_id`= '$sub' ORDER BY RAND() LIMIT $medium ";
        $res_m = mysqli_query($this->conn,$sql_m);
        if(mysqli_num_rows($res_m)>0){
            while($rows = mysqli_fetch_array($res_m)){
                $ct++;
                array_push($result,$rows[0]);
            }
            if($ct < $medium){
                echo "MEDIUM ";
            }
        }
        $sql_h = "SELECT `question_id` FROM `question_master` WHERE (`priority` = 3 AND `status`= 1) AND `subject_id`= '$sub' ORDER BY RAND() LIMIT $hard ";
        $res_h = mysqli_query($this->conn,$sql_h);
        if(mysqli_num_rows($res_h)>0){
           
            while($rows = mysqli_fetch_array($res_h)){
                $ct++;
                //echo $rows[0];
                array_push($result,$rows[0]);   
                //print_r($rows[0]);             
            }
            if($ct < $hard){
                echo "HARD ";
            }
        }
        $total = sizeof($result);
        //print_r($result);
        $count1 = $easy + $medium + $hard;
        if($total != $count1){
            echo "FAILED";
            // echo $total;
            // echo $count1;
        }
        else{
            if(!empty($result)){
                $result = implode(" ,", $result);                
                $qp_id = $this->getQuestionPaperId($sub);
                $sub_code = substr($sub,3);                
                $qp_id = "QPS"."/$sub_code/"."$qp_id";
                $qp_id;
                $sql_insert = "INSERT INTO `online_exam_portal`.`question_paper` (`qp_id`,`question_id`,`passing_marks`,`negative`,`status`,`created_by`,`created_date`,`total_question`,`test_type`,`time`) VALUES ('$qp_id', '$result', '$passing_marks', '$negative', '1','$created_by', '$createDate', $total, '$sub', '$time')";
                $res = mysqli_query($this->conn, $sql_insert);
                if($res>0){
                    echo "SUCCESS";
                }
                else{
                    echo mysqli_error($this->conn);
                }
            }
        }
    }

    // function for select random question's from question master 

    public function create_random_test($data){
        $count = 0;
        $sql = "";
        $negative = $data->negative;
        $time = $data->time;
        $total = $data->total_questions;
        $subject = $data->subject;
        $created_by = $data->userId;
        $passing_marks = $data->passing_marks;
        $createDate = Format::getCurrentDateTime();
        $sub_id = "";
        $result = array();
        $subject;
        if($subject==1){            
            $sql = "SELECT `question_id` FROM `question_master` WHERE `status`= 1 ORDER BY RAND() LIMIT $total";
        }
        else{
            $sql = "SELECT `question_id` FROM `question_master` WHERE `status`= 1 AND `subject_id` = '$subject' ORDER BY RAND() LIMIT $total";
        }
        //echo $sql;
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0)
        {
            while($rows = mysqli_fetch_array($res)){
                $count++;
                array_push($result,$rows[0]);
            }
            //create_test($result);
        }
        //echo $count;
        
        // Select subject id of Random subject (query)
        $sub_id_ran = "";
        $sql_sub_id = "SELECT `subject_id` FROM `subject_master` WHERE `subject_name`='RANDOM'";
        $res_sub_id = mysqli_query($this->conn, $sql_sub_id);
        
        if(mysqli_num_rows($res_sub_id)>0){
            $sub_id_ran = mysqli_fetch_array($res_sub_id);
            $sub_id = $sub_id_ran[0];     
        }

        // select subject name of subject selected during random test creation
        if($subject!=1){
            $sql_sub_name = "SELECT `subject_name` FROM `subject_master` WHERE `subject_id`='$subject'";
        }
        else{
            $sql_sub_name = "SELECT `subject_name` FROM `subject_master` WHERE `subject_id`='$subject'";
        }
        $res_sub_name = mysqli_query($this->conn, $sql_sub_name);

         if(mysqli_num_rows($res_sub_id)>0){
            $sub_name_ran = mysqli_fetch_array($res_sub_name);
            $sub_name = $sub_name_ran[0];     
        }
        
        if($count!=$total){
            echo "FAILED";
        }
        else{    
            if(!empty($result)){
                $result = implode(" ,", $result);
                //echo "Subject Code ".$sub_id;
                $qp_id = $this->getQuestionPaperId($sub_id);
                $sub_code = substr($sub_id,3);                
                $qp_id = "QPS"."/$sub_code/"."$qp_id";
                //echo $sub_id;
                $sql_insert = "INSERT INTO `online_exam_portal`.`question_paper` (`qp_id`,`question_id`,`passing_marks`,`negative`,`status`,`created_by`,`created_date`,`total_question`,`test_type`,`subject_name`,`time`) VALUES ('$qp_id', '$result','$passing_marks','$negative', '1','$created_by', '$createDate',$total,'$sub_id','$sub_name','$time')";
                $res = mysqli_query($this->conn, $sql_insert);
                if($res>0){
                    echo "SUCCESS";
                }
                else{
                    echo mysqli_error($this->conn);
                }
            }
        }
        //echo json_encode($result);
    }

    

    // function for get Question Paper Id from `question_master table`

    private function getQuestionPaperId($sub_id){
        $sql = "SELECT `question_paper`.`qp_id` FROM `online_exam_portal`.`question_paper` WHERE `test_type` = '$sub_id'  ORDER BY `created_date` DESC LIMIT 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $qp_id = substr($rows[0],8);
            //echo ++$qp_id."question paper id";
            return ++$qp_id;
        }
        return 1;
    }



    // Function for showing questions ( while Insrting we convert string to array conversion) Now need to convert those question array to string

    public function show_test(){
        $sql_show = "SELECT `question_id` FROM `question_paper` WHERE `qp_id`=1";
        $res = mysqli_query($this->conn,$sql_show);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
        print_r($rows);
            
        }
        else{
            echo mysqli_error($this->conn);
        }
    }



    // Functions For Question paper Dashboard

    public function show_subject_test($data){
        //print_r($data);
        $user_id = $data->userId;
        $user_type = $data->userType;
        $sql = "";
        $result = array();
        // select subject name on random test generated if subject wise random test is created (query)
        $select_sub_name = "";
        if($user_id == "ADMIN"){
        $sql = "SELECT 
                `question_paper`.`qp_id`,
                `question_paper`.`created_date`,
                `question_paper`.`total_question`,
                `question_paper`.`time`,
                `question_paper`.`status`,
                `question_paper`.`subject_name`,
                `subject_master`.`subject_name`
                FROM `question_paper` 
                INNER JOIN `subject_master` 
                ON `subject_master`.`subject_id` = `question_paper`.`test_type`
                WHERE `question_paper`.`status`=1 ORDER BY `created_date` DESC" ;
        }
        else{
            $sql = "SELECT 
            `question_paper`.`qp_id`,
            `created_date`,
            `question_paper`.`total_question`,
            `question_paper`.`time`,
            `question_paper`.`status`,
            `question_paper`.`subject_name`,
            `subject_master`.`subject_name`
            FROM `question_paper` 
            INNER JOIN `subject_master` 
            ON `subject_master`.`subject_id` = `question_paper`.`test_type`
            WHERE `question_paper`.`status`=1 AND `created_by` = '$user_id' ORDER BY `created_date` DESC" ;
        }
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res))
            {
                $result[] = array("qp_id"=>$rows[0], "created_date"=>date('d-M-Y',strtotime($rows[1])), "total_question"=>$rows[2], "time"=>$rows[3],"status"=>$rows[4], "test_name"=>$rows[5], "subject_name"=>$rows[6]);
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    // Function for count Number of Questions available in database table question_paper
    public function count_question(){
        $num = 0;
        $sub_name = '';
        $results = array();
        $arr_count_priority = array();
        $sql = "SELECT `subject_id`,`subject_name` FROM `subject_master` where `subject_name` != 'RANDOM'";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $sub_name = $rows[1];  
                $sub_id = $rows[0];
                $sql_count_sub = "SELECT count(`question_id`) AS count_sub FROM `question_master` WHERE `subject_id` = '$sub_id'";
                $res_count_sub = mysqli_query($this->conn, $sql_count_sub);
                if(mysqli_num_rows($res_count_sub)>0){
                    while($rows = mysqli_fetch_array($res_count_sub)){
                        $results = array("$sub_id"=> $rows[0]);
                        // check for multiple rows using for loop
                        for($i = 1; $i<= sizeof($results); $i++)
                        {
                            for($k = 1; $k<=3; $k++)
                            {
                                $sql_count_priority = "SELECT COUNT(`question_id`) AS count_pri FROM `question_master` WHERE `priority` = $k AND `subject_id` = '$sub_id' AND `status` = 1";
                                $res_count_priority = mysqli_query($this->conn,$sql_count_priority);
                                if(mysqli_num_rows($res_count_priority)>0)
                                {
                                    while($rows_count_priority= mysqli_fetch_array($res_count_priority))
                                    {
                                        //$num = $num+1;
                                        $arr_count_priority[] = array("priority".$k =>$rows_count_priority[0], "sub"=>$sub_name);
                                    }
                                                                    
                                }

                            }                        
                            
                        } // outer for loop Ends here

                    }
                    
                }            
                
            }
            echo json_encode($arr_count_priority);
        }
        
    } 

    // show question paper information on show button clicked
    function question_info($data){
        $question_paper_id = $data->question_paper_id;
        //echo $question_paper_id;
        $sql = "SELECT `question_id`, `status`, `negative` FROM `question_paper` WHERE `qp_id` = '$question_paper_id'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $str = $rows[0];        
            $arr = explode(",", $str);
            $low = 0; $medium = 0; $high = 0; $status = $rows[1]; $negative = $rows[2];
            for($i = 0; $i< sizeof($arr); $i++){
                $sql_arr = "SELECT DISTINCT(`question_master`.`priority`) FROM `question_master` INNER JOIN `question_paper` ON `question_master`.`question_id` = '$arr[$i]' ";
                $res_arr = mysqli_query($this->conn, $sql_arr);
                if(mysqli_num_rows($res_arr)>0){
                    while($rows = mysqli_fetch_array($res_arr)){
                        if($rows[0]==1){
                            $low++;
                        }
                        if($rows[0]==2){
                            $medium++;
                        }
                        if($rows[0]==3){
                            $high++;
                        }
                    }
                    
                }
                
            }       
                    //$status = $rows[1];
                    $result['low'] = $low;
                    $result['medium'] = $medium;
                    $result['high'] = $high; 
                    $result['status'] = $status;
                    $result['negative'] = $negative;
                    echo json_encode($result);                      
        }
    }

    // function for remove Question paper set from database or change status of paper set
    function remove($data){
        $id = $data->id;
        
        //echo $id;
        $sql = "DELETE FROM `question_paper` WHERE `qp_id` = '$id'";
        $res = mysqli_query($this->conn, $sql);
        if($res){
            echo "SUCCESS";
        } 
        else{
            echo "FAILED";
        }

    }


    // Function to show question paper code 
    public function show_test_code(){
        $sql = "SELECT `qp_id` FROM `question_paper`  WHERE `status` = 1 ORDER BY `qp_id`";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res)){
                $result[] = array("test_code"=>$rows[0]);
            }
            echo json_encode($result);
        }
        
    }

    // function to get count of tests generated by logged in user

    public function get_test_count($data){
        $user_id = $data->userId;
        $sql = "SELECT COUNT(*) AS `test_count` FROM `question_paper` WHERE `created_by` = '$user_id'"; 
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            echo $rows[0];
        }
        else{
            echo mysqli_error($this->conn);
            echo "FAILED";
        }
    }


    // Function to get count of easy Question
    public function easy_question($data){
        $sub = $data->sub_id;
        $easy = $data->question;
        $sql = "SELECT COUNT(*) AS `easy_question` FROM `question_master` WHERE (`priority` = 1 AND `status`= 1) AND `subject_id`= '$sub' LIMIT $easy ";
        $res = mysqli_query($this->conn,$sql);
        //print_r($res);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            //echo $rows[0];
            if($easy>$rows[0]){
                echo "FALSE";
            }
            elseif($easy==0){
                echo "TRUE";
            }
            else{
                echo "TRUE";
            }
        }
        else{
            echo mysqli_error($this->conn);
        }
    }


    // function to get countr of medium questions
    public function medium_question($data){
        $sub = $data->sub_id;
        $medium = $data->question;
        $sql = "SELECT COUNT(*) AS `easy_question` FROM `question_master` WHERE (`priority` = 2 AND `status`= 1) AND `subject_id`= '$sub' LIMIT $medium ";
        $res = mysqli_query($this->conn,$sql);
        //print_r($res);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            //echo $rows[0];
            if($medium>$rows[0]){
                echo "FALSE";
            }
            else{
                echo "TRUE";
            }
        }
        elseif($medium==0){
                echo "TRUE";
            }
        else{
            echo mysqli_error($this->conn);
        }
    }


    // function to get count of hard questions
    public function hard_question($data){
        $sub = $data->sub_id;
        $hard = $data->question;
        $sql = "SELECT COUNT(*) AS `easy_question` FROM `question_master` WHERE (`priority` = 3 AND `status`= 1) AND `subject_id`= '$sub' LIMIT $hard ";
        $res = mysqli_query($this->conn,$sql);
        //print_r($res);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            //echo $rows[0];
            if($hard>$rows[0]){
                echo "FALSE";
            }        
            else{
                echo "TRUE";
            }
        }
        elseif($hard==0){
                echo "TRUE";
            }
        else{
            echo mysqli_error($this->conn);
        }
    }


    // function to get count of random question
    public function random_question($data){
        //print_r($data);
        //echo "Yes";
        $total = $data->question;
        $sub_id = $data->sub_id;
        //$sql = "";
        //echo $total;
        if($sub_id==1){            
            $sql = "SELECT COUNT(`question_id`) AS `questions` FROM `question_master` WHERE `status`= 1 ORDER BY RAND() LIMIT $total";
        }
        else{
            $sql = "SELECT COUNT(`question_id`) AS `questions` FROM `question_master` WHERE `status`= 1 AND `subject_id` = '$sub_id' ORDER BY RAND() LIMIT $total";        
        }

        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
                //print_r($rows);
                if($total>$rows[0]){
                    echo  "FALSE";
                }
                else{
                    echo "TRUE";
                }
            
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    public function search_by_sub_name($data){
        //print_r($data);
        $sub_name = $data->subject_name;
        $user_id = $data->userId;
        $user_type = $data->userType;
        $sql = "";
        $result = array();
        // select subject name on random test generated if subject wise random test is created (query)
        $select_sub_name = "";
        if($user_id == "ADMIN"){
        $sql = "SELECT 
                `question_paper`.`qp_id`,
                `question_paper`.`created_date`,
                `question_paper`.`total_question`,
                `question_paper`.`time`,
                `question_paper`.`status`,
                `question_paper`.`subject_name`,
                `subject_master`.`subject_name`
                FROM `question_paper` 
                INNER JOIN `subject_master` 
                ON `subject_master`.`subject_id` = `question_paper`.`test_type`
                WHERE `question_paper`.`test_type` = '$sub_name' AND `question_paper`.`status` = 1 ORDER BY `created_date` DESC" ;
        }
        else{
            $sql = "SELECT 
            `question_paper`.`qp_id`,
            `created_date`,
            `question_paper`.`total_question`,
            `question_paper`.`time`,
            `question_paper`.`status`,
            `question_paper`.`subject_name`,
            `subject_master`.`subject_name`
            FROM `question_paper` 
            INNER JOIN `subject_master` 
            ON `subject_master`.`subject_id` = `question_paper`.`test_type`
            WHERE `question_paper`.`test_type` = '$sub_name' AND `question_paper`.`status` = 1 AND `created_by` = '$user_id' ORDER BY `created_date` DESC" ;
        }
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res))
            {
                $result[] = array("qp_id"=>$rows[0], "created_date"=>date('d-M-Y',strtotime($rows[1])), "total_question"=>$rows[2], "time"=>$rows[3],"status"=>$rows[4], "test_name"=>$rows[5], "subject_name"=>$rows[6]);
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }

    }

    // Search by Date

    public function search_by_date($data){
        //print_r($data);
        $user_id = $data->userId;
        $user_type = $data->userType;
        $from_date = $data->from_date;
        $to_date = $data->to_date;
        $filterBy = $data->filterBy;
        $sql = "";
        $result = array();
        // select subject name on random test generated if subject wise random test is created (query)
        $select_sub_name = "";

        if($user_type != "ADMIN"){
            $userId = "AND `register_by` = '$user_id'";
        }
        else{
            $userId = "";
        }

        if($filterBy == "date"){
            if(!empty($from_date) && empty($to_date)){
                $sql = "SELECT `question_paper`.`qp_id`,
                                `question_paper`.`created_date`,
                                `question_paper`.`total_question`,
                                `question_paper`.`time`,
                                `question_paper`.`status`,
                                `question_paper`.`subject_name`,
                                `subject_master`.`subject_name` 
                        FROM `question_paper`
                        INNER JOIN `subject_master`
                        ON `subject_master`.`subject_id` = `question_paper`.`test_type` 
                        where `question_paper`.`status` = 1 AND `created_date` >= '$from_date'" . $userId;
            }
            if(!empty($to_date) && empty($from_date)){
                $sql = "SELECT `question_paper`.`qp_id`,
                                `question_paper`.`created_date`,
                                `question_paper`.`total_question`,
                                `question_paper`.`time`,
                                `question_paper`.`status`,
                                `question_paper`.`subject_name`,
                                `subject_master`.`subject_name` 
                        FROM `question_paper`
                        INNER JOIN `subject_master`
                        ON `subject_master`.`subject_id` = `question_paper`.`test_type` 
                        where `question_paper`.`status` = 1 AND `created_date` <= '$to_date' " . $userId;
            }
            if(!empty($from_date) && !empty($to_date)){
                $sql = "SELECT `question_paper`.`qp_id`,
                                `question_paper`.`created_date`,
                                `question_paper`.`total_question`,
                                `question_paper`.`time`,
                                `question_paper`.`status`,
                                `question_paper`.`subject_name`,
                                `subject_master`.`subject_name` 
                        FROM `question_paper`
                        INNER JOIN `subject_master`
                        ON `subject_master`.`subject_id` = `question_paper`.`test_type`
                        WHERE `question_paper`.`status` = 1 AND `created_date` BETWEEN '$from_date' AND '$to_date' " . $userId;
            }
        }

        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            while($rows = mysqli_fetch_array($res))
            {
                if($rows[6]=="RANDOM")
                continue;
                $result[] = array("qp_id"=>$rows[0], "created_date"=>date('d-M-Y',strtotime($rows[1])), "total_question"=>$rows[2], "time"=>$rows[3],"status"=>$rows[4], "test_name"=>$rows[5], "subject_name"=>$rows[6]);
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

}
?>
