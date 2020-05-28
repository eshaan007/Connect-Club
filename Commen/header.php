<!DOCTYPE html>
<html>
<head>
<title>Home | ConnectClub</title>
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
    <a href="https://keltagoodlife.co/Connect-Club/Users/profile?name=<?php echo $_REQUEST['name'] ?>" style="text-decoration:none">
    <i class="fa fa-home"></i> Lobby
    </a>
</div>
