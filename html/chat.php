<?php 

include("../config/connect.php");
include("./api.php");
require '../OAuth/google_auth.php';
$is_doc_status = isDoc($email, $conn);

if($email == null){
      header("Location:http://localhost/addictionRemoval/OAuth/google_auth.php");
    }

    $sudo=getPseudonym($email,$conn);
$rating=getRating($email,$conn);
$comname = $name." (".$sudo.")";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Chats</title>
	<link rel="stylesheet" href="../css/homepage.css" />
	<script src="../js/homepage.js"></script>


    <link rel="stylesheet" href="jquery-ui.css" type="text/css" media="screen" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
    <script type="text/javascript" src="jquery-ui.min.js"></script>
    <link type="text/css" href="jquery.ui.chatbox.css" rel="stylesheet" />
    <script type="text/javascript" src="jquery.ui.chatbox.js"></script>
    
        <script type="text/javascript">
      $(document).ready(function(){
          var i=10;
          var box=[];
          var latestChatId=[];
          var receiverId=[];
          var isPatient=[];
          var pseudo=[];
          
          for(i=0;i<10;i++){
            box[i] = null;
            latestChatId[i] = 0;
            receiverId[i] = null;
          }
          // alert('asdf');
          var senderId="<?php echo $email; ?>";

          $("input[type='button']").click(function(event, ui) {
             var index=$(this).attr("count")-1;

              receiverId[index]= $(this).attr("name");
              isPatient[index]=$(this).attr("isPatient");
              pseudo[index]= $(this).val();
              // console.log(box[index]);
                 if(box[index]) {

                  box[index].chatbox("option", "boxManager").toggleBox();
              }
              else {
                  getContent(index);
                  box[index] = $("#chat_div"+index).chatbox({id:"me", 
                                                user:{key : "value"},
                                                title : pseudo[index],
                                                messageSent : function(id, user, msg) {
                                                    // $("#log").append("me"+" : "+ msg + "<br/>");
                                                    // $("#chat_div").chatbox("option", "boxManager").addMsg("me", msg);
                                                    // alert(receiverId[index]);
                                                    // alert(receiverId+" "+msg+" "+senderId+" "+index);
                                                    $(this).myFunction(id,msg,index);
                                                }});
              }
          });

           $.fn.myFunction = function(id,msg,index) { 
          // alert(id+msg); 

               $.ajax({   
               // type: "POST",                                   
      url: 'chatapi.php',                  //the script to call to get data          
      data: "msg="+msg+"&receiverId="+receiverId[index]+"&isPatient="+isPatient[index],                        //you can insert url argumnets here to pass to api.php
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


         function getContent(index)
{
    var queryString = {'latestId' : latestChatId[index],'receiverId' : receiverId[index],'senderId' : senderId, 'isPatient' : isPatient[index]};

    $.ajax(
        {
            type: 'GET',
            url: 'chatreceive.php',
            data: queryString,
            success: function(data){
                // put result data into "obj"
                // alert(data);
                var obj = jQuery.parseJSON(data);

                // put the data_from_file into #response
                // $('#response').html(obj.data_from_file);
                // if(data.val()!='')
                // alert(obj.length);
                // call the function again, this time with the timestamp we just got from server.php

                 var i;
                 var couns=obj[obj.length-1];
                 for(i=0;i<obj.length-2;i++){
                  if(couns!=obj[i].sentByCounsellor)
                     $("#chat_div"+index).chatbox("option", "boxManager").addMsg("me", obj[i].message);
                   else
                    $("#chat_div"+index).chatbox("option", "boxManager").addMsg(pseudo[index], obj[i].message);
                 } 
                 
                // getContent(obj[obj.length-2],isPatient);
                latestChatId[index]=obj[obj.length-2];
                getContent(index);
            }
        }
    );
}




      });
//here

//here
   
    </script>
<link rel="stylesheet" type="text/css" href="../css/rating.css">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css'>

</head>
<body>



<div id="mySidenav" class="sidenav">
  <div id="profileDiv"> 
    <img src="../images/profile.png" id="profilePhoto" />
  </div>
  <center><h3 id='personName'> <?php echo($comname); ?></h3></center>
  <center><h3 id='personName'> Rating: <?php echo($rating); ?></h3></center>
  <div id="seperate"> </div>
  <a href="index.php"><img src = "../images/home.png" class="icon"/> Home</a><br>
  <a href="chat.php"><img src = "../images/message.png" class="icon"/> Chats</a><br>
  <?php
    if($is_doc_status == 1)
    {
      echo '<a href="blog.php"> <img src = "../images/blog.png" class="icon"/> Write Blog</a><br>';
    }
    else
    {
      echo '<a href="addictions.php"><img src = "../images/person.png" class="icon"/> Find Counselor</a><br>';
    }
  ?>
  <a href="rehab.php"> <img src = "../images/hospital.png" class="icon"/> Rehabilitation Centers</a><br>
  <a href="setting.php"><img src = "../images/setting.png" class="icon"/>  Settings</a><br>
  <a href="?logout"><img src = "../images/logout.png" class="icon"/> Logout </a><br>
</div>

<div class="main">

<?php 



// showing the feed with blogs written by different doctors.
$counsellorQuery= "SELECT counsellor_email, addictions_addictionName FROM `case` where patient_email='$email' AND isCompleted=0";
$patientQuery = "SELECT patient_email, addictions_addictionName FROM `case` where counsellor_email='$email' AND isCompleted=0";


$patientResult = $conn->query($patientQuery);
$counsellorResult = $conn->query($counsellorQuery);
$count = 1;
echo '<center><h3 id="headingTable"> Addicts </h3> </center><br>';

if ($patientResult->num_rows > 0) 
{
	// output data of each row

    echo '<table style="width:100%" class="highlight">';
    while($row = $patientResult->fetch_assoc()) 
    {
        
        $email = $row["patient_email"];
        $addiction = $row["addictions_addictionName"];
        $pseudo=getPseudonym($email,$conn);
        echo '<tr>';
        echo "<td><input class='waves-effect waves-light btn' type='button' name='$email' count='$count' isPatient=0 value='$pseudo' /></td>";
        echo "<td><a class='waves-effect waves-light btn modal-trigger' href='#modal".$count."'>Report</a></td>";
        echo '
             <div id="modal'.$count.'" class="modal">
              <div class="modal-content">
                <h4 id ="headingPage">Report</h4>
                  <form  action="./report.php">
                    <input type="hidden" name="councellor" value="'.$email.' '.$addiction.'" readonly><br>
                    Description: <input type="text" name="desc" value=""><br>
                    <center><input type="submit" value="Submit"></center>
                </form>
                    
                  
                  
                     
              </div>

            </div>';
        echo "<td><h5>$addiction</h5></td>";
        $count++;
        
        
    }
    echo '</table>';
}
echo '<center><h3 id="headingTable"> Your mentors </h3> </center><br>';
if ($counsellorResult->num_rows > 0) 
{
  // output data of each row
  
  echo '<table style="width:100%" class="highlight">';
    while($row = $counsellorResult->fetch_assoc()) 
    {


        
        $email = $row["counsellor_email"];
        $addiction = $row["addictions_addictionName"];
        $pseudo=getPseudonym($email,$conn);


           
        echo '<tr>';
        echo "<td><input class='waves-effect waves-light btn' count='$count' isPatient=1 type='button' name='$email' value='$pseudo' /></td>";
        echo "<td><a class='waves-effect waves-light btn modal-trigger' href='#modal".$count."'>Close Cases</a></td>";
        echo '
            <div id="modal'.$count.'" class="modal">
              <div class="modal-content">
                <h4 id ="headingPage">Ratings</h4>
                  <form class="rating" action="./rating.php">
                    <legend>Please rate:</legend>
                     <div class="rating-stars col s12">
                        <input type="radio" name="stars" id="star-null">
                        <input type="radio" name="stars" value="1 '.$email.' '.$addiction.'" id="star-1" saving="1" data-start="1" checked="">
                        <input type="radio" name="stars" value="2 '.$email.' '.$addiction.'"  id="star-2" saving="2" data-start="2" checked="">
                        <input type="radio" name="stars" value="3 '.$email.' '.$addiction.'"  id="star-3" saving="3" data-start="3" checked="">
                        <input type="radio" name="stars" value="4 '.$email.' '.$addiction.'"  id="star-4" saving="4" data-start="4" checked="">
                        <input type="radio" name="stars" value="5 '.$email.' '.$addiction.'"  id="star-5" saving="5" checked="">
                        <section>
                          <label for="star-1">
                              <svg width="255" height="240" viewBox="0 0 51 48">
                                  <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"></path>
                              </svg>
                          </label>
                          <label for="star-2">
                              <svg width="255" height="240" viewBox="0 0 51 48">
                                  <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"></path>
                              </svg>
                          </label>
                          <label for="star-3">
                              <svg width="255" height="240" viewBox="0 0 51 48">
                                  <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"></path>
                              </svg>
                          </label>
                          <label for="star-4">
                              <svg width="255" height="240" viewBox="0 0 51 48">
                                  <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"></path>
                              </svg>
                          </label>
                          <label for="star-5">
                              <svg width="255" height="240" viewBox="0 0 51 48">
                                  <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"></path>
                              </svg>
                          </label>
                        </section>
                      </div>
                     
                    </div>
                    <center> <input type="submit" value="Submit"> </center>
                </form>
              </div>

            </div>';
            $count = $count + 1;

            echo "<td><a class='waves-effect waves-light btn modal-trigger' href='#modal".$count."'>Report</a></td>";
        echo '
             <div id="modal'.$count.'" class="modal">
              <div class="modal-content">
                <h4 id ="headingPage">Report</h4>
                  <form  action="./report.php">
                    <input type="hidden" name="councellor" value="'.$email.' '.$addiction.'" readonly><br>
                    Description: <input type="text" name="desc" value=""><br>
                    <center><input type="submit" value="Submit"></center>
                </form>
                    
                  
                  
                     
              </div>

            </div>';

        echo "<td><h5>$addiction</h5></td>";
        
              
            $count++;
        
        
    }
    echo '</table>';
} 


for ($i=0;$i<$count-1;$i++)
{
  echo"<div id='chat_div$i'>
    </div>";
}

?>

     
  <!--    <input type="button"
    name="toggle" value="toggle" /> -->

    
    
    <div id="log">
    </div>

</div> 



  <!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js'></script>

<script  src="sample.js"></script>

</body>
</html>

