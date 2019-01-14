var server="http://brayammorando.com/Chaps";
$(document).ready(function(){
	$("#login").click(function(){
		$.ajax({
			url: server+"/webserviceapp/login_process.php",
			type: "POST",
			data: {
				username:$("#userlogin").val(),
				password:$("#passlogin").val()
			},
			dataType: "json",
			success: function(data) {
				console.log(data);
				if(data==false){
					swal("Error de credenciales.","El usuario no existe o la contraseña es incorrecta, por favor revisa tus credenciales." ,"warning");
				}else{
					//console.log(data.name);
					if(data.stock_id==undefined){
						data.stock_id="admin";

					}
					window.location.replace("inicio.html?id="+data.id+"&name="+data.name+"&stock="+data.stock_id);

				}
			}
		});
	});

});