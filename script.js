function verify(){
	var myname =document.getElementById("myname");
var options =document.getElementById("options");

	
	if(myname.value.length==0 ){
		alert("Enter name");
		
	}
	

}
function showbtn(){
	var databox = document.getElementById("databox");
	databox.style.display="block";
	databox.style.transition=".4s";

}