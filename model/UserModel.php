<?php
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require 'libphp-phpmailer/PHPMailerAutoload.php';

include "Connections.php";
include 'AppLib.php';
class UserModel{
    private $conn;
    private $connection;
    private $date;
    private $format;
    public function __construct(){
        session_start();
        $this->connection = new Connection();
        $this->conn = $this->connection->createConnection();  
        $this->format = new Format(); 
         
    }

    public function __destruct(){
        $this->connection->closeConnection($this->conn);
    }


    // Function for Login Candidate
    public function login($data){
        if($data==null){
            echo "ERROR";
            return;
        }
        if($this->conn == null){
            echo "DATABASE ERROR";
            return;
        }
        $email = $data->email;
        $pass = $data->password;
        //$subType = $data->subType;
        //$pass = md5($pass);

        $sql = "SELECT `user_master`.`user_id`,`user_master`.`user_type`,`user_master`.`last_activity` FROM `user_master` WHERE `email` = '$email' AND `password` = '$pass' AND `status` = 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $result = array("userType"=>$rows[1], "lastActivity"=>$this->format->formatDateTime($rows[2]));
                $_SESSION['userId'] = $rows[0];
                $_SESSION['userType'] = $rows[1];
                echo json_encode($result);   
        }
        else{
            echo "INVALID USER";
        }
    }  
    
    // Function for Registration with minimum Entries
    public function signup($data){
        if($data==null){
            echo "ERROR";
            return;
        }
        if($this->conn == null){
            echo "DATABASE ERROR";
            return;
        }
        
        $fName = ucfirst($data->firstName);
        $lName = ucfirst($data->lastName);
        $email = $data->email;
        $password = $data->pass;
        $collName = $data->collName;
        $enrollNum = $data->enrollNum;
        $companyName = $data->company_name;
        $user_type = "";

        if((empty($enrollNum) && empty($collName)) && !empty($companyName)){
            $user_type = "EMPLOYEE";    
        }
        else if(empty($companyName) && (!empty($enrollNum) || !empty($collName))) {
            $user_type = "STUDENT";
        }
        else if(empty($companyName) && empty($enrollNum) && empty($collName)){
            $user_type = "CANDIDATE";
        }
        
        //echo $user_type;
        $createDate = Format::getCurrentDateTime();
        $lastActivity = Format::getCurrentDateTime();

        
        // check if user_type is STUDENT
        if($user_type == "STUDENT"){
            $id = $this->createNewStudentId();
            $user_id = "STU0".$id;
        }
        // check if user_type is EMPLOYEE
        if($user_type == "EMPLOYEE"){
            $id = $this->createNewEmployeeId();
            $user_id = "EMP0".$id;
        }
        // check if user_type is CANDIDATE
        if($user_type == "CANDIDATE"){
            $id = $this->createNewCandidateId();
            $user_id = "CAN0".$id;
        }
        

        // check if user mail already register or not
        $sql_email_check = "SELECT `user_master`.`email` from `user_master` WHERE `user_master`.`email` = '$email'";
        $res_email_check = mysqli_query($this->conn, $sql_email_check);
        if(mysqli_num_rows($res_email_check)>0){
            echo "DUPLICATE EMAIL";
        }
        else{

            $sql = "INSERT INTO `user_master`(`user_id`,`fname`,`lname`,`email`,`password`,`user_type`,`college_name`,`enroll_no`,`company_name`, `status`,`created`,`last_activity`) 
                    VALUES ('$user_id','$fName','$lName','$email','$password','$user_type','$collName','$enrollNum','$companyName',1,'$createDate','$lastActivity')";
            $res = mysqli_query($this->conn,$sql);
            if($res==1){

                $_SESSION['userId'] = $user_id;
                $_SESSION['userType'] = $user_type;
                
                $result = array("user_type"=>$user_type);
                //echo "SUCCESS"; //successful user creation message
                echo json_encode($result);
                return;
            }
            else{
                $error =  mysqli_error($this->conn);
                
                if(!strpos($error,'Duplicate entry') && strpos($error,'email')){
                    echo "DUPLICATE EMAIL"; // already registered email occured
                }
                else {
                    echo $error; // other database errors
                }
            }
            return;   
        }
    }
    
    // Check Email is allready Exists or not on blur email text box 
    public function checkMail($data){
        $email = $data->email;
        $echeck="SELECT `email` from `user_master` where `email`= '$email'";
        $echk=mysqli_query($this->conn,$echeck);           
        if(mysqli_num_rows($echk)!=0)
        {
            echo "EXISTS";
        }
        else{
            echo "NOT EXISTS";
        }
    }

    // Function for Full Registration of Candidate
    public function register($data){
        if($data==null){
            echo "ERROR";
            return;
        }
        if($this->conn == null){
            echo "DATABASE ERROR";
            return;
        }        
        $fname = ucfirst($data->fname);
        $lname = ucfirst($data->lname);
        $dob = $data->dob;
        $pass = $data->password;
        $email = $data->email;
        $mobile = $data->mobile;
        $gender = $data->gender;
        $edu_Info = $data->eduInfo;
        $permission = $data->permission;
        $userType = $data->userType;
        $college_name = $data->college_name;
        $designation = $data->designation;
        $createDate = Format::getCurrentDateTime();
        $lastActivity = Format::getCurrentDateTime();
        //echo $user_type;
        if($userType=="REGISTRAR"){
            $id = $this->createNewRegistrarId();
            $user_id = "REG0".$id;
        }
        if($userType=="CANDIDATE"){
            $id = $this->createNewCandidateId();
            $user_id = "CAN0".$id;
        }
        if($userType=="TEST GENERATOR"){
            $userType = "QUESTION_PAPER";
            $id = $this->createNewQpcId();
            $user_id = "QPC0".$id;
        }
        //echo "QPC" . $id ."  ";
        if($userType=="QUESTION BANK CREATOR"){
            $userType = "QUESTION_BANK";
            $id = $this->createNewQbcId();
            $user_id = "QBC0".$id;
        }
        
        
        $sql_user = "INSERT INTO `user_master`(`user_id`, `fname`, `lname`, `email`, `password`, `mobile`, `dob`, `gender`, `user_type`, `college_name`, `designation`, `status`, `created`, `last_activity`) 
                                        VALUES ('$user_id','$fname','$lname','$email','$pass','$mobile','$dob','$gender','$userType','$college_name','$designation',1,'$createDate','$lastActivity')";
        $res = mysqli_query($this->conn,$sql_user);
        
        if($res==1){

            $_SESSION['userId'] = $user_id;
            $_SESSION['userType'] = $userType;
            
            // Insert data in Education_master table 
            $eduId = $this->getEduId();
           
            $sql = "INSERT INTO `education_master` (`edu_id`, `user_id`,`edu`,`university`,`passing_year`,`percentage`) VALUES";
            //print_r($edu_Info[0]->edu);
            for($i = 0; $i<count($edu_Info);$i++){
                
                $edu = $edu_Info[$i]->edu;
                $university = $edu_Info[$i]->university;
                $passing_year = $edu_Info[$i]->year;  
                $percentage = $edu_Info[$i]->percentage;
                if($i == 0){
                    $sql = $sql. "($eduId,'$user_id','$edu','$university','$passing_year','$percentage')";
                }
                if($i>0){
                    
                    $sql = $sql. ", ($eduId,'$user_id','$edu','$university','$passing_year','$percentage')";
                }
                $eduId++;
            }
            
            // Insert data in User Permissions table
            
            $gt=0;$cqb=0;$cu=0;$aqb=0;$vr=0;
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

            $res_edu = mysqli_query($this->conn,$sql);
            if($res_edu==1){
                //echo "SUCCESS "; //successful user creation message
                //return true;
                $sql_permission = "INSERT INTO `user_permissions` (`permission_id`,`candidate_id`, `generate_test`,`create_question_bank`,`access_question_bank`,`create_user`,`view_result`,`created_at`) VALUES ('$permissionId','$user_id','$gt','$cqb','$aqb','$cu','$vr','$createDate')";
                $res_permission = mysqli_query($this->conn,$sql_permission);

                if($res_permission > 0){
                    echo "SUCCESS"; //successful user creation message
                }
                else{
                    echo mysqli_error($this->conn);
                }
            }
            else{
                echo mysqli_error($this->conn);
            }       
        }
        else{
            echo $error =  mysqli_error($this->conn);
            
            if(!strpos($error,'Duplicate entry') && strpos($error,'email')){
                echo "DUPLICATE EMAIL"; // already registered email occured
            }
            else {
                echo "UNEXPECTED_ERROR"; // other database errors
            }
        }
        return;
    }


    // function to get user register (Small Form Registration)
    public function user_register($data){
        $user_id;
        $register_by = $data->userId;
        $fname = ucfirst($data->firstName);
        $lname = ucfirst($data->lastName);
        $mobile = $data->mobile;
        $user_type = $data->user_type;
        $email = $data->email;
        $pass = $data->pass;
        $createDate = Format::getCurrentDateTime();
        $lastActivity = Format::getCurrentDateTime();

        if($user_type=="CANDIDATE"){
            $id = $this->createNewCandidateId();
            $user_id = "CAN0".$id;
        }
        // First check is email id is available in user_master table  // true = exists / false = not Exists
        $mail_status = $this->check_user_mail($email);
        if($mail_status==false){
            // Query to register user into user_master table
            $sql = "INSERT INTO `user_master` (`user_id`, `fname`, `lname`, `email`, `password`, `mobile`, `user_type`,`register_by`, `status`, `created`, `last_activity`) 
                                        VALUES ('$user_id','$fname','$lname','$email','$pass','$mobile','$user_type','$register_by',1,'$createDate','$lastActivity')";
            $res = mysqli_query($this->conn, $sql);
            if($res){
                echo "SUCCESS";
            }
            else{
                echo mysqli_error($this->conn);
                echo "FAILED";
            }
        }
        else{
            echo "DUPLICATE EMAIL";
        }
    }

    // function to Registrar get login
    public function registrar_login($data){
        if($data==null){
            echo "ERROR";
            return;
        }
        if($this->conn == null){
            echo "DATABASE ERROR";
            return;
        }
        $email = $data->email;
        $pass = $data->password;
        $test_code = $data->test_code;
        //$subType = $data->subType;

        $sql = "SELECT `user_master`.`user_id`,`user_master`.`user_type`,`user_master`.`last_activity` FROM `user_master` WHERE `email` = '$email' AND `password` = '$pass' AND `status` = 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $result = array("userType"=>$rows[1], "lastActivity"=>$this->format->formatDateTime($rows[2]));
                $_SESSION['userId'] = $rows[0];
                $_SESSION['userType'] = $rows[1];
                //print_r($_SESSION);
                //echo $rows[0];
                //echo $_SESSION['userType'];
                echo json_encode($result);   
        }
        else{
            echo "INVALID USER";
        }
    }


    // function to show Permissions fro users according to set permissions while user creation
    public function show_dashboard_content($data){
        $userId = $data->userId;
        $sql = "SELECT `generate_test`,`create_question_bank`,`access_question_bank`,`create_user`,`view_result` FROM `user_permissions` WHERE `candidate_id` = '$userId'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $res_array = array("generate_test"=>$rows[0],"create_question_bank"=>$rows[1],"access_question_bank"=>$rows[2], 'create_user'=>$rows[3], "view_result"=>$rows[4]);
            echo json_encode($res_array);  
        }
        else{
            echo mysqli_error($this->conn);
            //echo "FAILED";
        }
    }

    // function to get question bank as user has permission to use question bank
    public function question_bank_permissions($data){
        $userId = $data->userId;
        $sql = "SELECT `user_permissions`.`generate_test`,`user_permissions`.`create_question_bank`,`user_permissions`.`access_question_bank`,`user_permissions`.`create_user`,`user_permissions`.`view_result`,`user_master`.`user_id`, `user_master`.`user_type` FROM `user_permissions`, `user_master` WHERE `user_permissions`.`candidate_id` = `user_master`.`user_id` && `user_master`.`user_id`='$userId'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $res_array = array("generate_test"=>$rows[0],
                                "create_question_bank"=>$rows[1],
                                "access_question_bank"=>$rows[2], 
                                'create_user'=>$rows[3], 
                                "view_result"=>$rows[4],
                                "user_id"=>$rows[5],
                                "user_type"=>$rows[6]    
                            );
            echo json_encode($res_array);  
        }
        else{
            echo mysqli_error($this->conn);
            //echo "FAILED";
        }
    }

