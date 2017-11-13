<?php

include("../config/connect.php");
include("../html/api.php");
require '../OAuth/google_auth.php';


$firstname = $_POST['FirstName'];
$lastname = $_POST['LastName'];
$phonenumber = $_POST['PhoneNumber'];
$dob = $_POST['DateofBirth'];
$city = $_POST['city'];

$isSuccess = updateUser($email, $firstname, $lastname, $phonenumber, $dob, $city, $conn);
if ($isSuccess)
{
	header("Location:http://localhost/addictionRemoval/html/setting.php");
}

?>