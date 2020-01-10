var server="http://brayammorando.com/Chaps";
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
	forge.request.ajax({
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
		beforeSend(){
			swal({
				title: "Cargando",
				showConfirmButton: false,
				imageUrl: "/images/loader.gif"
			});
		},
		success() {
			swal.close();

			swal("<p id='pswal'>Devolucion realizada</p>", "<p id='psswal'> El administrador sera notificado en breve.</p>", "success");


		}
	});
})
$('#importedev').on('input', function () { 
	this.value = this.value.replace(/[^0-9]/g,'');
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