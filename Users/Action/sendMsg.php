<?php

session_start();

function test_input($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['msg']) && isset($_REQUEST['club_id']) && isset($_REQUEST['u_id']) && isset($_REQUEST['theme'])){
    
    require_once("../../../../Database/dbconnect_chat.php");
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $name = $dts[2];
    
    $theme_color = "blue";
    if(isset($_REQUEST['theme'])){
        $theme_color = $_REQUEST['theme'];
    }
    
    $club_id = $_REQUEST['club_id'];
    $msg = $_REQUEST['msg'];
    $u_id = $_REQUEST['u_id'];
    
    if($id != $u_id){
        die("not4");
    }
    
    $query = "SELECT u_id FROM chat_club_member WHERE club_id = $club_id AND u_id = $u_id";
    
    if($data = $conn->query($query)){
        
        if($data->num_rows <= 0){
            //This user dosen't actually exist in this club
            die("not3");
        }
        
    }
    else{
        die("not2");
    }
    
    $msgd = $msg;
    $msg = base64_encode($msg);
    $time = date('d-m-y h:i:s');
    
    $query = "INSERT INTO chat_msgs (chat_msg, sender_id, club_id, time_stamp) VALUES ('$msg', $u_id, $club_id, '$time')";
    
    if($conn->query($query)){
        
        $message = "<div class='w3-bar'>";
        $message .= "<div class='w3-bar-item w3-border w3-round w3-margin-top w3-margin-left w3-$theme_color w3-right' style='max-width:80%;'>";
        $message .= $msgd;
        $message .= "<div class='w3-small'>$time</div>";
        $message .= "</div></div>";
        
        echo $message;
        
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