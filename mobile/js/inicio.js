var server="http://localhost/RepositorioChaps";
var username="";
var userid="";
var stock='';
$(document).ready(function(){
	var url=window.location.href.split("?id=");
	url=url[1].split("&name=");
	username=url[1].split("&stock=")[0];
	stock=url[1].split("&stock=")[1];
	userid=url[0];
	$("#userinicio").empty().append(username);
});
function logout(){
	window.location.replace("index.html");
}
function iniciovender() {

 window.location.href= "vender.html?id="+userid+"&name="+username+"&stock="+stock;
}
function inicioventas() {

 window.location.href= "ventas.html?id="+userid+"&name="+username+"&stock="+stock;
}

function iniciodevoluciones() {

 window.location.href= "devoluciones.html?id="+userid+"&name="+username+"&stock="+stock;
}
function inicioinicio(){
	 window.location.href= "inicio.html?id="+userid+"&name="+username+"&stock="+stock;
}