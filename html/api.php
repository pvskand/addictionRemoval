<?php 
include("../config/connect.php");


// Get the doctor's name for writing in the feed from the Membe table

	function getDocName($email, $conn) 
	{
		$doc = "SELECT * FROM Member WHERE email='$email' LIMIT 1";

		
		$docResult = $conn->query($doc);

		$doc_name = "";
		while($row = mysqli_fetch_assoc($docResult)) 
		{
			$doc_name = $row["firstname"];
		}
		return $doc_name;

	}

	function userInDB($email, $conn)
	{
		$user = "SELECT * FROM Member WHERE email='$email'";

		$userResult = $conn->query($user);
		if ($userResult->num_rows > 0) 
		{
			return 1;
		}
		return 0;
		
	}
	function addUser($email, $firstname, $lastname, $phonenumber, $dob, $city, $isDoc, $conn)
	{
		// $dateToday
		$date = date('Y-m-d');
		$add = "INSERT INTO Member (`firstname`, `lastname`, `email`, `rating`, `accountCreatedOn`, `phoneNumber`, `city`, `dob`, `isBanned`, `isDoc`) VALUES ('$firstname', '$lastname', '$email', '0', '$date', '$phonenumber', '$city', '$dob', '0', '$isDoc');";
		$stmt = $conn->prepare($add);
		$stmt->execute();


	}
	function getAddictions($conn)
	{
		$addictions = "SELECT addictionName FROM Addictions;";

		$addictionsResult = $conn->query($addictions);
		$addictionArray = array();


		if ($addictionsResult->num_rows > 0) 
		{
			while($row = mysqli_fetch_assoc($addictionsResult)) 
			{
				$addiction = $row["addictionName"];
				// echo $addiction;
				array_push($addictionArray, "$addiction");
			} 
		}
		// echo $addictionArray[1];
		return $addictionArray;

	}



















?>