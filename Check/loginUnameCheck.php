<?php 

session_start();

if(isset($_SESSION['signup_login'])){

    $u_name = $_REQUEST['Uname'];
    $pass = $_REQUEST['Pass'];
    
    require_once("../../../Database/dbconnect_chat.php");
    
    $query = "SELECT `u_id`, `u_password`, `email`, `u_name` FROM `users` WHERE u_name = '$u_name'";
    
}
