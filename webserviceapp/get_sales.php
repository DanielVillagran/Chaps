<?php

require ('conexion.php');

$url="application/storage/products/";
if($_POST['stock_id']=='admin'){
	$_POST['stock_id']="1";
}
$ventas['lista']="";
$ventas['total']=0;

$lista=R::getAll( "SELECT s.total, s.created_at, p.name  as name from sell as s
	left join operation as o on o.sell_id=s.id
	left join product as p on p.id=o.product_id
	where s.operation_type_id=2 and s.box_id is NULL and s.p_id=1 and s.is_draft=0 and
	o.stock_id = ".$_POST['stock_id']." and s.user_id =".$_POST['user_id']."
	order by s.created_at desc");
if($lista){
	foreach ($lista as $key) {
		$ventas['lista'].=' <tr>
		<td>'.$key['created_at'].'</td>
		<td>'.$key['name'].'</td>
		<td>$'.number_format($key['total'],2).'</td>
		</tr>';
		$ventas['total']+=$key['total'];
	}
}
echo json_encode($ventas);

?>