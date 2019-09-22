<?php

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

function signin($tablename,$details){
    global $db;
    if($tablename == "admin"){
        $name = $details['first_name']." ".$details['last_name'];
        $email = $details['email'];
        $department = $details['department'];
        $password = $details['password'];
        $insert = "Insert into admin (name,email,department,password) values ('$name','$email','$department','$password');";
    }
    else if($tablename == "student"){
        $eno = $details['enrollment_no'];
        $name = $details['first_name']." ".$details['last_name'];
        $batch = $details['batch'];
        $year = $details['year'];
        $email = $details['email'];
        $password = $details['password'];
        $insert = "Insert into student (enrollmentNo,name,batch,year,email,password) values ($eno,'$name','$batch',$year,'$email','$password');";
    }
    else if($tablename == "faculty"){
        $name = $details['first_name']." ".$details['last_name'];
        $email = $details['email'];
        $password = $details['password'];
        $insert = "Insert into faculty (name,email,password) values ('$name','$email','$password');";
    }
    $res = $db->query($insert);
    return $res;
}



?>