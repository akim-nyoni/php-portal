<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mobdb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname) or die(mysqli_error($conn));
// Check connection
mysqli_select_db($conn, 'mobdb') or die(mysqli_error($conn));

//Variables
$msg = "";
$_SESSION['success'] = "";
$msg = $_SESSION['success'];
