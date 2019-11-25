<?php
require_once 'utility/apiHandler.php';

$app->get('/faculty/rating',function(){
    global $db;
    $facultyID=$_GET['facultyID'];
    $response=array();
    $res = $db->query("select rating from faculty where facultyID=$facultyID");
    if($res) $response['rating']=$res[0]['rating'];
    echo json_encode($response);
});


$app->get('/faculty/subjects',function(){
    global $db;
    $facultyID = $_GET['facultyID'];
    $response = array();
    $subjects = $db->query("SELECT DISTINCT s.subjectID,s.name as subjectName
                            FROM `teaches` as t inner join subjects as s 
                               on t.subjectID = s.subjectID 
                            WHERE facultyID=$facultyID"
                        );
    if($subjects){
        foreach ($subjects as $key => $value) {
            $subID=$subjects[$key]['subjectID'];
            $reviews = $db->query("SELECT title,review,created_at from reviews where facultyID=$facultyID and subjectID=$subID");
            if($reviews) $subjects[$key]['reviews']=$reviews;
        }
        $response['subjects']=$subjects;
    }
    echo json_encode($response);

});
$app->put('/faculty/review',function(){
    global $db;
    $data = json_decode(file_get_contents('php://input'), true);
    $facultyID=$data['facultyID'];
    $studentID=$data['studentID'];
    $subjectID=$data['subjectID'];
    $title=$data['title'];
    $review=$data['review'];
    $response = array("sent"=>false);
    $qry = "INSERT into reviews
    (facultyID,studentID,subjectID,title,review) values 
    ($facultyID,$studentID,$subjectID,'$title','$review')";
    $inserted=$db->query($qry);
    if($inserted){
        $response["sent"]=true;
    }
    $response["qry"]=$qry;
    echo json_encode($response);
});
?>