<?php

require_once "utility/db.php";

$pwd = md5('123');
$admin = "INSERT INTO admin 
    (adminID, name, email, department, password) VALUES 
    (1001, 'Anish', 'anish12k07@gmail.com', 'Head','$pwd' )
";
$faculty = "INSERT INTO faculty 
    (facultyID, name, email, department, password) VALUES 
    (3001, 'Keshav', 'keshav@gmail.com', 'cse', '$pwd'), 
    (3002, 'MKT', 'mkt@gmail.com', 'cse', '$pwd'), 
    (3003, 'Dharamveer', 'dharam@gmail.com', 'cse', '$pwd'), 
    (3004, 'Manju', 'manju@gmail.com', 'cse', '$pwd'), 
    (3005, 'Manjeet', 'manjeet@gmail.com', 'cse', '$pwd'), 
    (3006, 'Atul', 'atul@gmail.com', 'cse', '$pwd')
    
"; 
$student = "INSERT INTO student 
(studentID, enrollmentNo, name, batch, year, email, type, password) VALUES 
(2001, 18103001, 'Avinash_b1', 'B1', 2, 'a1@gmail.com', 'hosteller', '$pwd'),
(2002, 18103002, 'Aviral_b1', 'B1', 2, 'av1@gmail.com', 'hosteller', '$pwd'),
(2003, 18103003, 'Shreyansh_b1', 'B1', 2, 'sh1@gmail.com', 'hosteller', '$pwd'),
(2004, 18103030, 'anish_b1', 'B1', 2, 'an1@gmail.com', 'day scholar', '$pwd'),

(2005, 18103004, 'Avinash_b2', 'B2', 2, 'a2@gmail.com', 'hosteller', '$pwd'),
(2006, 18103005, 'Aviral_b2', 'B2', 2, 'av2@gmail.com', 'hosteller', '$pwd'),
(2007, 18103006, 'Shreyansh_b2', 'B2', 2, 'sh2@gmail.com', 'day scholar', '$pwd'),
(2008, 18103007, 'anish_b2', 'B2', 2, 'an2@gmail.com', 'day scholar', '$pwd'),

(2009, 18103008, 'Avinash_B3', 'B3', 2, 'a3@gmail.com', 'hosteller', '$pwd'),
(2010, 18103009, 'Aviral_B3', 'B3', 2, 'av3@gmail.com', 'hosteller', '$pwd'),
(2011, 18103010, 'Shreyansh_B3', 'B3', 2, 'sh3@gmail.com', 'hosteller', '$pwd'),
(2012, 18103011, 'anish_B3', 'B3', 2, 'an3@gmail.com', 'day scholar', '$pwd'),

(2013, 18103012, 'Avinash_B4', 'B4', 2, 'a4@gmail.com', 'day scholar', '$pwd'),
(2014, 18103013, 'Aviral_B4', 'B4', 2, 'av4@gmail.com', 'hosteller', '$pwd'),
(2015, 18103014, 'Shreyansh_B4', 'B4', 2, 'sh4@gmail.com', 'hosteller', '$pwd'),
(2016, 18103015, 'anish_B4', 'B4', 2, 'an4@gmail.com', 'day scholar', '$pwd'),

(2017, 18103016, 'Avinash_B5', 'B5', 2, 'a5@gmail.com', 'hosteller', '$pwd'),
(2018, 18103017, 'Aviral_B5', 'B5', 2, 'av5@gmail.com', 'day scholar', '$pwd'),
(2019, 18103018, 'Shreyansh_B5', 'B5', 2, 'sh5@gmail.com', 'hosteller', '$pwd'),
(2020, 18103019, 'anish_B5', 'B5', 2, 'an5@gmail.com', 'hosteller', '$pwd'),

(2021, 18103020, 'Avinash_B6', 'B6', 2, 'a6@gmail.com', 'day scholar', '$pwd'),
(2022, 18103021, 'Aviral_B6', 'B6', 2, 'av6@gmail.com', 'day scholar', '$pwd'),
(2023, 18103022, 'Shreyansh_B6', 'B6', 2, 'sh6@gmail.com', 'hosteller', '$pwd'),
(2024, 18103023, 'anish_B6', 'B6', 2, 'an6@gmail.com', 'day scholar', '$pwd')
";

$subjects = " INSERT INTO subjects 
    (subjectID, name) VALUES 
    ('6001', 'DBW'),   
    ('6002', 'DS'),     
    ('6003', 'TFCS'), 
    ('6004', 'ES2')
    ";
$teaches = "INSERT INTO teaches 
    (facultyID,subjectID,batch,year) VALUES 
    (3001,6003,'B1',2),
    (3001,6003,'B2',2),
    (3001,6001,'B3',2),
    (3001,6001,'B4',2),

    (3002,6002,'B1',2),
    (3002,6002,'B2',2),
    (3002,6001,'B5',2),
    (3002,6001,'B6',2),

    (3003,6001,'B1',2),
    (3003,6001,'B2',2),
    (3003,6003,'B3',2),
    (3003,6003,'B4',2),

    (3004,6004,'B5',2),
    (3004,6004,'B6',2),
    (3004,6002,'B3',2),
    (3004,6002,'B4',2),

    (3005,6003,'B5',2),
    (3005,6003,'B6',2),
    (3005,6004,'B3',2),
    (3005,6004,'B4',2),

    (3006,6004,'B1',2),
    (3006,6004,'B2',2),
    (3006,6002,'B5',2),
    (3006,6002,'B6',2)

";

if($db->query($admin)) echo "Admin filled \n ";
if($db->query($faculty)) echo "Faculty filled \n";
if($db->query($student)) echo "Student filled \n";
if($db->query($subjects)) echo "Subjets filled \n";
if($db->query($teaches)) echo "Teaches filled \n";

?>