// Function to manage forgot password send id and password on users mail
    public function forgot_password($data){
        $mail;
        $fname = "";
        $string = $this->generateRandomString();
        
        $email =  $data->email;
        //echo $email;
        $username = 'roshan.tantransh@gmail.com';
        $password = 'Tantransh!@#123';

        // Query to get user name 
        $sql_name = "SELECT `fname` FROM `user_master` WHERE `email`='$email'";
        $res_name = mysqli_query($this->conn,$sql_name);
        if(mysqli_num_rows($res_name)>0){
            $row = mysqli_fetch_array($res_name);
            $fname = $row[0];
        }else{
            echo "FAILED";
            echo mysqli_error($this->conn);
            return;
        }

        // Query for update password
        $sql = "UPDATE `user_master` SET `password`='$string' WHERE `email` = '$email'";
        $res = mysqli_query($this->conn,$sql);
        if($res){
            $mail = 1;
        }
        else{
            $mail = 0;
        }
        //echo $fname;

        if($mail=1)
        {
          //echo "yes";
          $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'Smtp.gmail.com';                     // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = $username;                        // SMTP username
                $mail->Password = $password;                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('roshan.tantransh@gmail.com', 'Tantransh Solution');
                $mail->addAddress($email, 'Joe User');     // Add a recipient
                //$mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('final_logo.png', 'new.jpg');    // Optional name

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Online Exam Portal : Forgot Password';
                $mail->Body    = '<div style= "color:#be3e2b"><h3>Greetings From Online Exam Portal</h3></div>
                                    <div style = "width:400px; background:#f9f9f9; text-align:center">  Hi '.ucfirst($fname).', 
                                    <br><br> 
                                    <p>Someone (Hopefully its you) requested for new password for your Online Exam Portal account.<br> Your updated password is <b>'.$string.'</b>
                                    <br><br>
                                    <p> Please Keep Your Password secretly</p>
                                    </p></div>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                // $mail->send();
                // echo 'SUCCESS';
                if(!$mail->send()) {
                   echo 'FAILED';
                   echo 'Mailer error: ' . $mail->ErrorInfo;
                } 
                else{
                   echo 'SUCCESS';
                }
            } 
            catch (Exception $e) {
                echo 'FAILED. Mailer Error: ', $mail->ErrorInfo;
            }
        }
    }

    // Function to get New User Id from education_master
    public function getEduId(){
        $sql = "SELECT `edu_id` FROM `education_master` ORDER BY `edu_id` DESC LIMIT 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $currentId = $rows[0];  //(int) substr($rows[0],3);
            return ++$currentId;
        }
        return 1;
    }

    // Function to get New User Id from user_permissions
    public function getPermissionId(){
        $sql = "SELECT `permission_id` FROM `user_permissions` ORDER BY `permission_id` DESC LIMIT 1";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            return ++$rows[0];
        }
        return 1;
    }

    // Function to check Email is Exists or not
    public function check_user_mail($email){
        $echeck="SELECT `email` from `user_master` where `email`= '$email'";
        $echk=mysqli_query($this->conn,$echeck);           
        if(mysqli_num_rows($echk)>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    // Function to get New Registrar Id
    public function createNewRegistrarId(){
        $sql = "SELECT `user_master`.`user_id` FROM `user_master` WHERE `user_master`.`user_type` = 'REGISTRAR' ORDER BY `created` DESC LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $currentId = (int) substr($rows[0],3);
            return ++$currentId;  
        }
        return 1;
    }

    // Function ro get New Employee Id
    public function createNewEmployeeId(){
        $sql = "SELECT `user_master`.`user_id` FROM `user_master` WHERE `user_master`.`user_type` = 'EMPLOYEE' ORDER BY `created` DESC LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $currentId = (int) substr($rows[0],3);
            return ++$currentId;  
        }
        return 1;
    }

    // Function to get New Student Id
    public function createNewStudentId(){
        $sql = "SELECT `user_master`.`user_id` FROM `user_master` WHERE `user_master`.`user_type` = 'STUDENT' ORDER BY `created` DESC LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $currentId = (int) substr($rows[0],3);
            return ++$currentId;   
        }
        return 1;
    }

    // Function to get New Candidate Id 
    public function createNewCandidateId(){
        $sql = "SELECT `user_master`.`user_id` FROM `user_master` WHERE `user_master`.`user_type` = 'CANDIDATE' ORDER BY `created` DESC LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $currentId = (int) substr($rows[0],3);
            
            return ++$currentId;  
        }
        return 1;
    }

    // Function to get New Question bank creator Id
    public function createNewQbcId(){
        $sql = "SELECT `user_master`.`user_id` FROM `user_master` WHERE `user_master`.`user_type` = 'QUESTION_BANK' ORDER BY `created` DESC LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $currentId = (int) substr($rows[0],3);
            return ++$currentId;
        }
        return 1;
    }

    // Function to get New Question Paper Creator Id (Test Generator Id)
    public function createNewQpcId(){
       $sql = "SELECT `user_master`.`user_id` FROM `user_master` WHERE `user_master`.`user_type` = 'QUESTION_PAPER' ORDER BY `created` DESC LIMIT 1";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)==1){
            $rows = mysqli_fetch_array($res);
            $currentId = (int) substr($rows[0],3);
            return ++$currentId;
        }
        return 1;
    }

    // Function to get user profile information
    public function userInfo($data){
        $userId = $data->userId;
        $sql = "SELECT `email`,`fname`,`lname` FROM `user_master` WHERE `user_id` = '$userId'";
        $res = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($res)>0){
            $rows = mysqli_fetch_array($res);
            $result = array("email"=>$rows[0], "fname"=>$rows[1], "lname"=>$rows[2]);
            echo json_encode($result);
        }
    }

    // Function to Generate Random Number
    public function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}

?>