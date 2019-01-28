var server="http://localhost/RepositorioChaps";
var username="";
var userid="";
var cuenta=0;
var contador=0;
var stock="";
$(document).ready(function(){
	var url=window.location.href.split("?id=");
	url=url[1].split("&name=");
	username=url[1].split("&stock=")[0];
	stock=url[1].split("&stock=")[1];
	userid=url[0];
	$("#userdev").val(username);
	console.log(userid);
});
$( "#form_devolucion" ).submit(function( event ) {
	event.preventDefault();
	var url=window.location.href.split("?id=");
	url=url[1].split("&name=");
	username=url[1].split("&stock=")[0];
	stock=url[1].split("&stock=")[1];
	userid=url[0];
	console.log(userid);
	$.ajax({
		url: server+"/webserviceapp/devolucion.php",
		type: 'post',
		async: false,
		data: {
			'importe': $("#importedev").val(),
			'concepto':$("#conceptodev").val(),
			'stock_id':stock,
			'user_id':userid
		},
		dataType: 'html',
		success() {

			swal("<p id='pswal'>Devolucion realizada</p>", "<p id='psswal'> El administrador sera notificado en breve.</p>", "success");


		}
	});
})
$('#importedev').on('input', function () { 
	this.value = this.value.replace(/[^0-9]/g,'');
});