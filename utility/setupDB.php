<?php
require_once "utility/db.php";
require_once "tables.php";

// $db->resetDatabase();  // use it only if schema (in tables.php) has changed to recreate it.



//Create all tables here if not already created

if(!$db->exist_table("admin")){
    $db->query($create_admin_query);
    $db->query(set_ai("admin",1000));
    echo "Admin created <br>";
    
}
if(!$db->exist_table("student")){
    $db->query($create_student_query);
    $db->query(set_ai("student",2000));
    echo "Student created <br>";
}
if(!$db->exist_table("faculty")){
    $db->query($create_faculty_query);
    $db->query(set_ai("faculty",3000));
    echo "faculty created <br>";
}
if(!$db->exist_table("subjects")){
    $db->query($create_subjects_query);
    $db->query(set_ai("subjects",4000));
    echo "subjects created <br>";
    
}
if(!$db->exist_table("teaches")){
    $db->query($create_teaches_query);
    echo "teaches created <br>";
}
if(!$db->exist_table("survey")){
    $db->query($create_survey_query);
    $db->query(set_ai("subjects",5000));
    echo "survey created <br>";
}
if(!$db->exist_table("questions")){
    $db->query($create_questions_query);
    $db->query(set_ai("subjects",6000));
    echo "questions created <br>";
}
if(!$db->exist_table("templates")){
    $db->query($create_templates_query);
    echo "templates created <br>";
    $res = $db->multi_query($insert_template_query);
    if($res) echo "Templates created";
}
if(!$db->exist_table("templateQs")){
    $db->query($create_templateQs_query);
    echo "templateQs created <br>";
    $res = $db->multi_query($insert_templateqs_query);
    if($res) echo "Templates question created";
}


?>