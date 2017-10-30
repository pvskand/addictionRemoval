<?php 
require '../OAuth/google_auth.php';
include("../config/connect.php");
include("./api.php");


$firstname = $_GET['drinking'];
echo $firstname;

// addUser($email, $firstname, $lastname, $phonenumber, $dob, $city, $isDoc, $conn);
// header("Location:http://localhost/addictionRemoval/html/index.php");









?>