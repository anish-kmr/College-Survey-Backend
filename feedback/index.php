<?php
require_once 'utility/feedback_util.php';

$app->put('/feedback/create',function(){
    $data = json_decode(file_get_contents('php://input'), true);

// DUMMY DATA TO TEST
    // $data = array();
    // $data['adminID']=1000;
    // $data['facultyID']=3002;
    // $data['surveyID']=1;
    // $data['studentID']=2000;
    // $data['feedback']=array(
    //     array("qsID"=>"1","surveyID"=>"1","response"=>3),
    //     array("qsID"=>"2","surveyID"=>"1","response"=>4),
    //     array("qsID"=>"3","surveyID"=>"1","response"=>3),
    //     array("qsID"=>"4","surveyID"=>"1","response"=>4)
    // );

    $response=array("success"=>0,"fail"=>0,"updated"=>0);
    $res = createFeedback($data);
    if($res == -1) $response['updated']=1;
    else if($res == 0) $response['fail']=1;
    else if($res == 1) $response['success']=1;
    echo json_encode($response);
});


?>