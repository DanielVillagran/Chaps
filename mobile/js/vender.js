var server="http://brayammorando.com/Chaps";
var username="";
var userid="";
$(document).ready(function(){
	var url=window.location.href.split("?id=");
	userid=url[1];
	//$("#userinicio").empty().append(username);
	$.ajax({
			url: server+"/webserviceapp/get_products.php",
			type: "POST",
			dataType: "json",
			success: function(data) {
				//console.log(data);
				console.log(data);
				$("#rowproductos").empty().append(data.list);
			}
		});
});
function logout(){
	window.location.replace("index.html");
}
function iniciovender() {

 window.location.replace( 'vender.html?id='+userid);
}