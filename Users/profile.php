<?php

session_start();

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['name'])){
    
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $email = $dts[1];
    $name = $dts[2];
    
    require_once("../../../Database/dbconnect_chat.php");
    
    $theme_color = "blue";
    
    $qry = "SELECT theme_color FROM((users INNER JOIN theme_user ON users.u_id = theme_user.u_id) INNER JOIN web_theme ON theme_user.theme_id = web_theme.theme_id) WHERE users.u_id = $id";
    if($data = $conn->query($qry)){
        
        $result = $data->fetch_assoc();
        $theme_color = $result['theme_color'];
        
    }
    
    $q = "SELECT verified FROM users WHERE u_id = $id";
    
    if($d = $conn->query($q)){
        
        $rslt = $d->fetch_assoc();
        
        if($rslt['verified'] == '1'){
            define("TITLE", "Home | ConnectClub");
            include("../Commen/header.php");
?>
<!-- Verified account area -->
<?php
            include("Parts/verifiedprofile.php");
        }
        else{
            include("../Commen/headernvr.php");
?>
<!-- Notverified account area -->

<?php
            include("Parts/nonverifiedprofile.php");
        }
        
    }
    else{
        echo "Something went wrong, Please try again later"; 
    }
    
    
?>
<?php
    
    $conn->close();
}
else{
    header("Location:../logout"); 
}

?>