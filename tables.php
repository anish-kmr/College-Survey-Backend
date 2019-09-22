<?php

$create_admin_query=
"
    CREATE TABLE admin ( 
        `adminID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL , 
        `email` VARCHAR(30) NOT NULL UNIQUE, 
        `department` VARCHAR(15) NOT NULL UNIQUE, 
        `password` VARCHAR(30) NOT NULL 
    )
";
    
$create_student_query=
"
    CREATE TABLE student ( 
        `studentID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `enrollmentNo` INT(9) NOT NULL UNIQUE, 
        `name` VARCHAR(30) NOT NULL , 
        `batch` VARCHAR(3) NOT NULL , 
        `year` INT(1) NOT NULL , 
        `email` VARCHAR(30) NOT NULL  UNIQUE, 
        `password` VARCHAR(30) NOT NULL 
    )
";
    
$create_faculty_query=
"
    CREATE TABLE faculty ( 
        `facultyID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL , 
        `email` VARCHAR(30) NOT NULL  UNIQUE, 
        `password` VARCHAR(30) NOT NULL 
    )
";
    



function set_ai($tablename,$start){
    return "alter table " .$tablename." AUTO_INCREMENT=".$start;
}
?>