<!DOCTYPE html>
<html>
<head>
	<title>HomePage</title>
	<link rel="stylesheet" href="../css/homepage.css" />
	<script src="../js/homepage.js"></script>
</head>
<body>

<?php 

include("../config/connect.php");
include("../html/api.php");

?>



<div id="mySidenav" class="sidenav">
  <a href="#">Home</a>
  <a href="#">Chats</a>
  <a href="#">Find Counselor</a>
  <a href="#">Rewards</a>
  <a href="#">Rehabilitation Centers</a>
  <a href="#">Logout</a>
</div>

<div class="main">
  <center><h1>Home Page</h1></center>

<?php 



// showing the feed with blogs written by different doctors.

$blog = "SELECT * FROM Blog";
$blogResult = $conn->query($blog);

if ($blogResult->num_rows > 0) 
{
	// output data of each row
    while($row = $blogResult->fetch_assoc()) 
    {
        
        $email = $row["Doctor_Member_email"];
        $docName = getDocName($email, $conn);
        echo "<h2>". $row["title"]. "</h2>";
        echo $docName;
        echo  "<p>".$row["message"]. "</p><br>";
        
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


