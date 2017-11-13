<?php 
require '../OAuth/google_auth.php';
include("../config/connect.php");
include("./api.php");


$add_type = $_GET['addiction'];

if(isExistingCase($email,$add_type,$conn)==0){
	$counsellor_email = Matching_algo($email,$add_type,$conn);
	echo $counsellor_email;
	echo $add_type;
	update_case_table($conn,$counsellor_email,$email,$add_type);
}
else {
	echo 'You have a case opened with this addiction already ! Close it to open a new case.';
}

?>