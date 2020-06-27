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
    
    $query = "DELETE FROM chat_club_member WHERE club_id = $club_id AND u_id = $id";
    
    if($conn->query($query)){
        
        $qryx = "SELECT members FROM chat_clubs WHERE club_id = $club_id";
        if($d = $conn->query($qryx)){
            
            $rsl = $d->fetch_assoc();
            $mem = $rsl['members'];
            $mem = $mem-1;
            $qryy = "UPDATE chat_clubs SET members = $mem WHERE club_id = $club_id";
            
            if($conn->query($qryy)){
                
            }
            else{
                die("Something went wrong");
            }
            
        }
        
    }
    else{
        echo $query;
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