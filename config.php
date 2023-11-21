<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$servername = "localhost";
$username = "";
$sec_code = "";
$dbname = "";

// Create connection
$conn = mysqli_connect($servername, $username, $sec_code, $dbname) or die(mysqli_error($conn));
// Check connection
mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));

//Variables
$msg = "";

if (isset($_SESSION['success'])) {
    $msg = $_SESSION['success'];
} else {
    $_SESSION['success'] = false;
}
