<!DOCTYPE html>
<html>
<head>
  <title>HomePage</title>
   <link rel="stylesheet" type="text/css" href="../css/homepage.css">
   <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
  <script src="../js/homepage.js"></script>
</head>
<body>

<?php 
require '../OAuth/google_auth.php';
include("../config/connect.php");
include("../html/api.php");
$is_doc_status = isDoc($email, $conn);

$result = checkBan($email,$conn);

if($result == 0)
{
  echo '<script type="text/javascript">'; 
  echo 'alert("You are banned for the moment for getting too many reports. Try again later.");'; 
  echo 'window.location.href = "?logout";';
  echo '</script>';
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
  <a href="index.php"><img src = "../images/home.png" class="icon"/> Home</a><br>
  <a href="chat.php"><img src = "../images/message.png" class="icon"/> Chats</a><br>
  <?php
    if($email == null){
      header("Location:http://localhost/addictionRemoval/OAuth/google_auth.php");
    }
    if($is_doc_status == 1)
    {
      echo '<a href="blog.php"><img src = "../images/blog.png" class="icon"/> Write Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php"><img src = "../images/person.png" class="icon"/> Find Counselor</a><br>';
    }
  ?>
  <!-- <a href="addictions.php">Find Counselor</a><br> -->
  <a href="rehab.php"> <img src = "../images/hospital.png" class="icon"/> Rehabilitation Centers</a><br>
  <a href="setting.php"> <img src = "../images/setting.png" class="icon"/> Settings</a><br>
  <a href="?logout"><img src = "../images/logout.png" class="icon"/> Logout </a><br>
</div>

<div class="main">
  

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
        <h2 class ="blogTitle">'. $row["title"]. '</h2> <p class="docNameBlog"> Dr. '.$docName.'</p>
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