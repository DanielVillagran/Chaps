var server="http://heladoschaps.com";
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
	//$("#userinicio").empty().append(username);
	swal({
		title: "Cargando...",
		showConfirmButton: false,
		imageUrl: "loader.gif"
	});
	$.ajax({
		url: server+"/webserviceapp/get_products.php",
		type: "POST",
		data: {"product": ""},
		dataType: "json",
		beforeSend: function() {
			
			//console.log("Me la pelo.");
		},
		success: function(data) {
			swal.close();
				////console.log(data);
				//console.log(data);
				$("#rowproductos").empty().append(data.list);
			}
		});
});
$("#buscar").keyup(function(event){
	
	$.ajax({
		url: server+"/webserviceapp/get_products.php",
		type: "POST",
		data: {"product": $("#buscar").val()},
		dataType: "json",
		beforeSend: function() {
			swal({
				title: "Cargando...",
				showConfirmButton: false,
				imageUrl: "loader.gif"
			});
		},
		success: function(data) {
				////console.log(data);
				swal.close();
				//console.log(data);
				$("#rowproductos").empty().append(data.list);
			}
		});

});
function sale(){
	var countrows = $('#tablacarrito tr').length;
	var rows = countrows - 1;

	if (rows == 0) {

		swal("<p id='pswalerror'>Atención</p>", "<p id='psswalerror'>Para realizar una venta primero debe agregar productos al carrito, por favor vuelva a intentarlo.</p>", "info");

	} else {

		swal({

			type: 'info',
			title: "<p id='prealizarventa'>Realizar Venta</i>",
			html: "<p id='psswal'>¿Cantidad recibida?</p>",
			input: 'number',
			confirmButtonText: 'Aceptar',
			showCancelButton: true,
			cancelButtonText: 'Cancelar',

		}).then((result) => {

			var auxiliar = $("#totalcarrito").html();
			auxiliar = auxiliar.replace("$", "");
			auxiliar = auxiliar.replace(",", "");
			var total = parseFloat(auxiliar);
			var inputValue = result.value;

			if (inputValue == "") {

				swal("<p id='pswalerror'> Error </p>", "<p id='psswalerror'>Necesitas escribir una cantidad, <br> por favor vuelva a intentarlo.</p> ", "error");
				return false;

			} else if (total > parseFloat(inputValue)) {

				swal("<p id='pswalerror'> Error </p>", "<p id='psswalerror'>Cantidad recibida menor al valor de la venta, <br>por favor vuelva a intentarlo.</p>", "error");

			} else if (result.value) {

					total = parseFloat(inputValue) - total;
				var product='';
				var price_out='';
				var ticket="";
				var cualquierCadena="";
				$('#tablacarrito > tbody  > tr').each(function () {
					product = $(this).find("td:eq(0)").text();
					product = product.trim();
					cualquierCadena=product;
					price_out = $(this).find("td:eq(1)").text();
					price_out = price_out.trim();
					if(cualquierCadena.length>20){
						cualquierCadena.substring(0,20)

					}else{
						for(var x=cualquierCadena.length;x<20;x++){
							cualquierCadena+=" ";
						}
					}
					ticket+=cualquierCadena+"    $"+addCommas(price_out)+"\n";
					$.ajax({
						url: server+"/webserviceapp/sale.php",
						type: 'post',
						async: false,
						data: {
							'product': product,
							'price_out':price_out,
							'stock_id':stock,
							'user_id':userid
						},
						dataType: 'html',
						success() {

							


						}
					});
				});
				ticket+="\n\n\n";
				ticket+="Total:        $"+addCommas(total);
				$.ajax({
					url: "http://192.168.0.15/ticket/ticket.php",
					type: 'post',
					data: {
						'ticket': ticket,
						"total":1550
					},
					dataType: 'html',
					success() {

						


					}
				});
				swal("<p id='pswal'>Venta realizada</p>", "<p id='psswal'> El cambio a entregar es de: <br> <b id='psbswal'>$" + addCommas(total) + ".<sup id='supswal'>00</sup></b></p>", "success");
				
				$('#tablacarrito  tbody').empty();
				$("#totalcarrito").empty().append("$0.00");
				contador=0;
				cuenta=0;
			}


		});


	}

	$('.swal2-input').on('input', function () {
		this.value = this.value.replace(/[^0-9]/g, '');
	});


}
function agregarProducto(name,price_out,id){
	////console.log("Aqui ando");
	$("#tablacarrito > tbody").append(' <tr id="'+contador+'">\
		<td style="display:none">'+id+'</td>\
		<td style="display:none">'+price_out+'</td>\
		<td class="tdproducto">'+name+'</td>\
		<td class="tdprecio">$'+parseFloat(price_out).toFixed(2)+'</td>\
		<td class="tdborrar"><a onclick="eliminar_carrito(\''+contador+'\',\''+price_out+'\')"><img id="iconborrar" src="images/iconborrar.png" alt=""></a></td>\
		</tr>');
	cuenta+=parseFloat(price_out);
	contador++;
	$("#totalcarrito").empty().append("$"+parseFloat(cuenta).toFixed(2));

}
function eliminar_carrito(id,price_out){
	$('#'+id).remove();
	cuenta-=parseFloat(price_out);
	$("#totalcarrito").empty().append("$"+parseFloat(cuenta).toFixed(2));

}
function addCommas(nStr) {
	nStr += '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
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