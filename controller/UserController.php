<?php

/**
 * created on 17-April-2018
 * developed by Roshan Bagde
 * project name onlineexamportal.com
 * module UserController
 */

include ('../model/UserModel.php');
$json = file_get_contents('php://input');
if($json==null){
    echo "ERROR";
    return;
}
$userId = "";
$requestType;
$data = json_decode($json);
//print_r($data);
$requestType = $data->requestType;
$userModel = new UserModel();
//session_start();
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
}
	// if(count($_SESSION)<=0){
    //    	echo "SESSION EXPIRE";           
    //    	return;
	// }
    
    //$userType = $_SESSION['userType'];


switch($requestType){
    case "login" : $userModel->login($data);break;
    case "register": $userModel->register($data); break;
    case "signup" : $userModel->signup($data); break;
    case "checkEmail": $userModel->checkMail($data); break;
    case "forgot_password": $userModel->forgot_password($data); break;
    case "user_register": $data->userId = $userId;$userModel->user_register($data);break;
    case "show_dashboard_content": $data->userId = $userId; $userModel->show_dashboard_content($data);break;
    case "question_bank_permissions": $data->userId = $userId; $userModel->question_bank_permissions($data);break;
    case "userInfo" : $data->userId = $userId; $userModel->userInfo($data);break;
    case "signout" : session_destroy(); break;
    
    
}

?>