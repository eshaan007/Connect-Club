<?php

session_start();

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['u_id']) && isset($_REQUEST['club_id'])){

    $u_id = $_REQUEST['u_id'];
    $club_id = $_REQUEST['club_id'];
    
    require_once("../../../Database/dbconnect_chat.php");
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $name = $dts[2];

    if(!($id == $u_id)){
        header("Location:../logout");
    }

    $query = "SELECT club_name, club_password, members FROM chat_clubs WHERE club_id = $club_id";
    if($data = $conn->query($query)){
        
        $resultx = $data->fetch_assoc();
        $pass = $resultx['club_name'];
        $dbpass = $resultx['club_password'];
        if(password_verify($pass, $dbpass)){
            
            $mem = $resultx['members'];
            $mem = $mem + 1;
            $queryz = "UPDATE chat_clubs SET members = $mem WHERE club_id = $club_id";
            
            $conn->query($queryz);
            
            $queryy = "INSERT INTO chat_club_member VALUES ($id, $club_id)";
            if($conn->query($queryy)){
               
            }
            else{
                die("You are already in the Club");
            }
            
        }
        else{
            die("Incorrect password");
        }
        
    }
    else{
        die("Something went wrong");
    }
    
}
else{
    header("Location:../logout"); 
}

?>
