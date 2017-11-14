<?php
   require '../OAuth/google_auth.php';
   include("../config/connect.php");
   include("../html/api.php");
   
    $msg=$_POST['articleContent'];
    $title=$_POST['title'];
    $time =date("Y-m-d").' '.date("h:i:s");
    add_blog($conn,$msg,$title,$time,$email);

    header("Location:http://localhost/addictionRemoval/html/index.php");

    ?>