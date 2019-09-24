<?php
require_once "utility/apiHandler.php" ;

$app->get('/subjects/all',function(){
    global $db;
    $res = $db->query("Select name from subjects");
    if($res) $response = $res;
    else $response=NULL;
    echo json_encode(array("subjects"=>$response));
});


?>