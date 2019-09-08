<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');

require_once "apiHandler.php";
require_once "db.php";
require_once "tables.php";
require_once "login.php";

$db = new Database();
echo "main";
if(!$db->exist_table("admin")){
    $db->query($create_admin_query);
    $db->query(set_ai("admin"));
}
if(!$db->exist_table("student")){
    $db->query($create_student_query);
    $db->query(set_ai("student"));
}
if(!$db->exist_table("faculty")){
    $db->query($create_faculty_query);
    $db->query(set_ai("faculty"));
}

$request = explode('/testapi', $_SERVER['REQUEST_URI'])[1];
$method = $_SERVER['REQUEST_METHOD'];

$app = new Handler();


//API ENDPOINTS
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
})
?>