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
        `type` VARCHAR(15) NOT NULL, 
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
        `rating` DECIMAL(2,1) NOT NULL , 
        `password` VARCHAR(32) NOT NULL 
    )
";
$create_survey_query=
"
    CREATE TABLE survey ( 
        `surveyID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL , 
        `type` VARCHAR(20) NOT NULL , 
        `adminID` INT(5) NOT NULL , 
        `status` VARCHAR(10) NOT NULL ,
        FOREIGN KEY(adminID) REFERENCES admin(adminID)
        
    )
";
$create_feedback_query=
"
    CREATE TABLE feedback ( 
        `feedbackID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `adminID` INT(5) NOT NULL , 
        `facultyID` INT(5) NOT NULL , 
        `rating` INT(1) NOT NULL,
        `surveyID` INT(5) NOT NULL , 
        `studentID` INT(5) NOT NULL , 
        FOREIGN KEY(adminID) REFERENCES admin(adminID),
        FOREIGN KEY(facultyID) REFERENCES faculty(facultyID),
        FOREIGN KEY(surveyID) REFERENCES survey(surveyID),
        FOREIGN KEY(studentID) REFERENCES student(studentID)
        
    )
";
$create_templates_query=
"
    CREATE TABLE templates ( 
        `templateID` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL 
    )
";
$create_templateQs_query=
"
    CREATE TABLE templateQs ( 
        `tqsID` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `statement` TEXT NOT NULL ,
        `templateID` INT(3) NOT NULL ,
        FOREIGN KEY(templateID) REFERENCES templates(templateID)
    )
";

$create_questions_query=
"
    CREATE TABLE questions ( 
        `qsID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `surveyID` INT(5) NOT NULL , 
        `statement` TEXT NOT NULL , 
        FOREIGN KEY(surveyID) REFERENCES survey(surveyID)
        
    )
";
$create_responses_query=
"
    CREATE TABLE responses ( 
        `responseID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `feedbackID` INT(5) NOT NULL , 
        `qsID` INT(5) NOT NULL , 
        `response` INT(2) NOT NULL , 
        FOREIGN KEY(feedbackID) REFERENCES feedback(feedbackID),
        FOREIGN KEY(qsID) REFERENCES questions(qsID)
        
    )
";
$create_review_query=
"
    CREATE TABLE review ( 
        `reviewID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `facultyID` INT(5) NOT NULL ,  
        `subjectID` INT(5) NOT NULL ,  
        `title` VARCHAR(30) ,
        `review` TEXT, 
        FOREIGN KEY(facultyID) REFERENCES faculty(facultyID),
        FOREIGN KEY(subjectID) REFERENCES subjects(subjectID)
        
    )

";

$create_teaches_query=
"
    CREATE TABLE teaches ( 
        `subjectID` INT(5), 
        `facultyID` INT(5), 
        `batch` VARCHAR(4),
        `year` INT(2),
        FOREIGN KEY(subjectID) REFERENCES subjects(subjectID),
        FOREIGN KEY(facultyID) REFERENCES faculty(facultyID)

    )
";
$create_faculty_survey_query=
"
    CREATE TABLE faculty_survey( 
        `surveyID` INT(5), 
        `facultyID` INT(5), 
        FOREIGN KEY(surveyID) REFERENCES survey(surveyID),
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


$insert_template_query = 
"
    INSERT INTO `templates` (`templateID`,`name`) VALUES ('1','faculty');
    INSERT INTO `templates` (`templateID`,`name`) VALUES ('2','mess');
    INSERT INTO `templates` (`templateID`,`name`) VALUES ('3','hostel');
";


$insert_templateqs_query = 
"
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs11','1');
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs12','1');
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs13','1');
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs21','2');
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs22','2');
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs23','2');
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs31','3');
    INSERT INTO `templateQs` (`statement`,`templateID`) VALUES ('qs32','3');
";




function set_ai($tablename,$start){
    return "alter table " .$tablename." AUTO_INCREMENT=".$start;
}
?>