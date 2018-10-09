<?php
/**
 * created on 9-June-2018
 * developed by Roshan Bagde
 * project name onlineexamportal.com
 * module AdminController
 */

include ('../model/CandidateModel.php');
$json = file_get_contents('php://input');

if($json==null){
    echo "ERROR";
    return;
}
$requestType;
$data = json_decode($json);
$requestType = $data->requestType;
$candidate_Model = new CandidateModel();
session_start();
	// if(count($_SESSION)<=0){
    //    	echo "SESSION EXPIRE";           
    //    	return;
	// }
    $userId = $_SESSION['userId'];
    $userType = $_SESSION['userType'];
    
    // if($userId == null){
    //     echo "SESSION EXPIRE";
    //     return;
   	// }

switch($requestType){
    case "fetch_question": $candidate_Model->fetch_question($data) ;break;
    case "submit_result" : $data->userId = $userId; $candidate_Model->submit_result($data); break;
    case "check_question_set" : $candidate_Model->check_question_set($data);break;
    case "show_Result": $data->userId = $userId;$candidate_Model->show_result_dashboard($data);break;
    // case to show all candidates created by registrar itself for their organization
    case "show_all_candidates":  $data->userId = $userId;$candidate_Model->show_all_candidates($data); break;
    case "editUserCandidateInfo": $candidate_Model->editUserCandidateInfo($data); break;
    case "update_info": $candidate_Model->update_info($data);break;
    case "filterInfo": $data->userType = $userType;$data->userId = $userId;$candidate_Model->filterInfo($data);break;
    case "search_by_date": $data->userType = $userType;$data->userId = $userId;$candidate_Model->search_by_date($data);break;
    case "filter_by_users": $data->userType = $userType;$candidate_Model->filter_by_users($data);break;
    case "getTimer" : $candidate_Model->getTimer($data);break;
    case "check_result" : $data->userType = $userType;$data->userId = $userId;$candidate_Model->check_result($data);break;
    case "get_user_name" : $data->userType = $userType;$data->userId = $userId;$candidate_Model->get_user_name($data);break;

    
}
?>

