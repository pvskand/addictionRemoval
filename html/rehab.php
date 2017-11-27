<?php 
require '../OAuth/google_auth.php';
include("../config/connect.php");
include("../html/api.php");
$is_doc_status = isDoc($email, $conn);
$sudo=getPseudonym($email,$conn);
$rating=getRating($email,$conn);
$comname = $name." (".$sudo.")";
if($email == null){
      header("Location:http://localhost/addictionRemoval/OAuth/google_auth.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rehabilitation</title>
	<link rel="stylesheet" href="../css/homepage.css" />
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
</head>
<body>
	
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
    if($is_doc_status == 1)
    {
      echo '<a href="blog.php"><img src = "../images/blog.png" class="icon"/> Write Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php"><img src = "../images/person.png" class="icon"/> Find Counselor </a><br>';
    }
  ?>
  <a href="rehab.php"> <img src = "../images/hospital.png" class="icon"/> Rehabilitation Centers</a><br>
  <a href="setting.php"> <img src = "../images/setting.png" class="icon"/> Settings </a><br>
  <a href="?logout"> <img src = "../images/logout.png" class="icon"/> Logout </a><br>
</div>


<div class="main">
	<div id="maindiv">
<?php


	$center_array = getcenters($conn);
	$str="addiction";
	$i=0;
	for ($i;$i<count($center_array);$i++)
	{
		
		echo '
			<div class="divBlog">
				<center><h2>'. $center_array[$i]['name_centre']. '</h2><center>
				<center><h3>'. $center_array[$i]['address']. '</h3><center>
				<center><h3>'. $center_array[$i]['contact_info']. '</h3><center>
				<center><h3>'. $center_array[$i]['email_address']. '</h3><center>
				<a href="'.$center_array[$i]['web_address'].'"><center><h2>'. $center_array[$i]['web_address']. '</h2><center></a>
			</div>';
	}
?>
</div>
</div>
</body>
</html>