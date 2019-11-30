<?php


function createSurvey($details){
    global $db;
    $rel=0;
    $name = $details['name'];
    $type = $details['type'];
    $adminID = $details['adminID'];
    $status = "active";
    $faculties = $details['faculties'];
    $questions = $details['questions'];
    $inserted = $db->query("Insert into survey (name,type,adminID,status) values ('$name','$type',$adminID,'$status')");
    if($inserted){
        $res = $db->query("select surveyID from survey where name='$name'");
        if($res) $surveyID = $res[0]['surveyID'];
        foreach ($faculties as $facultyID) {
            $rel = $db->query("Insert into faculty_survey values($surveyID , $facultyID)");
        }
        foreach ($questions as $qs) {
            $rel = $db->query("Insert into questions(surveyID,statement) values($surveyID , '$qs')");
        }


    }
    return $rel;
};
function getStudentSurveys($studentID,$status){
    global $db;
    $result=array("faculty"=>array(),"mess"=>array(),"hostel"=>array());
    $student = $db->query("select * from student where studentID = $studentID");
    if($student){
        $batch = $student[0]['batch'];
        $year = $student[0]['year'];
        $qry = "
        SELECT DISTINCT f.facultyID, f.name as name , s.surveyID,s.type,s.name as surveyName, s.adminID, s.status, t.batch, t.year, sub.name as subjectName 
        from 
            faculty_survey  as fs
        NATURAL JOIN 
        faculty as f
        INNER JOIN survey as s 
        	on s.surveyID = fs.surveyID 
        INNER JOIN teaches as t 
        	on fs.facultyID=t.facultyID 
        INNER JOIN subjects as sub
            on t.subjectID = sub.subjectID
        where 
            s.status= '$status' and t.batch='$batch' and t.year=$year and s.type='faculty'

        ";
        $fsurveys = $db->query($qry);
        if($fsurveys){
            foreach ($fsurveys as $s) {
                $qs = $db->query("select * from questions where surveyID = '$s[surveyID]'");
                $s['questions']=$qs;
                $s['sid']=$s['facultyID'];
                $fid=$s['facultyID'];
                $surid=$s['surveyID'];
                
                $fb = $db->query("
                                SELECT rating,response,qsID FROM 
                                `feedback` NATURAL JOIN responses 
                                where surveyID=$surid and facultyID=$fid and studentID=$studentID
                                "
                );

                
                    
                
                if($fb){
                    $s['rating']=$fb[0]['rating'];
                    $s['feedback']=$fb;
                }
                else{
                    foreach ($qs as $key => $object) {
                        unset($qs[$key]['statement']);
                        unset($qs[$key][2]);
                        unset($qs[$key][1]);
                        unset($qs[$key][0]);
                        $qs[$key]['response']=0;
    
                    }                    
                    $s['feedback']=$qs;
                    $s['rating']=0;
                }
                unset($s[0]);
                unset($s[1]);
                unset($s[2]);
                unset($s[3]);
                unset($s[4]);
                unset($s[5]);
                unset($s[6]);
                unset($s[7]);
                unset($s[8]);
                unset($s[9]);
                
                if(isset($result['faculty'][$s['surveyName']]))  array_push($result['faculty'][$s['surveyName']],$s);
                else $result['faculty'][$s['surveyName']]=array($s);
                

                // array_push($result['faculty'],$s);
            }
        }
        // if($type=="hosteller"){
            $mhsurveys = $db->query('select * from survey where type<>"faculty" ');
            if($mhsurveys){
                foreach ($mhsurveys as $m) {
                    $qs = $db->query("select * from questions where surveyID = '$m[surveyID]'");
                    $m['questions']=$qs;
                    $surid=$m['surveyID'];
                    $fid=0;
                    $fb = $db->query("
                                SELECT response,qsID FROM 
                                `feedback` NATURAL JOIN responses 
                                where surveyID=$surid and facultyID=$fid and studentID=$studentID
                                "
                            );
                    
                    if($fb) $m['feedback'] = $fb;
                    else{
                        foreach ($qs as $key => $object) {
                            unset($qs[$key]['statement']);
                            unset($qs[$key][2]);
                            unset($qs[$key][1]);
                            unset($qs[$key][0]);
                            $qs[$key]['response']=0;
                            $m['feedback']=$qs;
        
                        }
                    }
                    // $m['feedback'] = array_fill(0, count($qs), 0);
                    if($m['type'] == "mess") array_push($result['mess'],$m);
                    else if($m['type'] == "hostel") array_push($result['hostel'],$m);
                }
            }
        // }
        
        return $result;
    }


};

