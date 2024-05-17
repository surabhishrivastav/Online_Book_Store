<?php

$host = "localhost";
$user = "root";
$pass = "";
$database = "bookbridge";

$con = mysqli_connect($host, $user, $pass, $database);
/* if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} */

$baseUrl = "http://localhost/bookbridge";
date_default_timezone_set("Asia/Calcutta");
$current_date_time = date("Y-m-d H:i:s");
session_start();
?>