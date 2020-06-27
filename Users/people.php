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
            define("TITLE", "People | ConnectClub");
            include("../Commen/header.php");
?>
<div class="w3-modal" id="editun">
    <div class="w3-modal-content w3-animate-zoom w3-card-4" style="max-width:500px">
      <header class="w3-container w3-<?php echo $theme_color ?>"> 
        <span onclick="document.getElementById('editun').style.display='none'" 
        class="w3-button w3-display-topright w3-xlarge">&times;</span>
        <h2>My Account</h2>
      </header>
      <form class="w3-container">
<?php
    $query1 = "SELECT u_name FROM users WHERE u_id = $id";
    
    if($data1 = $conn->query($query1)){
        
        $result = $data1->fetch_assoc();
?>
        <div class="w3-container w3-margin w3-padding w3-large">
            <center>
        		<div class="w3-text-red" id="color-error"></div>
        		<div class="loader" id="color-loader" style="display:none"></div>
            </center>
            <b>Choose Theme:</b> <span class="w3-badge w3-blue w3-text-blue w3-margin-left kel-hover-2" onclick="updatetheme('blue')">a</span>
            <span class="w3-badge w3-green kel-hover-2 w3-text-green" onclick="updatetheme('green')">a</span>
            <span class="w3-badge w3-red kel-hover-2 w3-text-red" onclick="updatetheme('red')">a</span>
            <span class="w3-badge w3-pink kel-hover-2 w3-text-pink" onclick="updatetheme('pink')">a</span>
            <span class="w3-badge w3-indigo kel-hover-2 w3-text-indigo" onclick="updatetheme('indigo')">a</span>
        </div>
        <hr>
        <center>
        	<div class="w3-text-red" id="up-error"></div>
        	<div class="loader" id="up-loader" style="display:none"></div>
        </center>
        <table class="w3-table w3-margin-top">
            <tr>
                <td class="w3-large" style="text-align:right;vertical-align: middle;">Username: </td>
                <td><input class="w3-border w3-input" id="u_name" value="<?php echo $result['u_name'] ?>"></td>
            </tr>
        
             <tr style="margin-top:30px;">
                <td class="w3-large" style="text-align:right;vertical-align: middle;">Current Pass: </td>
                <td><input class="w3-border w3-input" id="pass" type="password" placeholder="Current Password"></td>
            </tr>
            <tr>
                <td class="w3-large" style="text-align:right;vertical-align: middle;">New Pass: </td>
                <td><input class="w3-border w3-input" id="newPas" type="password" placeholder="New Password"></td>
            </tr>
            <tr>
                <td class="w3-large" style="text-align:right;vertical-align: middle;">Again new Pass: </td>
                <td><input class="w3-border w3-input" id="newAga" type="password" placeholder="New Password Again"></td>
            </tr> 
            
        </table>
<?php
    }
    else{
        echo "something went wrong";
    }
?>
        <hr>
        <button type="button" class="w3-button w3-right w3-margin-bottom w3-margin-left w3-border w3-round w3-<?php echo $theme_color ?>" onclick="updateProfile()"><i class="fa fa-pencil-square-o"></i> Update</button>
        <button type="button" onclick="document.getElementById('editun').style.display='none'" class="w3-button w3-right w3-margin-bottom w3-border w3-round"><i class="fa fa-times"></i> Cancel</button>
        
      </form>
      
    </div>
</div>

<div class="w3-padding-64">
<div class="w3-content w3-light-gray w3-padding-32">
    <div class="w3-xxlarge w3-center w3-padding">Connected people</div>
    
    <hr style="border-bottom:1px solid black;" class="w3-margin">
<?php
    $query1 = "SELECT chat_clubs.club_id, club_name FROM(chat_club_member INNER JOIN chat_clubs ON chat_club_member.club_id = chat_clubs.club_id) WHERE u_id = $id";
    if($data1 = $conn->query($query1)){
        
        if($data1->num_rows <= 0){
            echo "<div class='w3-center w3-padding w3-margin'>You haven't connected to any people yet</div>";
        }
        else{
        while($result1 = $data1->fetch_assoc()){
            
?>          
<div class="w3-padding">
<table class="w3-table w3-bordered w3-border">
    <thead>
        <tr class="w3-xlarge">
            <td colspan="3" class="w3-center w3-<?php echo $theme_color ?>">People From: <b><?php echo $result1['club_name'] ?></b> Club</td>
        </tr>
        <tr class="w3-dark-gray w3-text-white">
            <th>Name</th>
            <th>Profile links</th>
            <th>Operations</th>
        </tr>
    </thead>
    <tbody>
        <tr>
<?php
    $club_id = $result1['club_id'];
    $query2 = "SELECT otheruserview.u_id, u_name FROM (chat_club_member INNER JOIN otheruserview ON chat_club_member.u_id = otheruserview.u_id) WHERE club_id = $club_id";

    if($data2 = $conn->query($query2)){
        
        if($data2->num_rows <= 0){
            echo "<div class='w3-padding w3-margin w3-center'>There are no other user here</div>";
        }
        
        while($result2 = $data2->fetch_assoc()){
            
            if($id == $result2['u_id']){
                continue;
            }
?>

        <tr>
            <td><?php echo $result2['u_name'] ?></td>
            <td>
                <?php $url = base64_encode($id."&".$result2['u_name']."&".$result2['u_id']); ?>
            <button class="w3-button kel-hover-2 w3-<?php echo $theme_color ?>" onclick="window.open('user?name=<?php echo $url ?>', '_self')">
                Visit</button></td>
            <td><button class="w3-button kel-hover-2 w3-<?php echo $theme_color ?>" 
            onclick="poke(<?php echo $id ?>,<?php echo $result2['u_id'] ?>, '<?php echo $result2['u_name'] ?>')"><i class="fa fa-hand-o-right"></i>Poke</button></td>
        </tr>
<?php
        }
    }
    else{
        echo "Something went wrong";
    }
?>
        </tr>
    </tbody>
</table>
</div>
<?php
        }
        }
    }
    else{
        die("Something went wrong");
    }
    
?>
    
    
</div>
</div>

<script src="Js/varified.js"></script>
<script src="../Js/check.js"></script>
<script>

let poke = (poker_id, recever_id, user = "someone") => {
    
    let str = "poker_id="+poker_id+"&recever_id="+recever_id;
    let xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
    	
    	if(this.readyState == 4 && this.status == 200){
    		
    		if(this.responseText == ""){
    		    alert("You just poked "+user);
    		}
    	}
    }
    xhttp.open("POST", "Action/poke", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(str);
    
}

</script>

</body>
</html>
<?php
        }
        else{
           
?>
<!-- Notverified account area -->

<?php
            header("Location:../logout.php");
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
