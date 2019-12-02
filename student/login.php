<?php
require_once "utility/apiHandler.php" ;
require_once "utility/login_util.php";


$app->get('/student/validate_email',function(){
    global $db;
    $email = $_GET['email'];
    $available = validateEmail("student",$email);
    echo json_encode(array("available"=>$available));
});

$app->get('/student/validate_eno',function(){
    global $db;
    $eno = $_GET['eno'];
    $available = validateEno("student",$eno);
    echo json_encode(array("available"=>$available));
});

$app->post('/student/login',function(){
    $data = json_decode(file_get_contents('php://input'), true);
    $email=$data['email'];
    $password=$data['password'];
    $status = authenticate("student",$email,$password);
    $response = array("authenticated"=>false,"not_found"=>false,"password_wrong"=>false);

    if($status == 0)  $response['password_wrong']=true;
    elseif($status == -1) $response['not_found']=true;
    else{
        $response['authenticated']=true;
        $response['user'] = $status[0];
    }

    echo json_encode($response);    
});

$app->put('/student/signin',function(){
    $data = json_decode(file_get_contents('php://input'), true);

//Dummy data to test
    // $data = array();
    // $data['enrollment_no']=18103120;
    // $data['first_name']="uhadsh";
    // $data['last_name']="uhadsh value";
    // $data['batch']="B4";
    // $data['year']=2;
    // $data['email']="delete@mail.com";
    // $data['password']="123";
    $status = signin("student",$data);
    if($status==1){
        $email = $data['email'];
        $password = $data['password'];
        $flag = authenticate("student",$email,$password);
        $user = $flag[0];
    }
    else $user=NULL;
    $response = array("created"=>$status,"user"=>$user);


    echo json_encode($response);    
})

?>