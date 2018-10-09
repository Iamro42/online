<?php

/**
 * created on 31-May-2018
 * developed by Roshan Bagde
 * project name onlineexamportal.com
 * module QuestionPaperController
 */

include ('../model/QuestionPaperModel.php');
$json = file_get_contents('php://input');
if($json==null){
    echo "ERROR";
    return;
}
$requestType;
$data = json_decode($json);
$requestType = $data->requestType;
$qp_Model = new QuestionPaperModel();
session_start();
//print_r($_SESSION);
$userId = $_SESSION['userId'];
$userType = $_SESSION['userType'];
switch($requestType){
    case "qp_filter": $qp_Model->filterData($data); break;
    case "show_subject_test": $data->userId = $userId; $data->userType = $userType; $qp_Model->show_subject_test($data);break;
    case "create_normal_test": $data->userId = $userId;$qp_Model->create_normal_test($data);break;
    case "create_random_test": $data->userId = $userId;$qp_Model->create_random_test($data);break;
    case "show_test": $qp_Model->show_test();break;
    
    case "count_question": $qp_Model->count_question();break;
    case "open_question_info" : $qp_Model->question_info($data);break;
    case "remove" : $qp_Model->remove($data); break;
    case "easy_question" : $qp_Model->easy_question($data); break;
    case "medium_question" : $qp_Model->medium_question($data); break;
    case "hard_question" : $qp_Model->hard_question($data); break;
    case "random_question" : $qp_Model->random_question($data); break;
    case "get_test_count":$data->userId = $userId; $qp_Model->get_test_count($data); break;

    case "search_by_sub_name": $data->userId = $userId; $data->userType = $userType; $qp_Model->search_by_sub_name($data);break;
    case "search_by_date": $data->userId = $userId; $data->userType = $userType; $qp_Model->search_by_date($data);break;

    case "show_test_code":$qp_Model->show_test_code();break;
    
    
    
}