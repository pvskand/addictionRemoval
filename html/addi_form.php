<?php 
require '../OAuth/google_auth.php';
include("../config/connect.php");
include("./api.php");


$add_type = $_GET['addiction'];
$q = "SELECT * FROM member_had_addictions WHERE member_email='$email' AND addictions_addictionName='$add_type'";
$result = $conn->query($q);
if($result->num_rows>0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("You have this addiction removed. Please go to the settings page & remove the addiction and then find a counsellor.");'; 
	echo 'window.location.href = "setting.php";';
	echo '</script>';

}
else{
	if(isExistingCase($email,$add_type,$conn)==0){
		$counsellor_email = Matching_algo($email,$add_type,$conn);
		update_case_table($conn,$counsellor_email,$email,$add_type);


		//echo $counsellor_email;
		//echo $add_type;
		$s = "Case with counsellor email ".$counsellor_email." opened corresponding to ".$add_type;
		echo '<script type="text/javascript">'; 
		if($counsellor_email == null)
		{
			echo 'alert("No User found corresponding to this addiction !");';
		}
		else 
		{
			echo 'alert("Case opened !");';	
		}

		echo 'window.location.href = "chat.php";';
		echo '</script>';
		}
	else {
		echo '<script type="text/javascript">'; 
		echo 'alert("You have a case opened with this addiction already ! Close it to open a new case.");'; 
		echo 'window.location.href = "chat.php";';
		echo '</script>';
	}
}

?>