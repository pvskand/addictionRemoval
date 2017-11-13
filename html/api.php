<?php 
include("../config/connect.php");


// Get the doctor's name for writing in the feed from the Membe table

	function getDocName($email, $conn) 
	{
		$doc = "SELECT * FROM member WHERE email='$email' LIMIT 1";

		
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
		$user = "SELECT * FROM member WHERE email='$email'";

		$userResult = $conn->query($user);
		if ($userResult->num_rows > 0) 
		{
			return 1;
		}
		return 0;
		
	}
	// get user details to display in setting.php
	function getUserDetails($email, $conn)
	{
		$get = "SELECT firstname, lastname, rating, phoneNumber, city, dob FROM member WHERE email='$email';";
		$getResult = $conn->query($get);
		$getArray = array();
		if ($getResult->num_rows > 0) 
		{
			while($row = mysqli_fetch_assoc($getResult)) 
			{
				$firstname = $row["firstname"];
				array_push($getArray, "$firstname");
				$lastname = $row["lastname"];
				array_push($getArray, "$lastname");
				$rating = $row["rating"];
				array_push($getArray, "$rating");
				$phoneNumber = $row["phoneNumber"];
				array_push($getArray, "$phoneNumber");
				$city = $row["city"];
				array_push($getArray, "$city");
				$dob = $row["dob"];
				array_push($getArray, "$dob");
				
			} 
		}
		return $getArray;

	}
	// Update user
	function updateUser($email, $firstname, $lastname, $phonenumber, $dob, $city, $conn)
	{
		$update = "UPDATE `addictionRemoval`.`member` SET `firstname`='$firstname', `lastname`='$lastname', `phoneNumber`='$phonenumber', `city`='$city', `dob`='$dob' WHERE `email`='$email';";
		$getUpdate = $conn->query($update);
		if ($getUpdate)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}


	function addUser($email, $firstname, $lastname, $phonenumber, $dob, $city, $isDoc, $conn)
	{
		// $dateToday
		$date = date('Y-m-d');
		$add = "INSERT INTO member (`firstname`, `lastname`, `email`, `rating`, `accountCreatedOn`, `phoneNumber`, `city`, `dob`, `isBanned`, `isDoc`) VALUES ('$firstname', '$lastname', '$email', '1000', '$date', '$phonenumber', '$city', '$dob', '0', '$isDoc');";
		$stmt = $conn->prepare($add);
		$stmt->execute();

		if($isDoc == 1)
		{
			$add = "INSERT INTO `doctor`(`specialization`, `member_email`) VALUES ('dummy','$email')";
			$stmt = $conn->prepare($add);
			$stmt->execute();
		}
		else
		{
			$add = "INSERT INTO `user`(`member_email`) VALUES ('$email')";
			$stmt = $conn->prepare($add);
			$stmt->execute();
		}
	}
	function getAddictions($conn)
	{
		$addictions = "SELECT addictionName FROM addictions;";

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

	function isExistingCase($email,$addiction,$conn)
	{
		$q = "SELECT * from `case` where `case`.isCompleted = 0 and `case`.patient_email = '$email' and `case`.Addictions_addictionName = '$addiction'";
		$result = $conn->query($q);
		
		if ($result->num_rows>0) 
		{
			return 1;
		}
		return 0;
	}


	function Matching_algo($email,$addiction,$conn)
	{
		$q="SELECT member_had_addictions.member_email from member,member_had_addictions where member.isBanned=0 and member_had_addictions.addictions_addictionName='$addiction' and member.email=member_had_addictions.member_email";
		$result=$conn->query($q);

		


		$data = array(); 
		$count=0;
		while($row = mysqli_fetch_assoc($result)) 
		{
			$data[] = $row;
			$count++;

		}

		
		$i=0;
		while($i<$count)
		{
			$name=$data[$i]["member_email"];
			$q="SELECT count(counsellor_email) FROM `case` WHERE `case`.counsellor_email= '$name'";
			$result=$conn->query($q);
			$row = mysqli_fetch_assoc($result);
			$data[$i]["count(counsellor_email)"]=$row["count(counsellor_email)"];
			$q="SELECT rating,isdoc FROM member WHERE member.email='$name'";
			$result = $conn->query($q);
			$row = mysqli_fetch_assoc($result);
			$data[$i]["rating"]=$row["rating"];
			$data[$i]["isdoc"]=$row["isdoc"];
			$i++;
		}


		$i=0;
		$min=10000;
		while($i<$count)
		{
			
			if($min > $data[$i]["count(counsellor_email)"])
			{
				$min=$data[$i]["count(counsellor_email)"];
			}
			
			$i++;
		}

		$i=0;
		$max_doc_rating=-1000; $max_doc_index = -1;
		$max_user_rating=-1000; $max_user_index = -1;
		while($i<$count)
		{
			
			if($min === $data[$i]["count(counsellor_email)"])
			{
				if($data[$i]["isdoc"] == 1 && $max_doc_rating < $data[$i]["rating"])
				{
					$max_doc_rating = $data[$i]["rating"];
					$max_doc_index = $i;
				} 
				else if ($data[$i]["isdoc"] == 0 && $max_user_rating < $data[$i]["rating"])
				{
					$max_user_rating = $data[$i]["rating"];
					$max_user_index = $i;
				}
			}
			
			$i++;
		}
		$i=0;

		if($max_doc_index == -1 && $max_user_index == -1)
		{
			echo 'no user found';
		}
		else if ($max_user_index == -1) 
		{
			return $data[$max_doc_index]["member_email"];
		}
		else if ($max_doc_index == -1) 
		{
			return $data[$max_user_index]["member_email"];
		}
		else
		{
			if($max_doc_rating > $max_user_rating)
			{
				return $data[$max_doc_index]["member_email"];
			}
			else
			{
				if($max_user_rating-$max_doc_rating > 400)
				{
					return $data[$max_user_index]["member_email"];
				}
				else
				{
					return $data[$max_doc_index]["member_email"];
				}
			}
		}
		

	}


	function update_case_table($conn,$counsellor_email,$patient_email,$add_type)
	{
		$date = date('Y-m-d');
		$q="INSERT INTO `case`(`isCompleted`, `counsellor_email`, `patient_email`, `startDate`, `endDate`, `addictions_addictionName`) VALUES (0,'$counsellor_email','$patient_email','$date','2000-01-01','$add_type')";
		$stmt = $conn->prepare($q);
		$stmt->execute();
	}




?>