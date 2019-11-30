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
    $response=getStudentFaculties($studentID,true);
    echo json_encode($response);
});
$app->put('/student/updatecoins',function(){
    $data = json_decode(file_get_contents('php://input'), true);
    $studentID = $data['studentID'];
    $coins = $data['coins'];
    $status = updateStudentCoins($studentID,$coins);
    $response = array("success"=>$status,"coins"=>$coins);
    echo json_encode($response);


});
?>