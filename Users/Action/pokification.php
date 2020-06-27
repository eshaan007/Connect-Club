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
            define("TITLE", "Pokifications | ConnectClub");
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
    <div class="w3-xxlarge w3-center w3-padding">Pokifications</div>
    
    <hr style="border-bottom:1px solid black;" class="w3-margin">
<div class="w3-padding">
<table class="w3-table w3-border w3-bordered">
<tbody>
    
<?php
    
    $query = "SELECT * FROM(pokes INNER JOIN otheruserview ON otheruserview.u_id = pokes.poker_id) WHERE rece_id = $id ORDER BY poke_time LIMIT 20";
        
    if($data1 = $conn->query($query)){
        
        if($data1->num_rows <= 0){
            echo "<div class='w3-center w3-margin'>There is no pokification</div>";
            $name = $_REQUEST['name'];
?>
<center><button class='kel-hover-2 w3-button w3-<?php echo $theme_color ?>' onclick = "location.replace('people?name=<?php echo $name ?>')">Click here to poke someone</button></center>
<?php
        }
        else{
        while($result1 = $data1->fetch_assoc()){
            
            if($result1['seen'] == '1'){
                
?>
<tr class="w3-center w3-light-gray">
    <td class=""><?php echo $result1['u_name'] ?> has poked you on <?php echo $result1['poke_time'] ?></td>
    <td><button class="w3-button kel-hover-2 w3-<?php echo $theme_color ?>" 
    onclick="poke(<?php echo $id ?>,<?php echo $result1['poker_id'] ?>, '<?php echo $result1['u_name'] ?>')"><i class="fa fa-hand-o-right"></i> Poke back</button></td>
</tr>
<?php
            }
            else{
?>
<tr class="w3-center w3-gray w3-text-white" style="cursor:pointer" onclick="pokedone(<?php echo $result1['poker_id'] ?>, <?php echo $id ?>, '<?php echo $result1['u_name'] ?>')">
    <td class=""><?php echo $result1['u_name'] ?> has poked you on <?php echo $result1['poke_time'] ?></td>
    <td><button class="w3-button kel-hover-2 w3-<?php echo $theme_color ?>" 
    onclick="poke(<?php echo $id ?>, <?php echo $result1['poker_id'] ?>, '<?php echo $result1['u_name'] ?>')"><i class="fa fa-hand-o-right"></i> Poke back</button></td>
</tr>
<?php
            }
        }   
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

let pokedone = (poker_id, recever_id, user = "someone") => {
    
    let str = "poker_id="+poker_id+"&recever_id="+recever_id;
    let xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
    	
    	if(this.readyState == 4 && this.status == 200){
    		
    		if(this.responseText == ""){
    		    alert("You just seen "+user+"\'s poke");
    		    location.reload();
    		}
    	    
    	}
    }
    xhttp.open("POST", "Action/pokedone", true);
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
