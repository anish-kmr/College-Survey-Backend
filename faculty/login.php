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
    if($status == 0)  $response['password_wrong']=true;
    elseif($status == -1) $response['not_found']=true;
    else{
        $response['authenticated']=true;
        $response['user'] = $status[0];
    }

    echo json_encode($response);    
});

$app->put('/faculty/signin',function(){
    $data = json_decode(file_get_contents('php://input'), true);
// //Dummy data to test
    // $data = array();
    // $data['first_name']="anish";
    // $data['last_name']=" value";
    // $data['email']="de@l.com";
    // $data['password']="uhadsh ";
    // $data['department']="es ";
    // $data['subjects']=array("ES3","DBW");
    // $data['batches']=array(
    //     "ES3"=>array(
    //         "year1"=>array("B4","B3"),
    //         "year2"=>array("B9"),
    //         "year3"=>array("B2"),
    //         "year4"=>array("B1","B8"),
    //     ),
    //     "DBW"=>array(
    //         "year1"=>array(),
    //         "year2"=>array("B8"),
    //         "year3"=>array("B6"),
    //         "year4"=>array("B2","B4"),
    //     ));

    $status = signin("faculty",$data);
    $response = array("created"=>$status);
    echo json_encode($response);    
});

$app->get('/faculty/all',function(){
    global $db;
    $res = $db->query('Select * from faculty');
    if($res){
        $response = $res;
    }
    echo json_encode($response);
});

?>