<?php 
require '../OAuth/google_auth.php';
include("../config/connect.php");
include("./api.php");


$firstname = $_POST['FirstName'];
$lasname = $_POST['LastName'];
$phonenumber = $_POST['PhoneNumber'];
$dob = $_POST['DateofBirth'];
$city = $_POST['city'];

if ($_POST['doctor'] == true)
{
	$isDoc = '1';
}
else
{
	$isDoc = '0';	
}

addUser($email, $firstname, $lastname, $phonenumber, $dob, $city, $isDoc, $conn);
header("Location:http://localhost/addictionRemoval/html/index.php");









?>