<?php

session_start();

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['name'])){
    
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $email = $dts[1];
    $name = $dts[2];
    
    $dts2 = explode("&",base64_decode($_REQUEST['name']));
    $this_u_id = $dts2[0];//user's id who has logged in
    $user_name = $dts2[1];
    $u_id = $dts2[2];//user's id who's profile is visiting
    require_once("../../../Database/dbconnect_chat.php");
    
    if($id != $this_u_id){
        die("Something went wrong");
    }
    
    $theme_color = "blue";
    
    
    $qry = "SELECT theme_color FROM((users INNER JOIN theme_user ON users.u_id = theme_user.u_id) INNER JOIN web_theme ON theme_user.theme_id = web_theme.theme_id) WHERE users.u_id = $id";
    if($data = $conn->query($qry)){
        
        $result = $data->fetch_assoc();
        $theme_color = $result['theme_color'];
        
    }
    else{
        
    }
    define("TITLE", "$user_name's profile | ConnectClub");
    include("../Commen/header.php");
    
    $query = "SELECT * FROM otheruserview WHERE u_id = $u_id";
    
    if($data = $conn->query($query)){
        while($result = $data->fetch_assoc()){
?>
<center>
<div class="w3-light-gray w3-content w3-margin w3-padding">
<div class="w3-center">
<?php 
    if($result['gender'] == "female"){
?>
    <img src="https://www.w3schools.com/howto/img_avatar2.png" class="w3-circle" style="width:140px">
<?php
    }
    else{
?>
    <img src="https://www.w3schools.com/w3images/avatar2.png" class="w3-circle" style="width:140px">
<?php
    }
?>
    <hr>
</div>
<div>
    <button class="w3-button kel-hover-2 w3-<?php echo $theme_color ?>" 
    onclick="poke(<?php echo $id ?>,<?php echo $u_id ?>, '<?php echo $user_name ?>')">
        <i class="fa fa-hand-o-right"></i>Poke</button>
</div>
<div class="w3-container" style="text-align:left">
    <div class="w3-section w3-padding w3-white w3-round">
        Username: <?php echo $result['u_name'] ?>
    </div>
    <div class="w3-section w3-padding w3-white w3-round">
        Name: <?php echo $result['real_name'] ?>
    </div>
    <div class="w3-section w3-padding w3-white w3-round">
        Email: <?php echo $result['email'] ?>
    </div>
    <div class="w3-section w3-padding w3-white w3-round">
        Gender: <?php echo $result['gender'] ?>
    </div>
</div>
</div>
</center>
<script>
    
