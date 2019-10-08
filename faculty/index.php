<?php
require_once 'utility/apiHandler.php';

$app->get('/faculty/rating',function(){
    global $db;
    $facultyID=$_GET['facultyID'];
    $response=array();
    $res = $db->query("select rating from faculty where facultyID=$facultyID");
    if($res) $response['rating']=$res[0]['rating'];
    echo json_encode($response);
})

?>