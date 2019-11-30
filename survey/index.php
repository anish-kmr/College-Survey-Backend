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
$app->post('/survey/close',function(){
    global $db;
    $data = json_decode(file_get_contents('php://input'), true);
    $surveyID = $data['surveyID'];
    $response = array("closed"=>false);
    $res = $db->query("Update survey set status='closed' where surveyID = $surveyID");
    if($res) $response['closed']=true;
    
    echo json_encode($response);
});
// $app->get('/surveys',function(){
//     global $db;
//     $status = $_GET['status'];
//     $res = $db->query("Select * from survey where status='$status'");
//     $response=array("qry"=>$res);
//     if($res){
//         for($i=0;$i<count($res);$i++){
//             $qsarray=array();
//             $res[$i]['questions']=array();
//             $surveyID = $res[$i]['surveyID'];
//             $qs = $db->query("Select statement from questions where surveyID='$surveyID'");
//             if($qs){
//                 foreach ($qs as $q) {
//                     array_push($qsarray,$q['statement']);
//                 }
//                 $res[$i]['questions']=$qsarray;
                
//             }
//         }
//         $response = $res;
//     }
//     echo json_encode($response);
// });

$app->get("/surveys",function(){
    global $db;
    $status = $_GET['status'];
    $a = $db->query("select * from survey natural join questions where survey.status = '$status'");
    $temp=array();
    $response=array();
    foreach ($a as $r) {
        $name = $r['name'];
        if(array_key_exists($r['name'],$temp)){
            $qo['qsID'] = $r['qsID'];
            $qo['statement'] = $r['statement'];
            array_push($temp[$name]['questions'],$qo);
        }
        else{ 
            $temp[$name] = array();
            $qo = array();
            $qo['qsID'] = $r['qsID'];
            $qo['statement'] = $r['statement'];
            $temp[$name]['name'] = $name;
            $temp[$name]['surveyID'] = $r['surveyID'];
            $temp[$name]['adminID'] = $r['adminID'];
            $temp[$name]['type'] = $r['type'];
            $temp[$name]['status'] = $r['status'];
            $temp[$name]['questions'] = array();

            array_push($temp[$name]['questions'],$qo);
        }  
    }
    foreach ($temp as $r) array_push($response,$r);
    
    echo json_encode($response);
});

$app->get('/survey/faculties',function(){
    global $db;
    $surveyID = $_GET['surveyID'];
    $faculties = $db->query("SELECT * FROM faculty_survey natural join faculty  WHERE faculty_survey.surveyID = $surveyID");
    $response = array();
    if($faculties){
        $response = $faculties;
    }
    echo json_encode($response);
});
$app->get('/survey/analysis',function(){
    if(isset($_GET['facultyID'])) $facultyID=$_GET['facultyID'];
    else $facultyID=0;
    $surveyID=$_GET['surveyID'];
    $total=getTotalStudents($facultyID);
    $feedbacks=getTotalFeedbacks( $surveyID,$facultyID);
    $response=array("total_students"=>$total,"total_feedbacks_given"=>$feedbacks);
    echo json_encode($response);

});
$app->get('/survey/admin/analysis',function(){
    global $db;
    $surveyID=$_GET['surveyID'];
    $type = $db->query("SELECT type from survey where surveyID=$surveyID ");
    $type=$type[0]['type'];
    $response=getAdminAnalysis($surveyID,$type);
    echo json_encode($response);

});
$app->get('/survey/faculty/analysis',function(){
    $facultyID=$_GET['facultyID'];
    $surveyID=$_GET['surveyID'];
    $response=getAnalysis($surveyID,$facultyID);
    echo json_encode($response);

})

?>