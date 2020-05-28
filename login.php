<?php

session_start();

if(isset($_SESSION['signup_login']) && isset($_SESSION['login_user_connect_club'])){
 
    unset($_SESSION['signup_login']);
    
    $url = base64_decode($_SESSION['login_user_connect_club']);
    
    $url = explode("&", $url);
    $id = $url[0];
    $name = $url[2];
    
    $url = base64_encode($id."&".$name);
    
    header("Location:Users/profile?name=".$url);
    
}
else{
    echo "<script>alert('Login first')</script>";
    header("Location:logout");
}

?>