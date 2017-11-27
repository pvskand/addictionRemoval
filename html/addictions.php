<!DOCTYPE html>
<html>
<head>
	<title>Addictions</title>
	<link rel="stylesheet" href="../css/addictions.css" />
	<link rel="stylesheet" href="../css/homepage.css" />
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
</head>
<body>
	
<?php
	include("../config/connect.php");
	include("../html/api.php");
	require '../OAuth/google_auth.php';

	if($email == null){
      header("Location:http://localhost/addictionRemoval/OAuth/google_auth.php");
    }

    $sudo=getPseudonym($email,$conn);
$rating=getRating($email,$conn);
$comname = $name." (".$sudo.")";
?>
<div id="mySidenav" class="sidenav">
  <div id="profileDiv"> 
    <img src="../images/profile.png" id="profilePhoto" />
  </div>
  <center><h3 id='personName'> <?php echo($comname); ?></h3></center>
  <center><h3 id='personName'> Rating: <?php echo($rating); ?></h3></center>
  <div id="seperate"> </div>
  <a href="index.php"> <img src = "../images/home.png" class="icon"/> Home </a><br>
  <a href="chat.php"><img src = "../images/message.png" class="icon"/> Chats </a><br>
  <?php
  $is_doc_status = isDoc($email,$conn);
    if($is_doc_status == 1)
    {
      echo '<a href="blog.php"><img src = "../images/blog.png" class="icon"/> Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php"><img src = "../images/person.png" class="icon"/> Find Counselor</a><br>';
    }
  ?>
  <a href="rehab.php"> <img src = "../images/hospital.png" class="icon"/> Rehabilitation Centers</a><br>
  <a href="setting.php"> <img src = "../images/setting.png" class="icon"/> Settings </a><br>
  <a href="?logout"> <img src = "../images/logout.png" class="icon"/> Logout </a><br>
</div>


<div class="main">
	<div id="maindiv">
<?php
	$addictionArray = getAddictions($conn);
	$str="addiction";
	$i=0;
	for ($i;$i<count($addictionArray);$i++)
	{
		$image_name = strtolower($addictionArray[$i]);
		echo '
			<div class="gallery">
				<a href="addi_form.php?' .$str. '='.$image_name.'" ><img class= "addictionsList" src="../images/'. $image_name. '.jpg" alt="drugs" width="300" height="200" ></a>
			<center><p class="desc" >'. $addictionArray[$i]. '</p><center>
			</div>';
	}
?>
</div>
</div>
</body>
</html>