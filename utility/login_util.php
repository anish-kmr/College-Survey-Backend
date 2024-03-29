<?php


function validateEmail($tablename,$email){
    global $db;
    $res = $db->query("Select email from ".$tablename." where email = '".$email."'");
    if($res){
        return 0;
    }
    else return 1;
}
function validateEno($eno){
    global $db;
    $res = $db->query("Select eno from student where enrollment_no = '".$eno."'");
    if($res){
        return 0;
    }
    else return 1;
}

function authenticate($tablename,$email,$password){
    global $db;
    
    $res = $db->query("Select * from ".$tablename." where email = '".$email."'");
    if($res){
        $dbpwd = $res[0]['password'];
        if(md5($password) == $dbpwd) return $res;
        else return 0;
    }
    else return -1;
}



function signin($tablename,$details){
    global $db;
    $res=0;
    if($tablename == "admin"){
        $name = $details['first_name']." ".$details['last_name'];
        $email = $details['email'];
        $department = $details['department'];
        $password = $details['password'];
        $encpwd = md5($password);
        $insert = "Insert into admin (name,email,department,password) values ('$name','$email','$department','$encpwd');";
        $res = $db->query($insert);
    }
    else if($tablename == "student"){
        $eno = $details['enrollment_no'];
        $name = $details['first_name']." ".$details['last_name'];
        $batch = $details['batch'];
        $year = $details['year'];
        $email = $details['email'];
        $type = $details['type'];
        $password = $details['password'];
        $encpwd = md5($password);
        $insert = "Insert into student (enrollmentNo,name,batch,year,type,email,password) values ($eno,'$name','$batch',$year,'$type','$email','$encpwd');";
        $res = $db->query($insert);
    }
    else if($tablename == "faculty"){
        $name = $details['first_name']." ".$details['last_name'];
        $email = $details['email'];
        $department = $details['department'];
        $password = $details['password'];
        $encpwd = md5($password);
        $sub = $details['subjects'];
        $batches = $details['batches'];
        $insert = "Insert into faculty (name,email,department,password) values ('$name','$email','$department','$encpwd');";
        $res = $db->query($insert);
        if($res){

            $fac = $db->query("Select facultyID from faculty where email='$email'");
            if($fac) $facID = $fac[0]['facultyID'];
            foreach ($batches as $sub=>$b) {
                $row = $db->query("Select * from subjects where name = '$sub'");
                
                if($row){
                    $subID = $row[0]['subjectID'];
                }
                else{
                    $r = $db->query("Insert into subjects (name) values ('$sub')");
                    if($r){
                        $s = $db->query("Select subjectID from subjects where name='$sub'");
                        if($s) $subID=$s[0]['subjectID'];
                    }
                }
                foreach ($b as $year => $batches) {
                    foreach ($batches as $batch) {
                        $y = (int)substr($year,-1);
                        $rl = $db->query("Insert into teaches (subjectID,facultyID,batch,year) values ($subID,$facID,'$batch',$y)");
                    }
                }
            }
        }
        
    }
    
    return $res;
}



?>