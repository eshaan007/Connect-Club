// we can even export it and use it in required js file.
//but I didn't do that here.
//for that use export class or export default class

class check{
  check(Name){
			
		if(Name == ""){
			throw "Name is empty";
		}
		
		if(Name.includes("$") || Name.includes("&") || Name.includes("=") || Name.includes("*") || Name.includes("`")){
			return true;
		}
		
	}
}
