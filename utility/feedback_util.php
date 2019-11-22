<?php

function createFeedback($data){
    global $db;
    $result=1;
    $adminID = $data['adminID'];
    $facultyID = $data['facultyID'];
    $surveyID = $data['surveyID'];
    $studentID = $data['studentID'];
    $feedback = $data['feedback'];
    $rating = $data['rating'];
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

            $rated = $db->query("UPDATE feedback SET rating = $rating WHERE feedbackID = $feedbackID");
            $res = $db->query("UPDATE responses SET response = $response WHERE feedbackID = $feedbackID and qsID = $qsID");
            updateRating($facultyID);
            if(!$res || !$rated) $result = 0;
        }
        $result = -1;
    }
    else{
        $inserted = $db->query("Insert into feedback (adminID,facultyID,rating,surveyID,studentID) values ($adminID,$facultyID,$rating,$surveyID,$studentID)");
        echo "new\n$inserted\n";
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
                updateRating($facultyID);
            }
        }
        else{
            $result = 0;
        }
    }
    return $result;
}

function updateRating($facultyID){
    global $db;
    $sel = $db->query("SELECT AVG(rating) as avg_rating from feedback where facultyID=$facultyID");
    if($sel){
        $avg_rating=$sel[0]['avg_rating'];
        $updated = $db->query("UPDATE faculty SET rating = $avg_rating WHERE facultyID = $facultyID");
        if($updated) return 1;
        else return 0;
    }
    else return 0;

}


?>