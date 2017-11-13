<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	 <link rel="stylesheet" type="text/css" href="../css/homepage.css">
	<script src="../js/homepage.js"></script>
</head>
<body bgcolor="#C4EEA2">

<?php 

include("../config/connect.php");
include("../html/api.php");
require '../OAuth/google_auth.php';

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
  <a href="settings.php">Settings</a><br>
  <a href="#">Logout</a><br>
</div>

<div class="main">
  <div id="pageHeaderDiv">
  <center><h1 id ="pageTitle">Settings</h1></center> 
  </div>
  <br><br><br><br><br><br><br>

  <form id="form" name="form" method="post" action="save_setting.php">

  <center>
  <div id="maindiv">
<?php
  $getArray = getUserDetails($email, $conn);
?>

    <div class = "eleregis" id="firstlastname">
      <div class="names"> 
        <label for="FirstName">First name</label><br>
        <input type="text" name="FirstName" <?php echo "value ='$getArray[0]'"; ?> id="first-name">
          </div>
          <div class = "names">
              <label for="LastName">Second name</label><br>
            <input type="text" name="LastName" <?php echo "value ='$getArray[1]'"; ?>  id="last-name">
      </div>
    </div>
    <br>


      <div class = "eleregis">
      <label for="PhoneNumber">Contact number</label><br>
      <input type="phonenumber" name="PhoneNumber" <?php echo "value ='$getArray[3]'"; ?>  id="PhoneNumber">
      </div>
      <br>

      <div class = "eleregis">
      <label for="DOB">Date of Birth</label><br>
      <input type="date" name="DateofBirth" <?php echo "value ='$getArray[5]'"; ?>  id="DOB">
      </div>
      <br>

      <div class = "eleregis">    
      <label for="city">City</label><br>
      <input type="text" name="city" <?php echo "value ='$getArray[4]'"; ?>  id="city">
      </div>
      <br>
      <div class = "eleregis">
      <input type="submit" value="Save" onclick="submitForm()">
      <input type="reset" value="Reset">
      </div>
      <br>

    </div>
    </center>
  </form>
  </div>
  

     
</body>
</html>


