<?php

function createFeedback($data){
    global $db;
    $result=1;
    $adminID = $data['adminID'];
    $facultyID = $data['facultyID'];
    $surveyID = $data['surveyID'];
    $studentID = $data['studentID'];
    $feedback = $data['feedback'];
    $qry = "
    Select feedbackID from feedback 
    where 
    adminID=$adminID and 
    facultyID=$facultyID and 
    surveyID=$surveyID and
    studentID=$studentID
    ";
    $exists = $db->query($qry);
    if($exists){
        $feedbackID = $exists[0]['feedbackID'];
        foreach ($feedback as $f) {
            $qsID = $f['qsID'];
            $response = $f['response'];
            $res = $db->query("UPDATE responses SET response = $response WHERE feedbackID = $feedbackID and qsID = $qsID");
            if(!$res) $result = 0;
        }
        $result = -1;
    }
    else{
        $inserted = $db->query("Insert into feedback (adminID,facultyID,surveyID,studentID) values ($adminID,$facultyID,$surveyID,$studentID)");
        if($inserted){
            $select = $db->query($qry);
            if($select){ 
                $feedbackID = $select[0]['feedbackID'];
                foreach ($feedback as $f) {
                    $qsID = $f['qsID'];
                    $response = $f['response'];
                    $res = $db->query("Insert into responses(feedbackID,qsID,response) values ($feedbackID,$qsID,$response)");
                    if(!$res) $result = 0;
                }
            }
        }
        else{
            $result = 0;
        }
    }
    return $result;
}


?>