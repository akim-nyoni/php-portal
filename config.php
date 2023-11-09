<?php
session_start();
$servername = "localhost";
$username = "root";
$sec_code = "";
$dbname = "mobdb";

// Create connection
$conn = mysqli_connect($servername, $username, $sec_code, $dbname) or die(mysqli_error($conn));
// Check connection
mysqli_select_db($conn, 'mobdb') or die(mysqli_error($conn));

//Variables
$msg = "";
$_SESSION['success'] = "";
$msg = $_SESSION['success'];
