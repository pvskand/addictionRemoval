<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	 <link rel="stylesheet" type="text/css" href="../css/homepage.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

   <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
   <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
   <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css'>

   <link rel="stylesheet" href="../css/style_setting.css">
	<script src="../js/homepage.js"></script>
</head>
<body bgcolor="#C4EEA2">

<style type="text/css">
    
   img {
    width: 100%;
    height: 150px;
}


</style>



<?php 

include("../config/connect.php");
include("../html/api.php");
require '../OAuth/google_auth.php';
$is_doc_status = isDoc($email, $conn);

?>



<div id="mySidenav" class="sidenav">
  <div id="profileDiv"> 
    <img src="../images/profile.png" id="profilePhoto" />
  </div>
  <div id="seperate"> </div>
  <a href="index.php"><img src = "../images/home.png" class="icon"/> Home</a><br>
  <a href="chat.php"><img src = "../images/message.png" class="icon"/> Chats</a><br>
  <?php
    if($is_doc_status == 1)
    {
      echo '<a href="blog.php"><a href="blog.php"><img src = "../images/blog.png" class="icon"/> Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php"><a href="addictions.php"><img src = "../images/person.png" class="icon"/> Find Counselor</a><br>';
    }
  ?>
  <a href="#">Rewards</a><br>
  <a href="#"> <img src = "../images/hospital.png" class="icon"/> Rehabilitation Centers</a><br>
  <a href="settings.php"> <img src = "../images/setting.png" class="icon"/> Settings</a><br>
  <a href="?logout"> <img src = "../images/logout.png" class="icon"/> Logout </a><br>
</div>

<div class="main">

  <form id="form" name="form" method="post" action="save_setting.php">

  <center>
  <div id="maindiv">
<?php
  $getArray = getUserDetails($email, $conn);
  $HadAddictions = getAddictionsOfUser($email, $conn);
  $Addictions = getAddictions($conn);
  $leftAddictions = array_diff($Addictions, $HadAddictions); 
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

   <!-- This part shows the addictions -->
  <form id="form" name="form" method="post" action="update_addi.php">
  <section> 
  <div class="quizimgblock">
    <div class="container">
      <h3>Update your Addictions</h3>
      <div class="row wrapper">
        
        <?php
            $addictionArray = getAddictions($conn);
            
            $i=0;
            for ($i;$i<count($addictionArray);$i++)
            {
              $image_name = strtolower($addictionArray[$i]);

              if (in_array($addictionArray[$i], $leftAddictions))
              {
              echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                        <a href="" class="quiz-answer multiple-answers" data-question="1" data-answer="1">
                          <img class="quizitems" src="../images/'. $image_name. '.jpg" width="200" height="150">
                        </a>
                        <center><input  type="checkbox" name='. $image_name . ' value='. $image_name .' , id="doc">'. $image_name .'<br></center> <br>
                        
                      </div>';
              }
              else
              {
                echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                        <a href="" class="quiz-answer multiple-answers" data-question="1" data-answer="1">
                          
                          <img class="quizitems" src="../images/'. $image_name. '.jpg" width="200" height="150">
                        </a>
                        <center><input checked type="checkbox" name='. $image_name . ' value='. $image_name .' , id="doc">'. $image_name .'<br></center> <br>
                        
                      </div>';
              }
            }
        ?>

      </div>
    </div>
  </div>
</section>

<div class = "eleregis">
      <center><input type="submit" value="Submit" id="submit_setting" "></center>
</div>
</form>
 <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
    <!-- <script  src="../js/setting.js"></script> -->
  </div>
  

     
</body>
</html>


