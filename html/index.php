<!DOCTYPE html>
<html>
<head>
  <title>HomePage</title>
   <link rel="stylesheet" type="text/css" href="../css/homepage.css">
  <script src="../js/homepage.js"></script>
</head>
<body bgcolor="#C4EEA2">

<?php 
require '../OAuth/google_auth.php';
include("../config/connect.php");
include("../html/api.php");
$is_doc_status = isDoc($email, $conn);
?>



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
      echo '<a href="blog.php">Write Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php">Find Counselor</a><br>';
    }
  ?>
  <!-- <a href="addictions.php">Find Counselor</a><br> -->
  <a href="#">Rewards</a><br>
  <a href="#">Rehabilitation Centers</a><br>
  <a href="setting.php">Settings</a><br>
  <a href="?logout"> Logout </a><br>
</div>

<div class="main">
  <div id="pageHeaderDiv">
  <center><h1 id ="pageTitle">Addiction Removal</h1></center> 
  </div>
  <br><br><br><br><br>

<?php 
// showing the feed with blogs written by different doctors.
$blog = "SELECT * FROM blog";
$blogResult = $conn->query($blog);
if ($blogResult->num_rows > 0) 
{
  // output data of each row
    while($row = $blogResult->fetch_assoc()) {
        
        $email = $row["doctor_member_email"];
        $docName = getDocName($email, $conn);
        echo '<div class="divBlog">
        <p class ="blogTitle">'. $row["title"]. '</p> <p class="docNameBlog"> Dr.'.$docName.'</p>
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