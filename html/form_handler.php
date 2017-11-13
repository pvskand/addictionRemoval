<?php
   require '../OAuth/google_auth.php';
   include("../config/connect.php");
   include("../html/api.php");
   




    //$data=$_POST['left'];
    //$decoded_data=json_decode($data);
    //echo($data);
    $msg=$_POST['articleContent'];
    $title=$_POST['title'];
    $time =date("Y-m-d").date("h:i:sa");

    //echo $email;

    add_blog($conn,$msg,$title,$time,$email);

    header("Location:http://localhost/addictionRemoval/html/index.php");

    ?>