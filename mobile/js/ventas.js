var server="http://brayammorando.com/Chaps";
var username="";
var userid="";
var cuenta=0;
var contador=0;
var stock="";
var total=0;
$(document).ready(function(){
	var url=window.location.href.split("?id=");
	userid=url[1].split("&stock=")[0];
	stock=url[1].split("&stock=")[1];
	//$("#userinicio").empty().append(username);
	$.ajax({
		url: server+"/webserviceapp/get_sales.php",
		type: "POST",
		data: {
			'stock_id':stock,
			'user_id':userid,
			"product": $("#buscar").val()
		},
		dataType: "json",
		success: function(data) {
				//console.log(data);
				console.log(data);
				$("#tablamisventas > tbody").empty().append(data.lista);
				total=data.total;
				total=data.total;
				$("#ptotalventas").empty().append("$"+addCommas(parseFloat(total).toFixed(2)));
			}
		});
});
$("#buscar").keyup(function(event){
	$.ajax({
		url: server+"/webserviceapp/get_sales.php",
		type: "POST",
		data: {
			'stock_id':stock,
			'user_id':userid,
			"product": $("#buscar").val()
		},
		dataType: "json",
		success: function(data) {
				//console.log(data);
				console.log(data);
				$("#tablamisventas > tbody").empty().append(data.lista);
			}
		});

});
function corte(){
	swal({
		title: "<p id='pswalerror'>Corte de caja</p>",
		html: "<p id='psswalerror'>Deseas realizar el corte de caja?</p>",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#0066D1',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar',
	}).then((result) => {
		if (result.value) {
			var countrows = $('#tablamisventas tr').length;
			var rows = countrows - 1;

			if (total== 0) {

				swal("<p id='pswalerror'>Atención</p>", "<p id='psswalerror'>Para realizar un corte de caja primero debes realizar una venta.</p>", "info");

			} else {
				$.ajax({
					url: server+"/webserviceapp/corte.php",
					type: "POST",
					data: {
						'stock_id':stock,
						'user_id':userid
					},
					dataType: "json",
					success: function(data) {
				//console.log(data);
				console.log(data);
				swal("<p id='pswal'>Corte Realizado</p>", "<p id='psswal'> La cantidad todal vendida es de : <br> <b id='psbswal'>$" + parseFloat(total).toFixed(2) + "</b></p>", "success");
				//$("#tablamisventas > tbody").empty().append(data.lista);
				//$("#tablamisventas > tbody").empty().append(data.lista);
				total=0;
				$("#ptotalventas").empty().append("$"+addCommas(parseFloat(total).toFixed(2)));
				$.ajax({
					url: server+"/webserviceapp/get_sales.php",
					type: "POST",
					data: {
						'stock_id':stock,
						'user_id':userid
					},
					dataType: "json",
					success: function(data) {
				//console.log(data);
				console.log(data);
				$("#tablamisventas > tbody").empty().append(data.lista);
				total=0;
				$("#ptotalventas").empty().append("$"+addCommas(parseFloat(total).toFixed(2)));
				
			}
		});
			}
		});
			}
		}
	});


}

function logout(){
	window.location.replace("index.html");
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