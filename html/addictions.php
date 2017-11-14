<!DOCTYPE html>
<html>
<head>
	<title>Addictions</title>
	<link rel="stylesheet" href="../css/addictions.css" />
	<link rel="stylesheet" href="../css/homepage.css" />
</head>
<body>
	
<div id="mySidenav" class="sidenav">
  <div id="profileDiv"> 
    <img src="../images/profile.png" id="profilePhoto" />
  </div>
  <div id="seperate"> </div>
  <a href="index.php">Home</a><br>
  <a href="chat.php">Chats</a><br>
  <?php
    if($is_doc_status == 1)
    {
      echo '<a href="blog.php">Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php">Find Counselor</a><br>';
    }
  ?>
  <a href="#">Rewards</a><br>
  <a href="#">Rehabilitation Centers</a><br>
  <a href="settings.php">Settings</a><br>
  <a href="?logout"> Logout </a><br>
</div>


<div class="main">
	<div id="maindiv">
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
</div>
</div>
</body>
</html>