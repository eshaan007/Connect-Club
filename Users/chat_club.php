<?php

session_start();

if(isset($_SESSION['login_user_connect_club']) && isset($_REQUEST['name'])){
    
    $dts = explode("&",base64_decode($_SESSION['login_user_connect_club']));
    $id = $dts[0];
    $email = $dts[1];
    $name = $dts[2];
    
    $url = explode("&",base64_decode($_REQUEST['name']));
    $url_id = $url[0];
    $club_id = $url[1];
    $club_name = $url[2];
    $admin_id = $url[3];
    
    if($url_id != $id){
        header("Location:../logout");
    }
    
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
            define("TITLE", "$club_name | ConnectClub");
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
<!-- varified account -->
<?php
    
    //If a user in not in this chat club then this query will return no value
    //So that we can restrict a user by accessing this chatbox
    
    $qryx = "SELECT u_id FROM chat_club_member WHERE u_id = $id AND club_id = $club_id";
    if($dt = $conn->query($qryx)){
        
        if($dt->num_rows <= 0){
            //This user dosen't belong here
            die("<div class='w3-margin w3-center'>You are no longer a member of this group</div>");
            header("Location:../logout"); 
        }
        
    }
    else{
        die("Something went wrong");
    }
    
?>
<div class="w3-row w3-row-padding w3-margin-top">
<!-- members section -->
<div class="w3-col l3 m3 w3-hide-small w3-round">
<div class="w3-padding w3-center w3-xlarge w3-round w3-<?php echo $theme_color ?>">Members</div>
<table class="w3-table w3-border">
<thead>
    <tr>
        <td class="w3-light-gray" colspan = "2">Names</td>
    </tr>
</thead>
<tbody>
<!-- Admin name -->
<?php
    $query1 = "SELECT u_name FROM users WHERE u_id = $admin_id";
    
    if($data1 = $conn->query($query1)){
        
        $result1 = $data1->fetch_assoc();
?>
<tr>
    <td><i class="fa fa-user-circle"></i> <?php echo $result1['u_name'] ?></td>
    <td class=""><span class="w3-<?php echo $theme_color ?>">Admin</span></td>
</tr>
<?php
        
    }
    else{
        echo "something went wrong";
    }
?>
<!-- Other members name -->
<?php
    $query1 = "SELECT u_name FROM(chat_club_member INNER JOIN users ON chat_club_member.u_id = users.u_id) WHERE club_id = $club_id ORDER BY u_name";
    
    if($data1 = $conn->query($query1)){
        
        while($result1 = $data1->fetch_assoc()){
?>
<tr>
    <td><i class="fa fa-user"></i> <?php echo $result1['u_name'] ?></td>
    <td></td>
</tr>
<?php
        }   
    }
    else{
        echo "something went wrong";
    }
?>
</tbody>
</table>
</div>
<!-- chat section -->
<div class="w3-col l9 m9 w3-round">
<div class="w3-padding-large w3-border w3-round w3-xlarge w3-<?php echo $theme_color ?> w3-bar">
    <div class="w3-bar-item">
        <i class="fa fa-users"></i> <?php echo $club_name ?>
    </div>
    <button class="w3-bar-item w3-button w3-white w3-hover-red kel-hover-2 w3-right w3-large" onclick="leave(<?php echo $club_id ?>, <?php echo $id ?>)"><i class="fa fa-sign-out"></i> Leave</button>
</div>

<div class="w3-border w3-round w3-round w3-xlarge w3-light-gray" >
<div id="chats" style="height:500px;overflow:scroll">
    
</div>
</div>

<div class="w3-row" style="margin-top:10px">
<div class="w3-col l11 m10 s10">
    
<input class="w3-input w3-border w3-round w3-large" id="sender" placeholder="your message...">
</div>
<button class="w3-col l1 m2 s2 w3-button w3-<?php echo $theme_color ?> w3-round w3-large" type="submit" onclick="send()">Send</button>
</div>
</div>
</div>

<script src="../Js/check.js"></script>
<script src="Js/varified.js"></script>
<script>
    
    
let leave = (club_id, id) => {
    
    if(!confirm("Do you really want to leave this Club?")){
        return;
    }
    
    let str = "Club_id="+club_id+"&u_id="+id;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    	
    	if(this.readyState == 4 && this.status == 200){
    		
    		if(this.responseText.length == ""){
    		    
    		    alert("successfully left");
    		    location.reload();
    		    return;
    		}
    		alert(this.responseText);
    		
    	}
    }
    xhttp.open("POST", "Action/leaveUser", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(str);
    
}
    
let scrollUpdate = () => {
    
    var element = document.getElementById("chats");
    element.scrollTop = element.scrollHeight;

}    
    
let send = () => {
    
    let msg = document.getElementById("sender").value;
    if(msg == "" || msg == " "){
        
        return;
        
    }
    
    let str = "msg="+msg+"&u_id="+<?php echo $id ?>+"&club_id="+<?php echo $club_id ?>+"&theme="+'<?php echo $theme_color ?>';
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    	
    	if(this.readyState == 4 && this.status == 200){
    		
    		if(this.responseText.length == "not"){
    		    
    		    alert("We are having some trouble in sending this message");
    		    return;
    		}
    		
    		document.getElementById("sender").value="";
    		document.getElementById("chats").innerHTML += this.responseText;
    	    scrollUpdate();
    	}
    }
    xhttp.open("POST", "Action/sendMsg", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(str);
    scrollUpdate();
    
}
    
let refresh = () =>{
    
    let str = "club_id="+<?php echo $club_id ?>+"&theme="+'<?php echo $theme_color ?>';
    let xhttp = new XMLHttpRequest();
    let data = document.getElementById("chats").innerHTML;
    xhttp.onreadystatechange = function() {
    	
    	if(this.readyState == 4 && this.status == 200){
    		
    		if(this.responseText.length == "not2"){
    		    
    		    alert("We are having some trouble in sending this message");
    		    return;
    		}
    		
    		document.getElementById("chats").innerHTML = this.responseText;
    	    if(data != document.getElementById("chats").innerHTML){
                scrollUpdate();
            }
    	}
    }
    xhttp.open("POST", "Action/getMsg", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(str);
    
}    
setInterval(refresh, 1000);
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
