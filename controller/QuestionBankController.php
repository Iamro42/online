<?php
/**
 * created on 31-May-2018
 * developed by Roshan Bagde
 * project name onlineexamportal.com
 * module QuestionPaperController
 */

include ('../model/QuestionBankModel.php');
$json = file_get_contents('php://input');

if($json==null){
    echo "something";
    return;
}
$requestType;
$data = json_decode($json);
$requestType = $data->requestType;
$qb_Model = new QuestionBankModel();
session_start();

$userId = $_SESSION['userId'];
$userType = $_SESSION['userType'];
switch($requestType){

	case "addNewQuestion":$data->userId = $userId; $qb_Model->addNewQuestion($data); break;
	case "getSubjects": $qb_Model->getSubjects(); break;
	case "getQuestionBank": $qb_Model->getQuestionBank(); break;
	case "removeQuestion": $qb_Model->removeQuestion($data); break;
	case "viewQuestion": $qb_Model->viewQuestion($data); break;
	case "filterData": $qb_Model->filterData($data); break;
	case "editQuestion": $qb_Model->editQuestion($data); break;
	case "searchKeyword": $qb_Model->searchKeyword($data);break;
	// function to get question count for user dashboard
	case "get_question_count":$data->userId = $userId;$qb_Model->get_question_count($data);break;
	// function to check user 
	case "getPagination": $qb_Model->getPagination($data);break;
	case "change_page": $qb_Model->getPagination($data);break;
	case "getSearchPagination": $qb_Model->getSearchPagination($data);break;
	case "search_page": $qb_Model->getSearchPagination($data);break;


}
?>