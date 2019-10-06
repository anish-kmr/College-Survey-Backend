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
function getStudentSurveys($studentID){
    global $db;
    $result=array("faculty"=>array(),"mess"=>array(),"hostel"=>array());
    $student = $db->query("select * from student where studentID = $studentID");
    if($student){
        $batch = $student[0]['batch'];
        $year = $student[0]['year'];
        $type = $student[0]['type'];
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
            s.status='active' and t.batch='$batch' and t.year=$year

        ";
        $fsurveys = $db->query($qry);
        if($fsurveys){
            foreach ($fsurveys as $s) {
                $qs = $db->query("select * from questions where surveyID = '$s[surveyID]'");
                $s['questions']=$qs;
                $s['sid']=$s['facultyID'];

                foreach ($qs as $key => $object) {
                    unset($qs[$key]['statement']);
                    unset($qs[$key][2]);
                    unset($qs[$key][1]);
                    unset($qs[$key][0]);
                    $qs[$key]['response']=0;

                }
                $s['feedback']=$qs;
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
                array_push($result['faculty'],$s);
            }
        }
        // if($type=="hosteller"){
            $mhsurveys = $db->query('select * from survey where type<>"faculty" ');
            if($mhsurveys){
                foreach ($mhsurveys as $m) {
                    $qs = $db->query("select * from questions where surveyID = '$m[surveyID]'");
                    $m['questions']=$qs;
                    $m['feedback'] = array_fill(0, count($qs), 0);
                    if($m['type'] == "mess") array_push($result['mess'],$m);
                    else if($m['type'] == "hostel") array_push($result['hostel'],$m);
                }
            }
        // }
        
        return $result;
    }


};


function getTotalStudents($facultyID){
    global $db;
    $count = $db->query("SELECT COUNT(*) FROM student WHERE (batch,year) IN (SELECT batch,year FROM teaches WHERE facultyID=$facultyID)");
    if($count) return $count[0][0];
    else return 0;
}

function getTotalFeedbacks( $surveyID,$facultyID){
    global $db;
    
    $count = $db->query("SELECT COUNT(*) FROM feedback WHERE surveyID=$surveyID and facultyID=$facultyID");
    if($count) return $count[0][0];
    else return 0;
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


?>