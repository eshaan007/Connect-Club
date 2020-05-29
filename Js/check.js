// we can even export it and use it in required js file.
//but I didn't do that here.
//for that use export class or export default class

class Check{
	
	//method to check the suspecious things in input
	check(Name){
			
		if(Name == ""){
			throw "Name is empty";
		}
		
		if(Name.includes("$") || Name.includes("&") || Name.includes("=") || Name.includes("*") || Name.includes("`")){
			return true;
		}
		
	}
	
	//method to varify the email
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
