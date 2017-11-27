
<?php 

include("../config/connect.php");
include("../html/api.php");
require '../OAuth/google_auth.php';

date_default_timezone_set("Asia/Kolkata");
	
 $msg= $_GET["msg"]; 
 $receiverId= $_GET["receiverId"];
 $isPatient=$_GET["isPatient"];
 // $isDoctor=isDoctor($email,$conn);


$caseId=getCaseId($email,$receiverId,$isPatient,$conn);

$result=addchat($msg,$caseId,$isPatient,date("Y-m-d H-i-s"),$conn);

// echo $result;

?>



