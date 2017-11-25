<?php 
include("../config/connect.php");
	function isDoc($email, $conn)
	{
		$doc = "SELECT isDoc FROM member WHERE email='$email' LIMIT 1";
		$docResult = $conn->query($doc);
		$doc_status = "";
		while($row = mysqli_fetch_assoc($docResult)) 
		{
			$doc_status = $row["isDoc"];
		}
		return $doc_status;
	}
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
	function updateAddictions($email, $addictionArray, $conn)
	{
		$i = 0;
			
		$check = "DELETE FROM `addictionRemoval`.`member_had_addictions` WHERE `member_email`='$email';";
		$addictionsResult = $conn->query($check);
			
		for($i;$i<sizeof($addictionArray);$i++)
		{	
			$add = "INSERT INTO `addictionRemoval`.`member_had_addictions` (`member_email`, `addictions_addictionName`) VALUES ('$email', '$addictionArray[$i]');";
			$stmt = $conn->prepare($add);
			$stmt->execute();
		}
	}

	function addUser($email, $firstname, $lastname, $phonenumber, $dob, $city, $isDoc, $conn)
	{
		// $dateToday
		$date = date('Y-m-d');
		$add = "INSERT INTO member (`firstname`, `lastname`, `email`, `rating`, `accountCreatedOn`, `phoneNumber`, `city`, `dob`, `isBanned`, `isDoc`) VALUES ('$firstname', '$lastname', '$email', '1000', '$date', '$phonenumber', '$city', '$dob', '0', '$isDoc');";
		echo $add;
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

	// get the addictions that the user had removed
	function getAddictionsOfUser($email, $conn)
	{
		$addictions = "SELECT addictions_addictionName FROM member_had_addictions WHERE member_email='$email';";
		$addictionsResult = $conn->query($addictions);
		$addictionArray = array();
		if ($addictionsResult->num_rows > 0) 
		{
			while($row = mysqli_fetch_assoc($addictionsResult)) 
			{
				$addiction = $row["addictions_addictionName"];
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
	function add_blog($conn,$msg,$title,$time,$email)
	{
		$add_blog="INSERT INTO blog (`message`, `title`, `timestamp`, `doctor_member_email`) VALUES ('$msg', '$title', '$time', '$email');";
		echo $add_blog;
		$stmt = $conn->prepare($add_blog);
		if($stmt==true)
		{
			$stmt->execute();
		}
		else
		{
			echo "Error occured";
		}
	}


	// subhashish - chat
	function addChat($message,$caseId,$sentByCounsellor,$timestamp,$conn){

		$add = "INSERT INTO chats(`message`,`sentByCounsellor`,`timestamp`,`case_caseid`)
		values('$message','$sentByCounsellor','$timestamp','$caseId');";

		$stmt = $conn->prepare($add);
		$result=$stmt->execute();
		

	}

	function isDoctor($id,$conn){

		$stmt = "SELECT isDoc FROM member WHERE email='$id'";

		$userResult = $conn->query($stmt);
		$row = $userResult->fetch_assoc();
		return $row["isDoc"];


	}

	function getCaseId($senderId,$receiverId,$isDoctor,$conn){
		if($isDoctor==1){
			$stmt = "SELECT caseid FROM `case` WHERE counsellor_email='$senderId' AND patient_email='$receiverId' AND isCompleted=0 ";
		}
		else{
			$stmt = "SELECT caseid FROM `case` WHERE counsellor_email='$receiverId' AND patient_email='$senderId' AND isCompleted=0 ";
		}

		$userResult = $conn->query($stmt);
		$row = $userResult->fetch_assoc();
		return $row["caseid"];


	}



function getCurrentMaxChatId($caseId,$conn){
		$stmt = "SELECT max(chatid) as `max` FROM chats WHERE case_caseid='$caseId'";
		

		$userResult = $conn->query($stmt);
		$row = $userResult->fetch_assoc();
		return $row["max"];


	}




function getChats($caseId,$latestId,$current_max,$isDoctor,$conn){

	$stmt = "SELECT message, sentByCounsellor FROM chats WHERE case_caseid='$caseId' and chatid>'$latestId' order by `timestamp` ";
	

	$userResult = $conn->query($stmt);
	// $row = $userResult->fetch_assoc();
	// return $row["max"];
	$myArray=array();

  	while($row = $userResult->fetch_assoc()) {
        $myArray[] = $row;
	}
	array_push($myArray,$current_max,$isDoctor);
	return json_encode($myArray);


	}
function report($conn,$type,$description,$reporter,$toBeReportedUser){
	$query = "INSERT INTO report(`type`,`email`,`member_email`,`description`) VALUES ('$type','$reporter','$toBeReportedUser','$description');";
	$stmt = $conn->prepare($query);
	$result=$stmt->execute();

	$query = "SELECT rating FROM member WHERE email='$toBeReportedUser'";
	$queryResult = $conn->query($query);
	$row = $queryResult->fetch_assoc();
	$reportedUserCurrentRating = $row["rating"];

	$q="SELECT count(member_email) FROM `report` WHERE `report`.member_email= '$toBeReportedUser'";
	$result=$conn->query($q);
	$row = mysqli_fetch_assoc($result);
	$currentNumberOfReports = $rot["count(member_email)"];

	if(currentNumberOfReports>3){
		$reportedUserCurrentRating = $reportedUserCurrentRating - 200 - 25;		//report and ban
		$date = date('Y-m-d');	
		$stmt = "UPDATE member SET  isBanned = 1, accountBannedOn = '$date' WHERE email='$toBeReportedUser'";
		$getUpdate = $conn->query($stmt);
	} 
	else {
		$reportedUserCurrentRating = $reportedUserCurrentRating - 25;		//just report
	}

	$stmt = "UPDATE member SET  rating = $reportedUserCurrentRating WHERE email='$toBeReportedUser'";
	$getUpdate = $conn->query($stmt);
}

function updateRating($conn,$numStars,$patient_email,$counsellor_email,$add_type){
	
	$query = "SELECT rating FROM member WHERE email='$counsellor_email'";
	$queryResult = $conn->query($query);
	$row = $queryResult->fetch_assoc();
	$counsellorCurrentRating = $row["rating"];

	if($numStars==5){
		$counsellorCurrentRating = $counsellorCurrentRating + 200;
		$stmt = "UPDATE member SET  rating = $counsellorCurrentRating WHERE email='$counsellor_email'";
	}
	else if($numStars==4){
		$counsellorCurrentRating = $counsellorCurrentRating + 150;
		$stmt = "UPDATE member SET  rating = $counsellorCurrentRating WHERE email='$counsellor_email'";
	}
	else if($numStars==3){
		$counsellorCurrentRating = $counsellorCurrentRating + 100;
		$stmt = "UPDATE member SET  rating = $counsellorCurrentRating WHERE email='$counsellor_email'";
	}
	else if($numStars==2){
		$counsellorCurrentRating = $counsellorCurrentRating + 50;
		$stmt = "UPDATE member SET  rating = $counsellorCurrentRating WHERE email='$counsellor_email'";
	}
	else if($numStars==1){
		$counsellorCurrentRating = $counsellorCurrentRating + 20;
		$stmt = "UPDATE member SET  rating = $counsellorCurrentRating WHERE email='$counsellor_email'";
	}
	$getUpdate = $conn->query($stmt);

	$stmt = "UPDATE `case` SET isCompleted=1 WHERE counsellor_email='$counsellor_email' AND patient_email='$patient_email' AND addictions_addictionName='$add_type' AND isCompleted=0 ";
	$getUpdate = $conn->query($stmt);

	$query = "SELECT currentCasesBeingHandled FROM member WHERE email='$counsellor_email'";
	$queryResult = $conn->query($query);
	$row = $queryResult->fetch_assoc();
	$currentCasesSolved = $row["currentCasesBeingHandled"];
	$currentCasesSolved = $currentCasesSolved + 1;

	if($currentCasesSolved>10){
		$stmt = "UPDATE member SET  currentCasesBeingHandled = 0 WHERE email='$counsellor_email'";
		$getUpdate = $conn->query($stmt);

		$stmt = "DELETE FROM report WHERE member_email = '$counsellor_email'";
		$addictionsResult = $conn->query($stmt);
	}
	else {
		$stmt = "UPDATE member SET  currentCasesBeingHandled = 0 WHERE email='$counsellor_email'";
		$getUpdate = $conn->query($stmt);		
	}

}



?>