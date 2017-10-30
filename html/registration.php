<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="../css/register.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-animate.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-route.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-aria.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-messages.min.js'></script>
	<script src='https://cdn.gitcdn.xyz/cdn/angular/bower-material/v1.0.0-rc3/angular-material.js'></script>
	<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/assets-cache.js'></script>

</head>
<body>
	<form id="form" name="form" method="post" action="reg_form.php">

	<center>
	<div id="maindiv">
		<center>
			<h1> Registration </h1>
		</center>

		<div class = "eleregis" id="firstlastname">
			<div class="names"> 
				<label for="FirstName">First name</label><br>
				<input type="text" name="FirstName" id="first-name">
	        </div>
	        <div class = "names">
	            <label for="LastName">Second name</label><br>
	        	<input type="text" name="LastName" id="last-name">
			</div>
		</div>
		<br>


	    <div class = "eleregis">
			<label for="PhoneNumber">Contact number</label><br>
			<input type="phonenumber" name="PhoneNumber" id="PhoneNumber">
	    </div>
	    <br>

	    <div class = "eleregis">
			<label for="DOB">Date of Birth</label><br>
			<input type="date" name="DateofBirth" id="DOB">
	    </div>
	    <br>

	    <div class = "eleregis">    
			<label for="city">City</label><br>
			<input type="text" name="city" id="city">
	    </div>
	    <br>
	    <center><input type="checkbox" name="doctor" value="Doctor", id="doc">I am a Doctor<br></center> <br>
	    <div class = "eleregis">
			<input type="submit" value="Submit" onclick="submitForm()">
			<input type="reset" value="Reset">
	    </div>
	    <br>

    </div>
    </center>
	</form>

<?php
    require '../OAuth/google_auth.php';
    include("../config/connect.php");
    include("./api.php");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    

    if ($email==null)
    {
	    exit; 
    }
    else if (userInDB($email, $conn) == 1)
    {
    	header("Location:http://localhost/addictionRemoval/html/index.php");

    }
    else
    {
    	// create a new user
    }


    ?>
<style type="text/css">
  
h2{
  position: absolute;
  left: 350px;
    top: 0px;
}

</style>
</body>
</html>

 