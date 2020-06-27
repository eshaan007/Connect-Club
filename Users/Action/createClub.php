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
            define("TITLE", "Create Club | ConnectClub");
            include("../Commen/header.php");
?>
<!-- Verified account area -->

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
    <div class="w3-xxlarge w3-center w3-padding">Create Club</div>
    <hr style="border-bottom:1px solid black;" class="w3-margin">
    
    <div class="instructions">
    <div class="w3-margin-left w3-large">Rules for creating a Chat club</div>
    <ul>
        <li>Chat club name must be atleast 5 characters long.</li>
        <li>Chat club name must be unique.</li>
        <li>After creating the chat club other members can join this club by entering the club name and password in join section</li>
        <li>Who creates the Chat club will be the admin of the Chat club.</li>
        <li>Only admin can delete the Chat club</li>
    </ul>
        
    </div>
        
    <hr style="border-bottom:1px solid black;" class="w3-margin">
    <form class="w3-padding">
        <center>
        	<div class="w3-text-red" id="chat-error"></div>
        	<div class="loader" id="chat-loader" style="display:none"></div>
        </center>
        <div class="w3-row w3-margin">
            <input class="w3-input w3-center w3-border w3-col l10" id="links" style="cursor:no-drop" readonly value="If you make a new club then the joining link of it will appear here">
            <button class="w3-col l2 w3-button w3-gray w3-border" type="button" style="cursor:copy"
            onclick="copy()" ><i class="fa fa-copy"></i> Copy</button>
        </div>
        <div class="w3-row">
        <div class="w3-margin">
            <div class="w3-section w3-col l6 m6 s12">
                Name:
                <input type="text" id="nameCC" class="w3-input w3-border" placeholder="Name of the ChatClub" required>
            </div>
        </div>
        <div class="w3-margin">
            <div class="w3-section w3-col l6 m6 s12">
                Password:
                <input type="password" id="passCC" class="w3-input w3-border" placeholder="Password of the ChatClub">
            </div>
        </div>
        </div>
        
        <div class="w3-section w3-margin">
            Type of Chat_Club:
        <select class="w3-input w3-border" id="typeCC" required>
            <option class="kel-hover-2 w3-hover-<?php echo $theme_color ?>" value="private">Private</option>
            <option class="kel-hover-2 w3-hover-<?php echo $theme_color ?>" value="public">Public</option>
        </select>
        </div>
        
        <div class="w3-section w3-center w3-margin-top">
            <button type="button" class="w3-button w3-<?php echo $theme_color ?> kel-hover-2 w3-hover-green" onclick="create()">Create</button>
        </div>
    </form>
</div>
</div>
<script src="Js/varified.js"></script>
<script src="../Js/check.js"></script>
<script>

let copy = () => {
    
    let text = document.getElementById("links");
    text.select();
    text.setSelectionRange(0, 99999)
    document.execCommand("copy");
    
}

let create = () => {
    
    let check = new Check();
    let club_name = document.getElementById('nameCC').value;
    let club_pass = document.getElementById('passCC').value;
    let club_type = document.getElementById('typeCC').value;
    let error = document.getElementById('chat-error');
    
    if(club_name == ""){
        alert("Please fill the name");
        error.innerHTML = "Please fill athe name";
        return false;
    }
    
    if(club_type == 'private'){
        
        if(club_pass == ""){
            alert("Password is mendatory for private chat clut");
            error.innerHTML = "Password is mendatory for private chat clut";
            return false;
        }
        
    }
    
    if(check.check(club_name) || check.check(club_pass)){
        alert("Please fill the correct data");
        error.innerHTML = "Please fill the correct data";
        return false;
    }
    
    if(club_name.length <= 5){
        alert("Club name must be of more than 5 characters");
        error.innerHTML = "Club name must be of more than 5 characters";
        return false;
    }
    
    if(club_pass.length <= 5){
        alert("Club password must be of more than 5 characters");
        error.innerHTML = "Club password must be of more than 5 characters";
        return false;
    }
    
    let str = "Club_name="+club_name+"&Club_pass="+club_pass+"&Club_type="+club_type;
    let xhttp = new XMLHttpRequest();
    let loader = document.getElementById('chat-loader');
    xhttp.onreadystatechange = function() {
    	loader.style.display = "block";
    	if(this.readyState == 4 && this.status == 200){
    		loader.style.display = "none";
    		if(this.responseText.length > 20){
    		    
    		    document.getElementById("links").value = this.responseText;
    		    alert("Chat club created!");
    		    error.innerHTML = "";
    		    document.getElementById('passCC').value = "";
    		    return;
    		    
    		}
    		error.innerHTML = this.responseText;
    		
    	}
    }
    xhttp.open("POST", "Action/makeClub", true);
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