<!DOCTYPE html>
<html>
<head>
	<title>HomePage</title>
	 <link rel="stylesheet" type="text/css" href="../css/homepage.css">
	<script src="../js/homepage.js"></script>
</head>
<body bgcolor="#C4EEA2">

<?php 

include("../config/connect.php");
include("../html/api.php");

?>



<div id="mySidenav" class="sidenav">
  <div id="profileDiv"> 
    <img src="../images/profile.png" id="profilePhoto" />
  </div>
  <div id="seperate"> </div>
  <a href="#">Home</a><br>
  <a href="#">Chats</a><br>
  <a href="addictions.php">Find Counselor</a><br>
  <a href="#">Rewards</a><br>
  <a href="#">Rehabilitation Centers</a><br>
  <a href="#">Settings</a><br>
  <a href="#">Logout</a><br>
</div>

<div class="main">
  <div id="pageHeaderDiv">
  <center><h1 id ="pageTitle">Addiction Removal</h1></center> 
  </div>
  <br><br><br><br><br>

<?php 



// showing the feed with blogs written by different doctors.

$blog = "SELECT * FROM Blog";
$blogResult = $conn->query($blog);

if ($blogResult->num_rows > 0) 
{
	// output data of each row
    while($row = $blogResult->fetch_assoc()) {
        
        $email = $row["doctor_member_email"];
        $docName = getDocName($email, $conn);
        echo '<div class="divBlog">
        <p class ="blogTitle">'. $row["title"]. '</p> <p class="docNameBlog">'.$docName.'</p>
        <p class="blogContent">'.$row["message"]. '</p>
        </div>';
        
    }
}
else
{
	echo "No blogs found. ";
}

?>
</div>
     

     
</body>
</html>


