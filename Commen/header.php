<!DOCTYPE html>
<html>
<head>
<title><?php echo TITLE ?></title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://fonts.googleapis.com/css2?family=Literata&display=swap" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../CSS/kel.css">
<style>
</style>
<script>
    function myFunction() {
      var x = document.getElementById("Demo");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else { 
        x.className = x.className.replace(" w3-show", "");
      }
    }
</script>
</head>
<body>

<header class="w3-bar w3-<?php echo $theme_color ?> w3-padding">
<div class="w3-bar-item w3-xlarge w3-hide-small" style="margin-right:40px;">ConnectClub</div>
<div class="w3-bar-item w3-large kel-hover-2" title="Home screen" style="margin-top:7px;margin-bottom:7px;">
    <a href="https://keltagoodlife.co/Connect-Club/Users/profile?name=<?php if(isset($_REQUEST['name'])) echo $_REQUEST['name'] ?>" style="text-decoration:none">
    <i class="fa fa-home"></i> Lobby
    </a>
</div>

<button class="w3-bar-item w3-right w3-border kel-hover-2" title="My Account" style="margin-top:7px;margin-bottom:7px" onclick="document.getElementById('editun').style.display='block'">
    <i class="fa fa-lock"></i> <?php echo $name ?>
</button>

<div class="w3-dropdown-click w3-bar-item w3-right w3-<?php echo $theme_color ?> w3-hover-<?php echo $theme_color ?>">
<button class="kel-hover-2 w3-button w3-<?php echo $theme_color ?> w3-hover-<?php echo $theme_color ?>" onclick="myFunction()" title="Options" >
    
    <?php
    
    $qrymn = "SELECT * FROM pokes WHERE rece_id = $id AND seen = '0'";

    if($datamn = $conn->query($qrymn)){
        if($datamn -> num_rows > 0){
?>
    <i class="fa fa-caret-down"></i> <sup><i class="fa fa-circle w3-text-cyan w3-small"></i></sup>
<?php
        }
        else{
?>
            <i class="fa fa-caret-down"></i>
<?php
        }
    }
?>
</button>
    <div id="Demo" class="w3-dropdown-content w3-bar-block w3-border">
      <a onclick="document.getElementById('editun').style.display='block'" class="w3-bar-item w3-button"><i class="fa fa-pencil"></i> Edit</a>
<?php
    if(isset($_REQUEST['name'])){
?>
<a href="pokification?name=<?php echo $_REQUEST['name'] ?>" class="w3-bar-item w3-button"><i class="fa fa-angellist"></i>
<?php
    
    $qrymn = "SELECT * FROM pokes WHERE rece_id = $id AND seen = '0'";

    if($datamn = $conn->query($qrymn)){
        if($datamn -> num_rows > 0){
            
?>
    <span style="font-size:30px; color:blue"><sup><i class="fa fa-circle w3-text-cyan w3-small"></i></sup></span> 
<?php
        }
    }
?>

Pokification</a>
<?php
    }
?>
      <a href="../logout" class="w3-bar-item w3-button"><i class="fa fa-sign-out"></i> LogOut</a>
    </div>
</div>

</header>
