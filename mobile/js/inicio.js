var server="http://brayammorando.com/Chaps";
var username="";
var userid="";
$(document).ready(function(){
	var url=window.location.href.split("?id=");
	url=url[1].split("&name=");
	username=url[1];
	userid=url[0];
	$("#userinicio").empty().append(username);
});
function logout(){
	window.location.replace("index.html");
}
function iniciovender() {

 window.location.replace( 'vender.html?id='+userid);
}