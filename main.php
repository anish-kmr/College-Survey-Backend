<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');

require_once "utility/setupDB.php";
require_once "admin/login.php";
require_once "student/login.php";
require_once "faculty/login.php";





?>