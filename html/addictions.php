<!DOCTYPE html>
<html>
<head>
	<title>Addictions</title>
	<link rel="stylesheet" href="../css/addictions.css" />
</head>
<body>
	

<?php
	include("../config/connect.php");
	include("../html/api.php");
	require '../OAuth/google_auth.php';

	$addictionArray = getAddictions($conn);
	$str="addiction";
	$i=0;
	for ($i;$i<count($addictionArray);$i++)
	{
		$image_name = strtolower($addictionArray[$i]);
		echo '
			<div class="gallery">
				<a href="addi_form.php?' .$str. '='.$image_name.'" ><img src="../images/'. $image_name. '.jpg" alt="drugs" width="300" height="200" ></a>
			<div class="desc">'. $addictionArray[$i]. '</div>
			</div>';
	}
?>

</body>
</html>