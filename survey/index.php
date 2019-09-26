<?php
require_once 'utility/survey_util.php';
$app->put('/survey/create',function(){
    $data = json_decode(file_get_contents('php://input'), true);
    // $data['name']="ffac18";
    // $data['type']="faculty";
    // $data['adminID']=1002;
    // $data['faculties']=array("13","14","15","16");

    $status = createSurvey($data);
    echo json_encode(array("status"=>$status));
});

$app->get('/surveys',function(){
    global $db;
    $status = $_GET['status'];
    $res = $db->query("Select * from survey where status='$status'");
    $response=array("qry"=>$res);
    if($res){
        for($i=0;$i<count($res);$i++){
            $qsarray=array();
            $res[$i]['questions']=array();
            $surveyID = $res[$i]['surveyID'];
            $qs = $db->query("Select statement from questions where surveyID='$surveyID'");
            if($qs){
                foreach ($qs as $q) {
                    array_push($qsarray,$q['statement']);
                }
                $res[$i]['questions']=$qsarray;
                
            }
        }
        $response = $res;
    }
    echo json_encode($response);
});


?>