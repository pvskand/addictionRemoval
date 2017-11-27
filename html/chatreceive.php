<?php
include("../config/connect.php");
include("../html/api.php");

set_time_limit(0);

while (true) {

    if(!isset($_GET['receiverId'])){
        break;
    }

    $latestId = (int)$_GET['latestId'];
    
    $senderId = $_GET['senderId'];
    
    $receiverId = $_GET['receiverId'];

    // $isDoctor=isDoctor($senderId,$conn);
    $isPatient= $_GET['isPatient'];
    
    $caseId=getCaseId($senderId,$receiverId,$isPatient,$conn);
    
    $current_max=getCurrentMaxChatId($caseId,$conn);
    
    // if($current_max==null){
    //     break;
    // }
    
    clearstatcache();

    if ( $current_max!=NULL &&  $current_max > $latestId) {

        $result=getChats($caseId,$latestId,$current_max,$isPatient,$conn);
        // // get content of data.txt
        // $data = file_get_contents($data_source_file);

        // // put data.txt's content and timestamp of last data.txt change into array
        // $result = array(
        //     'data_from_file' => $data,
        //     'timestamp' => $last_change_in_data_file
        // );

        // // encode to JSON, render the result (for AJAX)
        // $json = json_encode($result);
        
        echo $result;

        // leave this loop step
        break;

    } else {
        // wait for 1 sec (not very sexy as this blocks the PHP/Apache process, but that's how it goes)
        sleep( 1 );
        continue;
    }
}
