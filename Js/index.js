function OpenLogIn()
{
	document.getElementById("layer2").style.display = "none";
	document.getElementById("layer1").style.display = "block";
	
}

function OpenSignIn()
{
	document.getElementById("layer2").style.display = "block";
	document.getElementById("layer1").style.display = "none";
}
//usefull things
class Check{
	
	check(Name){
		
		if(Name == ""){
			throw "Name is empty";
		}
		
		if(Name.includes("$") || Name.includes("&") || Name.includes("=") || Name.includes("*") || Name.includes("`")){
			return true;
		}
		
	}
	
	emailCheck(email, cont_msg) {
		
		if(email == ""){
			throw "Name is empty";
		}
		
		if(cont_msg == ""){
			throw "data is empty";
		}
		
		let s1 = email.split("@");
		let s3 = email.split(" ");
		if(s3.length > 1)
		{
			alert("Please add a proper mail-Id");
			cont_msg.innerHTML = "Please add a proper mail-Id";
			return false;
		}
		if(s1.length == 2)
		{
			var s2 = s1[1].split(".");
			if(s2.length == 2 || s2.length == 3)
			{
				if(s1[0].length < 6 || s2[0].length < 4 || s2[1].length > 4 || s2[1].length < 2)
				{
					alert('Please add a proper mail-Id');
					cont_msg.innerHTML = "Please add a proper mail-Id";
					document.getElementById('email').focus();
					return false;
				}
				
				return true;
				
			}
			else
			{
				alert("Please add a proper mail-Id");
				cont_msg.innerHTML = "Please add a proper mail-Id";
				document.getElementById('email').focus();
				return false;
			}
			
			return true;
		}
		else
		{
			alert("Please add a proper mail-Id");
			cont_msg.innerHTML = "Please add a proper mail-Id";
			document.getElementById('email').focus();
			return false;
		}
			
	}
	
}

let SignUpCheck = () => {
	
	let formS = document.getElementById('signup');
	document.getElementById('name').name = "Name";
	document.getElementById('email').name = "Email";
	document.getElementById('password1').name = "Pass1";
	document.getElementById('password2').name = "Pass2";
	document.getElementById('gender').name = "Gender";
	let check_data = new Check();
	let error = document.getElementById('SignUpError');
	let email1 = "";
	let name = formS.Name.value;
	let email = formS.Email.value;
	let pass = formS.Pass1.value;
	let passCon = formS.Pass2.value;
	let gender = formS.Gender.value;

	if(name == "" || email == "" || pass == "" || passCon == "" || gender == ""){
		alert("Please enter every details");
		error.innerHTML = "Please enter every details";
		return false;
	}
	
	if(name.length <= 4) {
		alert("Please enter your full name");
		error.innerHTML = "Please enter your full name";
		return false;
	}
	
	try{
		if(!check_data.emailCheck(email, error)){
			
			return false;
			
		}
	
		if(check_data.check(email)){
			alert("Please enter valid email");
			error.innerHTML = "Please enter valid email";
			return false;
		}
		
		if(check_data.check(name)){
			alert("Please enter valid name");
			error.innerHTML = "Please enter valid email";
			return false;
		}
		
		if(check_data.check(pass)){
			alert("Please enter valid password");
				error.innerHTML = "Please enter valid email";
			return false;
		}
		
		if(check_data.check(passCon)){
			alert("Please enter valid password");
			error.innerHTML = "Please enter valid email";
			return false;
		}
	}
	catch(err){
			alert("There is a problem: "+err);
		return;
	}
	
	if(pass.length <= 5){
		alert("password must be more than 5 letters");
		error.innerHTML = "password must be more than 5 letters";
		return false;
	}
	
	if(pass !== passCon){
		alert("Both passwords do not match");
		error.innerHTML = "Both passwords do not match";
		return false;
	}

	alert("Js check is done");

}
	
	
