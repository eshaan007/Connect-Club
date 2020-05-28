<?php 
session_start();
if(isset($_SESSION['signup_r']) && isset($_SESSION['signup_login'])){

    unset($_SESSION['signup_login']);
    unset($_SESSION['signup_r']);
    
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $password = $_POST['Pass1'];
}
?>
