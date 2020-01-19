<?php

require 'conexion.php';

$url = "application/storage/products/";
if ($_POST['id'] == 'admin') {
	$_POST['id'] = "1";
}
$lista = R::getAll("SELECT name from stock
	where id = " . $_POST['id']);
if ($lista) {
	foreach ($lista as $key) {
		$ventas['name'] = $key['name'];
	}
}
echo json_encode($ventas);

?>