<?php
require_once "utility/apiHandler.php" ;
require_once "utility/login_util.php";

$app->get('/faculty/validate_email',function(){
    global $db;
    $email = $_GET['email'];
    $available = validateEmail("faculty",$email);
    echo json_encode(array("available"=>$available));
});

$app->post('/faculty/login',function(){
    $data = json_decode(file_get_contents('php://input'), true);
    $email=$data['email'];
    $password=$data['password'];
    $status = authenticate("faculty",$email,$password);
    $response = array("authenticated"=>false,"not_found"=>false,"password_wrong"=>false);

    if($status==1)        $response['authenticated']=true;
    elseif($status == 0)  $response['password_wrong']=true;
    elseif($status == -1) $response['not_found']=true;

    echo json_encode($response);    
});

$app->put('/faculty/signin',function(){
    $data = json_decode(file_get_contents('php://input'), true);
// //Dummy data to test
    // $data = array();
    // $data['first_name']="anish";
    // $data['last_name']=" value";
    // $data['email']="delete@mail.com";
    // $data['password']="uhadsh ";
    // $data['department']="es ";
    // $data['subjects']=array("Maths","ES");
    $status = signin("faculty",$data);
    $response = array("created"=>$status);



    echo json_encode($response);    
})

?>