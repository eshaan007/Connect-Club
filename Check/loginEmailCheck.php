<?php 

session_start();

if(isset($_SESSION['signup_login'])){

    $email = $_REQUEST['Email'];
    $pass = $_REQUEST['Pass'];
    
    require_once("../../../Database/dbconnect_chat.php");
    
    $query = "SELECT `u_id`, `u_password`, `u_name` FROM `users` WHERE email = '$email'";
}
?>
