<?php

session_start();

if(isset($_REQUEST['email'])){

    $email = $_REQUEST['email'];
    require_once("../../Database/dbconnect_chat.php");
    
    $query = "SELECT email FROM users WHERE email = '$email'";
    
    if($data = $conn->query($query)){
        
        if($data->num_rows <= 0){
            die("Please enter your registered email");
        }
        
    }
    else{
        die("Something went wrong");
    }
    
    $subject = "ConnectClub: Account recovery";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
    // Creating email headers
