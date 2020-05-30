<?php

session_start();

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['Email'])){
    
    require_once("../../../Database/dbconnect_chat.php");
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $name = $dts[2];
    $email = $_REQUEST['Email'];
    $vkey = -1;
    $query = "SELECT vkey FROM users WHERE u_id = $id";
    
    if($data = $conn->query($query)){
        
        $result = $data->fetch_assoc();
        $vkey = $result['vkey'];
        
    }
    else{
        die("something went wrong1");
    }
    
    $query = "UPDATE users SET email = '$email' WHERE u_id = $id";
    
    if($conn->query($query)){
        
        $subject = "ConnectClub: Verify your Email Address";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
                 // Creating email headers
        $headers .= 'X-Mailer: PHP/' . phpversion();
                
        $message = '<html><body>';
        $message = '<h1 style="color:black;">Hi '.$name.'!</h1>';
        $message = '<p style="color:green;font-size:19px;">Thanks for registration '.$name.'<br></p>';
        $message = '<p style="color:black;font-size:16px;">ConnectClub has sent you a link to verify your email address.<br></p>';
        $message = '<a style=\"font-size:16px;\" href="https://keltagoodlife.co/Connect-Club/verify?vkey='.$vkey.'" >Click this link to verify your email</a>';
        $message = '<p style="color:black;font-size:16px;">This is a software generated email, so do not reply to this email</p>';
        $message = '<p style="color:black;font-size:16px;">Thank you<br><br>Regards,<br>Team ConnectClub</p>';
                
        $message .= '</body></html>';
                
        if(!mail($email,$subject,$message,$headers)){
            echo "Mail updated but not sent. Please try after some time";
        }
        
        $_SESSION['login_user_connect_club'] = base64_encode($id."&".$email."&".$name);
        
    }
    else{
        echo "Something went wrong2";
    }
    
    $conn->close();
    
}
else if(isset($_SESSION['login_user_connect_club'])){
    echo "Login first";
}
else{
    header("Location:../logout");   
}

?>
