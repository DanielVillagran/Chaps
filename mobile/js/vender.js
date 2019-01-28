var server="http://brayammorando.com/Chaps";
var username="";
var userid="";
var cuenta=0;
var contador=0;
var stock="";
$(document).ready(function(){
	var url=window.location.href.split("?id=");
	userid=url[1].split("&stock=")[0];
	stock=url[1].split("&stock=")[1];
	//$("#userinicio").empty().append(username);
	$.ajax({
		url: server+"/webserviceapp/get_products.php",
		type: "POST",
		data: {"product": ""},
		dataType: "json",
		success: function(data) {
				//console.log(data);
				console.log(data);
				$("#rowproductos").empty().append(data.list);
			}
		});
});
$("#buscar").change(function(){
	$.ajax({
		url: server+"/webserviceapp/get_products.php",
		type: "POST",
		data: {"product": $("#buscar").val()},
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
			input: 'text',
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
				$('#tablacarrito > tbody  > tr').each(function () {
					product = $(this).find("td:eq(0)").text();
					product = product.trim();
					price_out = $(this).find("td:eq(1)").text();
					price_out = price_out.trim();
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

							swal("<p id='pswal'>Venta realizada</p>", "<p id='psswal'> El cambio a entregar es de: <br> <b id='psbswal'>$" + addCommas(total) + ".<sup id='supswal'>00</sup></b></p>", "success");


						}
					});
				});

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
	//console.log("Aqui ando");
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

function iniciovender() {
	window.location.replace( 'vender.html?id='+userid);
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
function iniciovender() {

 window.location.href= 'vender.html?id='+userid+'&stock='+stock;
}
function inicioventas() {

 window.location.href= 'ventas.html?id='+userid+'&stock='+stock;
}