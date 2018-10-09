 <?php

/**
 * created on 17-April-2018
 * developed by Roshan Bagde
 * project name onlineexamportal.com
 * module AdminController
 */

include ('../model/AdminModel.php');
$json = file_get_contents('php://input');
if($json==null){
    echo "ERROR";
    return;
}
$requestType;
$data = json_decode($json);
$requestType = $data->requestType;
$adminModel = new AdminModel();
session_start();

$userId = $_SESSION['userId'];
$userType = $_SESSION['userType'];
switch($requestType){

    case "question_count":$adminModel->question_count();break;
    case "test_count": $adminModel->test_count();break;
    case "user_count": $adminModel->user_count();break;
    case "subject_count": $adminModel->subject_count();break;
    case "result_count": $adminModel->result_count();break;
    case "view_more": $adminModel->view_more($data);break;

    // Change Admin Password
    case "change_password": $adminModel->change_password($data);break;

    // Cases for Results on users dashboard and admin too
    case "show_result_count":  $data->userId = $userId;$adminModel->show_result_count($data);break;   
    case "show_result" :$data->userId = $userId; $data->userType = $userType; $adminModel->show_result($data);break;
    case "filter_result": $data->userId = $userId; $data->userType = $userType; $adminModel->filter_result($data);break;
    case "download_pdf": $data->userId = $userId; $data->userType = $userType; $adminModel->download_pdf($data);break;
    case "show_college_name": $data->userId = $userId; $data->userType = $userType; $adminModel->show_college_name();break;


    // Cases for subject crud 
    case "add_subject": $adminModel->add_subject($data);break;
    case "show_all_subjects": $adminModel->show_all_subjects();break;
    case "update_subject": $adminModel->update_subject($data);break;
    case "remove_subject": $adminModel->remove_subject($data);break;
    case "search_by_subject": $adminModel->search_by_subject($data);break;

    // Cases for users crud at the admin end
    case "show_all_users": $adminModel->show_all_users($data); break;
    case "remove_user": $adminModel->remove_user($data); break;
    case "editUserInfo": $adminModel->editUserInfo($data); break;
    case "updateUserInfo":$adminModel->updateUserInfo($data); break;

    // cases for candidates informations
    case "show_candidate_count": $data->userId = $userId;$adminModel->show_candidate_count($data);break;

    // Admin Users pagination
    case "getUsersPagination" : $adminModel->getUsersPagination($data);break;
    case "changeUsersPagination" : $adminModel->getUsersPagination($data);break;
}






?>