<?php
require_once "utility/apiHandler.php" ;
require_once "utility/login_util.php";


$app->post('/admin/login',function(){
    $data = json_decode(file_get_contents('php://input'), true);
    $email=$data['email'];
    $password=$data['password'];
    $status = authenticate("admin",$email,$password);
    $response = array("authenticated"=>false,"not_found"=>false,"password_wrong"=>false);

    if($status==1)        $response['authenticated']=true;
    elseif($status == 0)  $response['password_wrong']=true;
    elseif($status == -1) $response['not_found']=true;

    echo json_encode($response);    
});

$app->put('/admin/signin',function(){
    // $data = json_decode(file_get_contents('php://input'), true);

//Dummy data to test
    $data = array();
    $data['first_name']="uhadsh";
    $data['last_name']="uhadsh value";
    $data['email']="delete@mail.com";
    $data['department']="uhadsh value";
    $data['password']="uhadsh value";
    $status = signin("admin",$data);
    $response = array("created"=>$status);



    echo json_encode($response);    
})

?>