<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	 <link rel="stylesheet" type="text/css" href="../css/homepage.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
   <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">

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


  <center>
  <div id="maindiv">
<?php
  $getArray = getUserDetails($email, $conn);
  $HadAddictions = getAddictionsOfUser($email, $conn);
  $Addictions = getAddictions($conn);
  $leftAddictions = array_diff($Addictions, $HadAddictions); 
?>

    

   <!-- This part shows the addictions -->
  <form id="form" name="form" method="post" action="update_addi.php">
  <section> 
  <div class="quizimgblock">
    <div class="container">
      <h2 id="headingPage">Update your Addictions</h2><br>
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
                        <a href="#" class="quiz-answer multiple-answers" data-question="1" data-answer="1">
                          <img class="quizitems" src="../images/'. $image_name. '.jpg" width="200" height="150">
                        </a>
                        <center><input  class ="inputForm" type="checkbox" name='. $image_name . '><font face="verdana" size="6px" color="red">'. $image_name .'</font><br></center> <br>
                        
                      </div>';
              }
              else
              {
                echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                        <a href="#" class="quiz-answer multiple-answers" data-question="1" data-answer="1">
                          
                          <img class="quizitems" src="../images/'. $image_name. '.jpg" width="200" height="150">
                        </a>
                        <center><input checked type="checkbox"  class ="inputForm" name='. $image_name . '><font face="verdana" size="6px" color="green">'. $image_name .'</font><br></center> <br>
                        
                      </div>';
              }
            }
        ?>

      </div>
    </div>
  </div>
</section>

<div class = "eleregis">
      <center><input type="submit" class="waves-effect waves-light btn" value="Submit" id="submit_setting"></center>
</div>
</form>
 <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
    <!-- <script  src="../js/setting.js"></script> -->
  </div>
  

     
</body>
</html>


