<?php

require_once "utility/apiHandler.php" ;
require_once "utility/survey_util.php" ;

$app->get('/student/surveys',function(){
    $studentID = $_GET['sid'];
    $status = $_GET['status'];
    $response = getStudentSurveys($studentID,$status);
    $response['stats']=$status;
    echo json_encode($response);

});

$app->get('/student/faculties',function(){
    $studentID=$_GET['studentID'];
    $response=array("null"=>"null");
    $response = getStudentFaculties($studentID);
    echo json_encode($response);
});

$app->get('/student/pastreviews',function(){
    $studentID=$_GET['studentID'];
    global $db;
    $response=getStudentFaculties($studentID,true);
    
    echo json_encode($response);
});
?>