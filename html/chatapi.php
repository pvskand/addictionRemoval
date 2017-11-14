<?php 

include("../config/connect.php");
include("./api.php");
require '../OAuth/google_auth.php';

date_default_timezone_set("Asia/Kolkata");
	
 $msg= $_GET["msg"]; 
 $receiverId= $_GET["receiverId"];
 $isDoctor=isDoctor($email,$conn);


$caseId=getCaseId($email,$receiverId,$isDoctor,$conn);

$result=addchat($msg,$caseId,$isDoctor,date("Y-m-d H-i-s"),$conn);

?>


