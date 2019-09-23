<?php

$create_admin_query=
"
    CREATE TABLE admin ( 
        `adminID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL , 
        `email` VARCHAR(30) NOT NULL UNIQUE, 
        `department` VARCHAR(15) NOT NULL, 
        `password` VARCHAR(32) NOT NULL 
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
        `type` VARCHAR(10) NOT NULL, 
        `password` VARCHAR(32) NOT NULL 
    )
";
    
$create_faculty_query=
"
    CREATE TABLE faculty ( 
        `facultyID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL , 
        `email` VARCHAR(30) NOT NULL  UNIQUE, 
        `department` VARCHAR(15) NOT NULL , 
        `password` VARCHAR(32) NOT NULL 
    )
";


$create_teaches_query=
"
    CREATE TABLE teaches ( 
        `subjectID` INT(5), 
        `facultyID` INT(5), 
        FOREIGN KEY(subjectID) REFERENCES subjects(subjectID),
        FOREIGN KEY(facultyID) REFERENCES faculty(facultyID)

    )
";

$create_subjects_query=
"
    CREATE TABLE subjects ( 
        `subjectID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL UNIQUE

    )
";
    


function set_ai($tablename,$start){
    return "alter table " .$tablename." AUTO_INCREMENT=".$start;
}
?>