function getStudentFaculties($studentID,$past=false){
    global $db;
    $result=array("faculties"=>array());
    $student = $db->query("select batch,year from student where studentID = $studentID");
    if($student){
        $batch = $student[0]['batch'];
        $year = $student[0]['year'];
        $qry=
        "SELECT DISTINCT s.subjectID,s.name as subjectName, f.facultyID,f.name as facultyName 
        from 
        teaches as t inner JOIN faculty as f
             on t.facultyID=f.facultyID 
        inner join subjects as s 
            on t.subjectID=s.subjectID 
        where batch = '$batch' and year=$year";
        
        $faculties = $db->query($qry);
        if($faculties){
            foreach ($faculties as $key => $value) {
                unset($faculties[$key][0]);
                unset($faculties[$key][1]);
                unset($faculties[$key][2]);
                unset($faculties[$key][3]);
            }
            if($past){
                foreach ($faculties as $key => $value) {
                    $fid=$faculties[$key]['facultyID'];
                    $pr = $db->query("SELECT * FROM reviews where studentID=$studentID and facultyID=$fid");
                    if($pr){
                        $faculties[$key]['reviews']=$pr;
                    }
                }
            }
            $result["faculties"]=$faculties;
        }


    }
    return $result;
}

function getTotalStudents($facultyID){
    global $db;
    if($facultyID)
        $count = $db->query("SELECT COUNT(*) FROM student WHERE (batch,year) IN (SELECT batch,year FROM teaches WHERE facultyID=$facultyID)");
    if($count) return $count[0][0];
    else return -1;
}

function getTotalFeedbacks( $surveyID,$facultyID){
    global $db;
    if($facultyID)
        $count = $db->query("SELECT COUNT(*) FROM feedback WHERE surveyID=$surveyID and facultyID=$facultyID");
    if($count) return $count[0][0];
    else return -1;
}

function getAnalysis($surveyID,$facultyID){
    global $db;
    $result = array("avg_response"=>array(),"questions"=>array());
    $avg_res = $db->query("
        SELECT q.statement, r.qsID ,AVG(r.response) as average FROM feedback as f INNER JOIN responses as r on f.feedbackID=r.feedbackID inner join questions as q on q.qsID = r.qsID  WHERE f.facultyID=$facultyID and f.surveyID=$surveyID GROUP BY r.qsID
        ");
    if($avg_res){
        foreach ($avg_res as $a) {
            unset($a[0]);
            unset($a[1]);
            unset($a[2]);
            $qsid = $a['qsID'];
            $result['questions'][$qsid]=array();
            $qs_analysis=$db->query("SELECT COUNT(r.responseID) as count, r.response FROM feedback as f INNER JOIN responses as r on f.feedbackID=r.feedbackID WHERE f.facultyID=$facultyID and f.surveyID=$surveyID and r.qsID=$qsid GROUP BY r.response
            ");
            if($qs_analysis){
                $total_res = 0;
                foreach ($qs_analysis as $q) {
                    $total_res+=(int)$q['count'];
                }
                $result['questions'][$qsid]['statement']=$a['statement'];
                $result['questions'][$qsid]['total_responses']=$total_res;
                $result['questions'][$qsid]['analysis']=$qs_analysis;
            }
            array_push($result['avg_response'],$a);
        }
        return $result;
    }
}

function getAdminAnalysis($surveyID,$type){
    global $db;
    $result = array();
    if($type=="faculty"){
        $faculties = $db->query("SELECT Distinct facultyID,name,department from faculty_survey NATURAL JOIN faculty where surveyID=$surveyID");
    
        if($faculties){
            foreach ($faculties as $value) {
                $ts=getTotalStudents($value['facultyID']);
                $fg=getTotalFeedbacks($surveyID,$value['facultyID']);
                $result[$value['name']]=array(
                    "facultyID"=>$value['facultyID'],
                    "total_students"=>$ts,
                    "total_feedbacks_given"=>$fg,
                    "department"=>$value['department'],
                );
            }
        }
    
    }
    else{
        $totalfeeds = $db->query("SELECT DISTINCT COUNT(*) as c from feedback where surveyID=$surveyID");
        $totalreq = $db->query("SELECT DISTINCT COUNT(*) as c from  student");
        $result['total_feedbacks_given']=$totalfeeds[0]['c'];
        $result['total_feedbacks_required']=$totalreq[0]['c'];
    }
    
    return $result;

}

function updateStudentCoins($studentID,$coins){
    global $db;
    $status = $db->query("UPDATE student SET coins = coins+$coins WHERE studentID = $studentID");

    return "UPDATE student SET coins = coins+$coins WHERE studentID = $studentID";
}   
?>