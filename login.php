<?php
//functions for LOGIN and SIGNUP for Admin,Student,Faculty

$db=new Database();
function authenticate($tablename,$email,$password){
    global $db;
    $res = $db->query("Select * from ".$tablename." where email = '".$email."'");
    if($res){
        $dbpwd = $res[0]['password'];
        if($password == $dbpwd) return 1;
        else return 0;
    }
    else return -1;
}

?>