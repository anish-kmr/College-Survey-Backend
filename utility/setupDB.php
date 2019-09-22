<?php
require_once "utility/db.php";
require_once "tables.php";

// $db->resetDatabase();  // use it only if schema (in tables.php) has changed to recreate it.



//Create all tables here if not already created

if(!$db->exist_table("admin")){
    $db->query($create_admin_query);
    $db->query(set_ai("admin",1000));
}
if(!$db->exist_table("student")){
    $db->query($create_student_query);
    $db->query(set_ai("student",2000));
}
if(!$db->exist_table("faculty")){
    $db->query($create_faculty_query);
    $db->query(set_ai("faculty",3000));
}

?>