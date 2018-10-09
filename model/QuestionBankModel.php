<?php
include "Connections.php";
class QuestionBankModel{
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


     // function to get last Question id
    public function getCurrentId(){
        $sql = "SELECT `question_id` FROM `question_master` ORDER BY `question_id` DESC LIMIT 1";
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)>0)
        {
            $rows = mysqli_fetch_array($result);
            //print_r($rows);
            $currentId = $rows['question_id'];
            return ++$currentId;
            //echo $currentId;
        } 
        return 1;
        
    }


    // Function to add New Question
    public function addNewQuestion($data){
        
        $id = $this->getCurrentId();
        $user_id = $data->userId;
        $subject = $data->subject;
        $question =$data->question;
        $option1 = $data->option1;
        $option2 = $data->option2;
        $option3 = $data->option3;
        $option4 = $data->option4;
        $add_explaination = $data->explaination;
        $correct_ans = $data->correct_answer;
        $priority = $data->priority;
        
        // $question_with_tick = mysqli_real_escape_string($question);
        // echo $question_with_tick;
        //SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` FROM `question_master` WHERE `question` LIKE '%What is Function?%'
        $check_question_sql="SELECT `question` FROM `question_master` WHERE `question` LIKE '%<p>$question</p>%' AND`status` ";
        $check_result = mysqli_query($this->conn,$check_question_sql);
        if(mysqli_num_rows($check_result)>0){
            echo "Question is Present";
           
            return;
        }
        else{
            $sql = "INSERT `question_master`(`question_id`,`subject_id`,`question`,`option1`,`option2`,`option3`,`option4`,`correct_ans`,`priority`,`explaination`,`topic_id`,`status`,`created_by`) 
            VALUES('$id','$subject','$question','$option1','$option2','$option3','$option4','$correct_ans','$priority','$add_explaination','0','1','$user_id')";
            $result = mysqli_query($this->conn,$sql);
            if($result){
                echo "SUCCESS";
            }
            else{
                echo "FAILED";
                echo mysqli_error($this->conn);
            }
        //echo "addNew question";
        }
    }

    

    // function to get All subject list
    public function getSubjects(){
        //echo $conn;
        $sql = "SELECT * FROM `subject_master` WHERE `status` = 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0)
        {
            while($rows=mysqli_fetch_array($res))
            {
                $result[] = array("sub_id"=>$rows[0],"sub_name"=>$rows[1]);
            }
            echo json_encode($result);
        }
        else
        {
            echo mysqli_error($conn);
        }
    }

    // function to get all Question and Answers on Window load to the table
    function getQuestionBank(){
        $sqlq = "SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` from `question_master` where `status`= 1";
        $resq = mysqli_query($this->conn, $sqlq);
        if(mysqli_num_rows($resq)>0)
        {
            
            while($rows=mysqli_fetch_array($resq))
            {
                // $ans=$rows['correct_ans'];
                // echo $rows[$ans];
                // print_r($rows);
                $result[] = array("question_id"=>$rows[0],
                                    "question"=>ucfirst($rows[1]),
                                    "correct_answer"=>$rows[$rows[6]]
                                );
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    } 

    // function for Remove Question
    function removeQuestion($data){
        $que_id = $data->question_id;
        //echo $que_id;
        $sql = "UPDATE `question_master` SET `status`= 0 WHERE `question_id`= $que_id";
        $res = mysqli_query($this->conn, $sql);
        if($res){
            echo "SUCCESS";
        }
        else{
            echo "FAILED";
            echo mysqli_error($this->conn);
        }
    }

    // function to show data in modal on click view button
    function viewQuestion($data){
        $que_id = $data->question_id;
        $sql = "SELECT `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans`,`priority`,`explaination`,`question_id` FROM `question_master` WHERE `question_id`= $que_id";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0)
        {
                $rows = mysqli_fetch_array($res);
                $result = array("question"=>$rows[0],
                                    "option1"=>$rows[1],
                                    "option2"=>$rows[2],
                                    "option3"=>$rows[3],
                                    "option4"=>$rows[4],                                    
                                    "correct_option"=>$rows[5],
                                    "correct_answer"=>$rows[$rows[5]],
                                    "priority"=>$rows[6],
                                    "explaination"=>$rows[7],
                                    "que_id"=>$rows[8]
                                );
            
            echo json_encode($result);
        }
        else if(mysqli_num_rows($res)==0){
            echo "No Records Found";
        }
        else{
            echo mysqli_error($this->conn);
        }
        
    }

    // Function for Filter questions Subject and priority wise
    function filterData($data){
        $subject = $data->subject;
        $priority = $data->priority;
        $sql = "";
        if($priority==""){
            $sql = "SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` from `question_master` where `subject_id`= '$subject' AND `status`='1'";
        }
        if($subject!="" && $priority != ""){
            $sql = "SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` from `question_master` where (`subject_id`= '$subject' AND `priority`= '$priority') AND `status`='1'";
        }
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0)
        {
            while($rows=mysqli_fetch_array($res))
            {
                $result[] = array("question_id"=>$rows[0],
                                    "question"=>$rows[1],
                                    "correct_answer"=>$rows[$rows[6]]
                                );
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    // Search data from Searching keywords
    function searchKeyword($data){
        $keywords = $data->keyword;
        $sql_search = "SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` FROM `question_master` WHERE `question` LIKE '%$keywords%' AND `status`='1'";
        $res = mysqli_query($this->conn, $sql_search);
        if(mysqli_num_rows($res)>0)
        {
            while($rows=mysqli_fetch_array($res))
            {
                $result[] = array("question_id"=>$rows[0],
                                    "question"=>$rows[1],
                                    "correct_answer"=>$rows[$rows[6]]
                                );
            }
            echo json_encode($result);
        }
        else{
            echo mysqli_error($this->conn);
        }
    }

    // function for Edit Question / Update Question
    function editQuestion($data){
        $question_id = $data->question_id;
        $question = $data->question;
        $option1 = $data->option1;
        $option2 = $data->option2;
        $option3 = $data->option3;
        $option4 = $data->option4;
        $correct_ans = $data->correct_answer;
        $priority = $data->priority;
        $explaination = $data->explaination;
        if($question_id != "" ){
            $sql = "UPDATE `question_master` SET `question`='$question',`option1`='$option1',`option2`='$option2',`option3`='$option3',`option4`='$option4',`correct_ans`='$correct_ans',`priority`='$priority',`explaination`='$explaination' WHERE `question_id`='$question_id'";
            $result = mysqli_query($this->conn,$sql);
            if($result){
                echo 1;
            }
            else{
                echo 0;
            }
        }
        else{
            echo mysqli_error($this->conn);
        }
    }


     // function for get Pagination
    
    public function getPagination($data){
        //print_r($data);
        $page = 0;
        //echo isset($data->page);
        if(!isset($data->page)){
            $page = 1;
        }
        //echo "page number".$data->page;
        // if($data->page == Undefined || $data->page ==null){
        //     $page = 1;
        // }
        else{
            $page = $data->page;
        }
        $i= 0;
        $result_arr = array();
        $sql = "SELECT count(*) AS `total` FROM `question_master` WHERE `status` = 1";
        $total_rec =mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($total_rec)>0)        
        {
            // Total Records present in table having status is equal to 1
            $row = mysqli_fetch_array($total_rec);
            
            $rpp = 8;                               // rpp = rows per page
            //$total_pages = floor($total_rec/$rpp); 
            $total_pages = ceil($row['total'] / $rpp);
            //echo $total_pages;
            $rsf=($page * $rpp)-$rpp;               // rsf = row start from 

            $limit = "$rsf,$rpp";

            $sql = "SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` from `question_master` where `status`= 1 ORDER BY `question_id` DESC LIMIT $limit";
            $result = mysqli_query($this->conn, $sql);
           
             if(mysqli_num_rows($result)>0){
                while($rows = mysqli_fetch_array($result)){
                     $result_arr[] = array("question_id"=>$rows[0],
                                    "question"=>$rows[1],
                                    "correct_answer"=>$rows[$rows[6]]
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

    // function to get Search Pagination for the questions which are searched by select box
    public function getSearchPagination($data){
        $subject = $data->subject;
        $priority = $data->priority;
        //print_r($data);
        $page = 0;
        //echo isset($data->page);
        if(!isset($data->page)){
            $page = 1;
        }
        //echo "page number".$data->page;
        // if($data->page == Undefined || $data->page ==null){
        //     $page = 1;
        // }
        else{
            $page = $data->page;
        }
        $sql = "";
        $i= 0;
        $result_arr = array();

        
        if($priority==""){
            $sql = "SELECT count(*) AS `total` from `question_master` where `subject_id`= '$subject' AND `status`='1'";
        }
        if($subject!="" && $priority != ""){
            $sql = "SELECT count(*) AS `total` from `question_master` where (`subject_id`= '$subject' AND `priority`= '$priority') AND `status`='1'";
        }

        $total_rec =mysqli_query($this->conn, $sql);
        //print_r($total_rec);
        if(mysqli_num_rows($total_rec)>0)        
        {
            // Total Records present in table having status is equal to 1
            $row = mysqli_fetch_array($total_rec);
            
            $rpp = 8;                               // rpp = rows per page
            //$total_pages = floor($total_rec/$rpp); 
            $total_pages = ceil($row['total'] / $rpp);
            //echo $total_pages;
            $rsf=($page * $rpp)-$rpp;               // rsf = row start from 

            $limit = "$rsf,$rpp";
            if($priority==""){
                $sql = "SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` from `question_master` where `subject_id`= '$subject' AND `status`= 1 ORDER BY `question_id` DESC LIMIT $limit";
            }
            if($subject!="" && $priority != ""){
                $sql = "SELECT DISTINCT `question_id`, `question`,`option1`,`option2`,`option3`,`option4`,`correct_ans` from `question_master` where (`subject_id`= '$subject' AND `priority`= '$priority') AND `status`= 1 ORDER BY `question_id` DESC LIMIT $limit";
            }
            $result = mysqli_query($this->conn, $sql);
           
             if(mysqli_num_rows($result)>0){
                while($rows = mysqli_fetch_array($result)){
                     $result_arr[] = array("question_id"=>$rows[0],
                                    "question"=>$rows[1],
                                    "correct_answer"=>$rows[$rows[6]]
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

    // Function to get count of Questions added by current logged in user 
    public function get_question_count($data){
        $user_id = $data->userId;
        $sql = "SELECT COUNT(*) AS `question_count` FROM `question_master` WHERE `created_by` = '$user_id'";
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

}


?>