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
            define("TITLE", "MyClubs | ConnectClub");
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
<div class="w3-row w3-row-padding">
    <div class="w3-xxlarge w3-center"><b>MyClubs</b></div>
    <hr style="border-bottom:1px solid black;" class="w3-margin">
        <div class="w3-col l6 m12 w3-margin-top">
            <table class="w3-table w3-border">
                <thead>
                    <tr class="w3-<?php echo $theme_color ?>">
                        <td colspan="3" class="w3-center w3-xlarge">Clubs created by me</td>
                    </tr>
                    <tr class="w3-light-gray">
                        <td>Name</td>
                        <td>Operation</td>
                        <td>Link</td>
                    </tr>
                </thead>
                <tbody>
<?php
    $query = "SELECT club_id, club_name, admin_id, members, vkey FROM chat_clubs WHERE admin_id = $id";
    
    if($data = $conn->query($query)){
        
        if($data->num_rows <= 0){
?>
<tr>
    <td colspan="3">
<div class="w3-center w3-padding">You haven't created any Chat clubs yet...</div>
<div class="w3-center w3-padding">
<button class="w3-button w3-<?php echo $theme_color ?> kel-hover-2" onclick = "location.replace('createClub?name=<?php echo $_REQUEST['name'] ?>')">Click here to create</button>
</div>
    </td>
</tr>
<?php
        }
        
        while($result = $data->fetch_assoc()){
            $club_name = $result['club_name'];
            $club_id = $result['club_id'];
            $admin_id = $result['admin_id'];
            $vkey = $result['vkey'];
            $url = base64_encode($id."&".$club_id."&".$club_name."&".$admin_id);
?>
    <tr>
        <td style="vertical-align:middle"><?php echo $result['club_name'] ?> <div class="w3-badge"><?php echo $result['members'] ?></div> </td>
        <td>
            <button class="w3-button w3-light-gray w3-hover-blue kel-hover-2" onclick="location.replace('chat_club?name=<?php echo $url ?>')">
                <i class="fa fa-external-link-square"></i> Enter
            </button>
            <button class="w3-button w3-light-gray w3-hover-red kel-hover-2" onclick="deleteAdmin(<?php echo $club_id ?>, <?php echo $id ?>)"><i class="fa fa-trash"></i> Delete</button>
        </td>       
        <td>
            <input class="w3-input w3-center w3-border w3-col l10" id="link_<?php echo $club_id ?>" style="cursor:no-drop" readonly value="https://keltagoodlife.co/Connect-Club/Users/join?val=<?php echo $vkey ?>">
            <button class="w3-col l2 w3-button w3-gray w3-border" type="button" style="cursor:copy"
            onclick="copy('link_<?php echo $club_id ?>')" ><i class="fa fa-copy"></i></button>
        </td>
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
        <div class="w3-col l6 m12 w3-margin-top">
            <table class="w3-table w3-border">
                <thead>
                    <tr class="w3-<?php echo $theme_color ?>">
                        <td colspan="2" class="w3-center w3-xlarge">Total connected clubs</td>
                    </tr>
                    <tr class="w3-light-gray">
                        <td>Name</td>
                        <td>Operation</td>
                    </tr>
                </thead>
                <tbody>
<?php
    $query = "SELECT chat_clubs.club_id, chat_clubs.club_name, chat_clubs.admin_id, chat_clubs.members FROM (chat_club_member INNER JOIN chat_clubs ON chat_club_member.club_id = chat_clubs.club_id) WHERE u_id = $id";
    
    if($data = $conn->query($query)){
        
        if($data->num_rows <= 0){
?>
<tr>
    <td colspan="2">
<div class="w3-center w3-padding">You haven't connected to any Chat clubs yet...</div>

</td>
</tr>
<?php
        }
        
        while($result = $data->fetch_assoc()){
            $club_name = $result['club_name'];
            $club_id = $result['club_id'];
            $admin_id = $result['admin_id'];
            $url = base64_encode($id."&".$club_id."&".$club_name."&".$admin_id);
?>
    <tr>
        <td style="vertical-align:middle"><?php echo $result['club_name'] ?> <div class="w3-badge"><?php echo $result['members'] ?></div> </td>
        <td>
            <button class="w3-button w3-light-gray w3-hover-blue kel-hover-2" onclick="location.replace('chat_club?name=<?php echo $url ?>')">
                <i class="fa fa-external-link-square"></i> Enter
            </button>
            <button class="w3-button w3-light-gray w3-hover-red kel-hover-2" onclick="leave(<?php echo $club_id ?>, <?php echo $id ?>)"><i class="fa fa-sign-out"></i> Leave</button>
        </td>
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
</div>
<script src="../Js/check.js"></script>
<script src="Js/varified.js"></script>
<script>
    
let copy = (id) => {
    
    let text = document.getElementById(id);
    text.select();
    text.setSelectionRange(0, 99999)
    document.execCommand("copy");
    
}    

let deleteAdmin = (club_id, id) => {
    
    if(!confirm("Do you really want to delete this Entire Club? It will delete all chats")){
        return;
    }
    
    let str = "Club_id="+club_id+"&u_id="+id;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    	
    	if(this.readyState == 4 && this.status == 200){
    		
    		if(this.responseText.length == ""){
    		    alert("successfully deleted");
    		    location.reload();
    		    return;
    		}
    		alert(this.responseText);
    		
    	}
    }
    xhttp.open("POST", "Action/deleteAdmin", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(str);
    
}
    
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
