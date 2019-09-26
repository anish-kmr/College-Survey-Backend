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
}

?>