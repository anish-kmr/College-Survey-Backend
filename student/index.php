<?php

require_once "utility/apiHandler.php" ;
require_once "utility/survey_util.php" ;

$app->get('/student/surveys',function(){
    $studentID = $_GET['sid'];
    $response = getStudentSurveys($studentID);
    echo json_encode($response);

})

?>