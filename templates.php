<?php

require_once "utility/apiHandler.php";

$app->get('/templates',function(){
    global $db;
    $res = $db->query('Select * from templates');
    $response = array();
    // print_r($res);
    if($res){
        foreach ($res as $row) {
            // print_r($row);
            $tempID = $row['templateID'];
            
            $name = $row['name'];
            $response[$name]=array();
            $qs = $db->query("select * from templateQs where templateID = $tempID ");
            if($qs){
                
                foreach ($qs as $q) {
                   array_push($response[$name],$q['statement']);
                }
            }

        }
    }
    echo json_encode($response);
})

?>