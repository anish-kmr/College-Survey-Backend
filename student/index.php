<?php

require_once "utility/apiHandler.php" ;
require_once "utility/survey_util.php" ;

$app->get('/student/surveys',function(){
    $studentID = $_GET['sid'];
    $status = $_GET['status'];
    $response = getStudentSurveys($studentID,$status);
    $response['stats']=$status;
    echo json_encode($response);

})

?>