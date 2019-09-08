<?php

$create_admin_query=
"
    CREATE TABLE admin ( 
        `adminID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL , 
        `email` VARCHAR(30) NOT NULL , 
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
        `year` DATE NOT NULL , 
        `email` VARCHAR(30) NOT NULL , 
        `password` VARCHAR(30) NOT NULL 
    )
";
    
$create_faculty_query=
"
    CREATE TABLE faculty ( 
        `facultyID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL , 
        `email` VARCHAR(30) NOT NULL , 
        `password` VARCHAR(30) NOT NULL 
    )
";
    





function set_ai($tablename){
    return "alter table " .$tablename." AUTO_INCREMENT=1001";
}
?>