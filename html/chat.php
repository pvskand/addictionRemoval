<?php 

include("../config/connect.php");
include("./api.php");
require '../OAuth/google_auth.php';
$is_doc_status = isDoc($email, $conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>HomePage</title>
	<link rel="stylesheet" href="../css/homepage.css" />
	<script src="../js/homepage.js"></script>


    <link rel="stylesheet" href="jquery-ui.css" type="text/css" media="screen" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
    <script type="text/javascript" src="jquery-ui.min.js"></script>
    <link type="text/css" href="jquery.ui.chatbox.css" rel="stylesheet" />
    <script type="text/javascript" src="jquery.ui.chatbox.js"></script>
    
        <script type="text/javascript">
      $(document).ready(function(){
          var box = null;
          var latestChatId = 0;
           
          var receiverId = null;
          var senderId="<?php echo $email; ?>";

          $("input[type='button']").click(function(event, ui) {
              receiverId= $(this).val();
              getContent(latestChatId);
              if(box) {
                  box.chatbox("option", "boxManager").toggleBox();
              }
              else {
                  box = $("#chat_div").chatbox({id:"me", 
                                                user:{key : "value"},
                                                title : "my chat",
                                                messageSent : function(id, user, msg) {
                                                    // $("#log").append("me"+" : "+ msg + "<br/>");
                                                    // $("#chat_div").chatbox("option", "boxManager").addMsg("me", msg);

                                                    $(this).myFunction(id,msg);
                                                }});
              }
          });

           $.fn.myFunction = function(id,msg) { 
          // alert(id+msg); 

               $.ajax({   
               // type: "POST",                                   
      url: 'chatapi.php',                  //the script to call to get data          
      data: "msg="+msg+"&receiverId="+receiverId,                        //you can insert url argumnets here to pass to api.php
                                       //for example "id=5&parent=6"
                      //data format      
      success: function(data)          //on recieve of reply
      {
      // alert(data);
       // $("#chat_div").chatbox("option", "boxManager").addMsg("2014CSB1036", data);
      } 
    });


          }
//           // initialize jQuery
// $(function(lol) {
    
//     // alert(lol);

// });


          function getContent(latestId)
{
    var queryString = {'latestId' : latestId,'receiverId' : receiverId,'senderId' : senderId};

    $.ajax(
        {
            type: 'GET',
            url: 'chatreceive.php',
            data: queryString,
            success: function(data){
                // put result data into "obj"
                var obj = jQuery.parseJSON(data);
                // put the data_from_file into #response
                // $('#response').html(obj.data_from_file);
                // if(data.val()!='')
                // alert(obj.length);
                // call the function again, this time with the timestamp we just got from server.php

                 var i;
                 var couns=obj[obj.length-1];
                 for(i=0;i<obj.length-2;i++){
                  if(couns==obj[i].sentByCounsellor)
                     $("#chat_div").chatbox("option", "boxManager").addMsg(senderId, obj[i].message);
                   else
                    $("#chat_div").chatbox("option", "boxManager").addMsg(receiverId, obj[i].message);
                 } 

                getContent(obj[obj.length-2]);
            }
        }
    );
}




      });
//here

//here
   
    </script>
</head>
<body>



<div id="mySidenav" class="sidenav">
  <div id="profileDiv"> 
    <img src="../images/profile.png" id="profilePhoto" />
  </div>
  <div id="seperate"> </div>
  <a href="index.php">Home</a><br>
  <a href="chat.php">Chats</a><br>
  <?php
    if($is_doc_status == 1)
    {
      echo '<a href="blog.php">Write Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php">Find Counselor</a><br>';
    }
  ?>
  <a href="#">Rewards</a><br>
  <a href="#">Rehabilitation Centers</a><br>
  <a href="settings.php">Settings</a><br>
  <a href="?logout"> Logout </a><br>
</div>

<div class="main">
  <center><h1>My chat page</h1></center>
  <p>Your Opened cases. Click to chat!</p>

<?php 



// showing the feed with blogs written by different doctors.
$counsellorQuery= "SELECT counsellor_email FROM `case` where patient_email='$email'";
$patientQuery = "SELECT patient_email FROM `case` where counsellor_email='$email'";

$patientResult = $conn->query($patientQuery);
$counsellorResult = $conn->query($counsellorQuery);

if ($patientResult->num_rows > 0) 
{
	// output data of each row
    while($row = $patientResult->fetch_assoc()) 
    {
        
        $email = $row["patient_email"];
        // echo $email;
        // echo "<br>";

        echo "<input type='button' name='toggle' value='$email' />";
        
        
    }
}
if ($counsellorResult->num_rows > 0) 
{
  // output data of each row
    while($row = $counsellorResult->fetch_assoc()) 
    {
        
        $email = $row["counsellor_email"];
        // echo $email;
        // echo "<br>";
        echo "<input type='button' name='toggle' value='$email' />";
        
        
    }
} 
// else
// {
// 	echo "No blogs found. ";
// }

?>

     
  <!--    <input type="button"
    name="toggle" value="toggle" /> -->

    <div id="chat_div">
    </div>
    <hr />
    <div id="log">
    </div>

</div> 
</body>
</html>

