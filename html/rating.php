<?php
include("../config/connect.php");
include("./api.php");
require '../OAuth/google_auth.php';	
$is_doc_status = isDoc($email, $conn);
$object = $_GET['stars'];


$patient_email = $email;
$object_pieces = explode(" ", $object);
$counsellor_email = $object_pieces[1];
$numStars = $object_pieces[0];
$add_type = $object_pieces[2];

// echo $numStars,$patient_email,$counsellor_email,$add_type;
updateRating($conn,$numStars,$patient_email,$counsellor_email,$add_type);
header("Location:http://localhost/addictionRemoval/html/index.php");
?>