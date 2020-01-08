<?php
   // data sent in header are in JSON format
   header('Content-Type: application/json');
   
   // takes the value from variables and Post the data
   $cid = $_POST['cid'];
   $msg = $_POST['message'];
   $to = "masmallclaims@gmail.com";
   $subj = "Legal Research - Client " . $cid;
   
   $header = "From:webmaster@masmallclaims.org"+" \r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html\r\n";
   $retval = mail ($to,$subject,$msg,$header);
   
   // message Notification
   if( $retval == true ) {
      echo json_encode(array(
         'success'=> true,
         'message' => 'Message sent successfully'
      ));
   }else {
      echo json_encode(array(
         'error'=> true,
         'message' => 'Error sending message'
      ));
   }
?>