<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
	include("../config/connect.php");
	include("../html/api.php");
	require '../OAuth/google_auth.php';

  	$HadAddictions = getAddictionsOfUser($email, $conn);
 	$Addictions = getAddictions($conn);
  	$leftAddictions = array_diff($Addictions, $HadAddictions); 
  	$i = 0;
  	$updateArr = array();
  	for($i;$i<sizeof($Addictions);$i++)
  	{
  		$elements = $_POST[strtolower($Addictions[$i])];
  		if($elements != "")
  			array_push($updateArr, $Addictions[$i]);
  	
  	}
  	updateAddictions($email, $updateArr, $conn);
  	header("Location:http://localhost/addictionRemoval/html/setting.php");



?>
</body>
</html>