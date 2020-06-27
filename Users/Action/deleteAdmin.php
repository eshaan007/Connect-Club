<?php

session_start();

function test_input($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['Club_id']) && isset($_REQUEST['u_id'])){
    
    require_once("../../../../Database/dbconnect_chat.php");
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $name = $dts[2];
    $club_id = $_REQUEST['Club_id'];
    $u_id = $_REQUEST['u_id'];
    
    if($id != $u_id){
        die("Something went wrong");
    }
    
    $query = "DELETE FROM chat_clubs WHERE club_id = $club_id AND admin_id = $id";
    
    if($conn->query($query)){
        
    }
    else{
        echo "Something went wrong";
    }
    
}
else if(isset($_SESSION['login_user_connect_club'])){
    echo "Please, login first";
}
else{
    header("Location:../logout");   
}
    
?>