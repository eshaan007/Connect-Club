<?php

session_start();

function test_input($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['poker_id']) && isset($_REQUEST['recever_id'])){
    
    require_once("../../../../Database/dbconnect_chat.php");
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $name = $dts[2];
    $poker_id = $_REQUEST['poker_id'];
    $rec_id = $_REQUEST['recever_id'];
    
    if($id != $poker_id){
        die("Nothing can be happened");
    }
    
    $query = "INSERT INTO pokes (poker_id, rece_id, seen) VALUES ($poker_id, $rec_id, '0')";
    
    if($conn->query($query)){
        
    }
    else{
        die("something went wrong");
    }
    
}
else if(isset($_SESSION['login_user_connect_club'])){
    echo "Please, login first";
}
else{
    header("Location:../logout");   
}
    
?>