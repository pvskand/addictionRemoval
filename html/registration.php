<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Registration</title>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-animate.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-route.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-aria.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-messages.min.js'></script>
	<script src='https://cdn.gitcdn.xyz/cdn/angular/bower-material/v1.0.0-rc3/angular-material.js'></script>
	<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/assets-cache.js'></script>
	<link rel="stylesheet" href="../css/style.css">
</head>






<body>


<?php
    require '../OAuth/google_auth.php';
    include("../config/connect.php");
    include("api.php");

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




  <div ng-controller="DemoCtrl" ng-cloak="" class="md-inline-form" ng-app="MyApp" layout="column" layout-sm="row" layout-align="center center" layout-align-sm="start start" layout-fill>

		<md-content id="SignupContent" class="md-whiteframe-10dp" flex-sm>
				<md-toolbar flex id="materialToolbar">
						<div class="md-toolbar-tools"> <span flex=""></span> <span class="md-headline" align="center">Registration Form</span> <span flex=""></span> </div>
				</md-toolbar>
				<div layout-padding="">
						<div></div>

						<form id="form" name="form" method="post" action="reg_form.php">
								<input type="hidden" name="action" value="signup" />


								<div layout="row" layout-sm="column">
										<md-input-container flex-gt-sm="">
												<label>First name</label>
												<input ng-model="user.first_name" id ="first-name" name="FirstName" required type="text" ng-pattern="/^[a-zA-Z'. -]+$/" placeholder="Walter">
												<div ng-if="userForm.first_name.$dirty" ng-messages="userForm.first_name.$error" role="alert">
														<div ng-message="required" class="my-message">First Name is Required.</div>
														<div ng-message="pattern" class="my-message">Enter correct First Name.</div>
												</div>
										</md-input-container>
										<md-input-container flex-gt-sm="">
												<label>Last Name</label>
												<input ng-model="user.last_name"  id ="last-name" name="LastName" required type="text" ng-pattern="/^[a-zA-Z'. -]+$/" placeholder="White">
												<div ng-if="userForm.last_name.$dirty" ng-messages="userForm.last_name.$error" role="alert">
														<div ng-message="required" class="my-message">Last Name is Required.</div>
														<div ng-message="pattern" class="my-message">Enter correct Last Name.</div>
												</div>
										</md-input-container>
								</div>
								

								<div layout="row" layout-sm="column">
										<md-input-container flex-gt-sm="">
												<label>Phone</label>
												<input type="tel" id="PhoneNumber"  name="PhoneNumber" placeholder="+919999999999">
													
										</md-input-container>
								</div>

								<div layout="row" layout-sm="column">
										<md-input-container flex-gt-sm="">
												<label>City</label>
												<input type="text" name="city" id="city"  placeholder="New York">
													
										</md-input-container>
								</div>

								<div layout="row" layout-sm="column">
										<md-input-container flex-gt-sm="">
												<label>Birthdate</label>
												<input placeholder="2001-01-01" class="form-control" type="text" onfocus="(this.type='')" onblur="(this.type='2001-01-01')" name="DateofBirth" id="DOB">
													
										</md-input-container>
								</div>

								<center>
								<div >
									<input type="checkbox"  name="doctor" value="Doctor", id="doc">I am a doctor						
									
								</div>
								
						

								<input type="submit" id="submitButton" value="Submit" onclick="submitForm()">
								</center>

						</form>
				</div>
		</md-content>
</div>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-animate.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-route.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-aria.min.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-messages.min.js'></script>
	<script src='https://cdn.gitcdn.xyz/cdn/angular/bower-material/v1.0.0-rc3/angular-material.js'></script>
	<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/assets-cache.js'></script>
	<script  src="../js/index.js"></script>




</body>
</html>