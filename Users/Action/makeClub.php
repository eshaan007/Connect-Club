<?php

session_start();

function test_input($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['Club_name']) && isset($_REQUEST['Club_type'])){
    
    require_once("../../../../Database/dbconnect_chat.php");
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $name = $dts[2];
    $club_name = $_REQUEST['Club_name'];
    $club_type = $_REQUEST['Club_type'];
    $club_pass = $_REQUEST['Club_name'];
    
    if($club_type == "private"){
        $club_pass = $_REQUEST['Club_pass'];
    }
    
    $vkey = md5($club_name.$club_type.time());
    
    $opt = [
      'cost' => 12,  
    ];
            
    $pass = password_hash($club_pass, PASSWORD_BCRYPT, $opt);
    
    $query = "INSERT INTO chat_clubs (club_name, club_password, admin_id, members, club_type, vkey) VALUES ('$club_name', '$pass', $id, 1, '$club_type', '$vkey')";
    
    if($conn->query($query)){
        $url = "https://keltagoodlife.co/Connect-Club/Users/join?val=$vkey";
        echo $url;
        
        $l_id = $conn->insert_id;
        
        $qry = "INSERT INTO chat_club_member (u_id, club_id) VALUES($id, $l_id)";
        $conn->query($qry);
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