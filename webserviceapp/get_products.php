<?php

require ('conexion.php');

$url="application/storage/products/";
if($_POST['product'] != ''){
	$lista=R::find("product","name like '%{$_POST['product']}%'" );
}else{
	$lista=R::findAll("product");
}

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