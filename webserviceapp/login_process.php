<?php

require ('conexion.php');

$url="application/storage/products/";

$user = $_POST['username'];
$pass = sha1(md5($_POST['password']));

$lista=R::find( 'user', "(email= \"".$user."\" or username= \"".$user."\") and password= \"".$pass."\" and status=1" );
$usuario="false";
if($lista){
	foreach ($lista as $key ) {
		$_SESSION['user_id']=$key['id'] ;
		$usuario=$key;
		break;
	}
}
echo $usuario;
?>