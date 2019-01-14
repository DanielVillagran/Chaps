<?php

require ('conexion.php');

$url="application/storage/products/";

/*$user = $_POST['userid'];


$lista=R::find( 'user', "id=".$user );
$usuario="false";
if($lista){
	foreach ($lista as $key ) {
		//$_SESSION['user_id']=$key['id'] ;
		$usuario=$key;
		break;
	}
}
if($usuario['stock_id']!=null){
	$lista=R::find( 'product', "id=".$user );
}else{
	$lista=R:findAll("product");
}*/
$lista=R::findAll("product");
$products['list']="";
$products['status']=true;
$server="http://brayammorando.com/Chaps/storage/products/";
foreach ($lista as $key) {
	$products['list'].='<div class="col-md-4" onclick="agregarProducto(\''.$key['name'].'\',\''.$key['price_out'].'\',\''.$key['id'].'\')">
	<div class="divitemproducto cat_'.$key['category_id'].'">
	<center>
	<img id="imgproducto" src="'.$server.$key['image'].'" alt="">
	<p class="pitemproducto">'.$key['name'].'</p>
	</center>

	</div>

	</div>';
	
}

echo json_encode($products);
?>