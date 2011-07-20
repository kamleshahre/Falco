<?php
 function handle_errors($number, $message, $file, $line, $vars){  
 	 $data = date("m.d.y").' ['.date("H:i:s").']';
     $email = " 
------------------------------------------------------------------------------------------------------------------
<p>Nje error ($number) ndodhi ne linjen 
<strong>$line</strong> ne <strong>dokumentin/file-in: $file.</strong> /<p>
<p> $message </p>
<p>Koha: '$data'</p>
------------------------------------------------------------------------------------------------------------------";  
     //$email .= "<pre>" . print_r($vars, 1) . "</pre>";  
 if (DEV == true) {
   	error_log($email,3,'error_history.log');;
 } else {
    $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
    error_log($email, 1, ADMIN_MAIL , $headers);  
 }

     
     // Make sure that you decide how to respond to errors (on the user's side)  
     // Either echo an error message, or kill the entire project. Up to you...  
     // The code below ensures that we only "die" if the error was more than  
     // just a NOTICE.  
     if ( ($number !== E_NOTICE) && ($number < 2048) ) {  
         die('<span style="margin:50px 0 0 20px;font-weight:bold;position:relative;">Ndodhi një gabim në sistem, ju lutem provoni më vonë.</span>');  
     }  
 }  