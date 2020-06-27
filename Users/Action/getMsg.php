<?php

session_start();

function test_input($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['club_id']) && isset($_REQUEST['theme'])){
    
    require_once("../../../../Database/dbconnect_chat.php");
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $name = $dts[2];
    
    $club_id = $_REQUEST['club_id'];
    $theme_color = "blue";
    if(isset($_REQUEST['theme'])){
        $theme_color = $_REQUEST['theme'];
    }
    $query = "SELECT chat_msg, time_stamp, sender_id FROM chat_msgs WHERE club_id = $club_id ORDER BY time";
    
    if($data = $conn->query($query)){
        
        if($data->num_rows == 0){
            //This user dosen't actually exist in this club
            die("<div class='w3-center'>-</div>");
        }
        
        while($result = $data->fetch_assoc()){
         
            $msg = base64_decode($result['chat_msg']);
            $time = $result['time_stamp'];
            $u_msg_id = $result['sender_id'];
            
            $qry = "SELECT u_name FROM users WHERE u_id = $u_msg_id";
            $u_name = "Someone";
            if($d = $conn->query($qry)){
                
                $rslt = $d->fetch_assoc();
                $u_name = $rslt['u_name'];
                
            }
            
            if($result['sender_id'] == $id){
                
                $message = "<div class='w3-bar'>";
                $message .= "<div class='w3-bar-item w3-border w3-round w3-margin-top w3-margin-left w3-$theme_color w3-right' style='max-width:80%;'>";
                $message .= $msg;
                $message .= "<div class='w3-small'>$time</div>";
                $message .= "</div></div>";
                
                echo $message;
                
            } 
            else{
                
                $message = "<div class='w3-bar'>";
                $message .= "<div class='w3-bar-item w3-border w3-round w3-margin-top w3-margin-left w3-white w3-left' style='max-width:80%;'>";
                $message .= $msg;
                $message .= "<div class='w3-small'>$u_name $time</div>";
                $message .= "</div></div>";
                
                echo $message;
                
            }
            
        
        }
    }
    else{
        die("not2");
    }
    
    
}
else if(isset($_SESSION['login_user_connect_club'])){
    echo "Please, login first";
}
else{
    header("Location:../logout");   
}
    
?>