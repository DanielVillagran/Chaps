<?php

require 'conexion.php';

$url = "application/storage/products/";
if ($_POST['stock_id'] == 'admin') {
	$_POST['stock_id'] = "1";
}
$ventas['lista'] = "";
$ventas['lista_ticket'] = "";
$ventas['total'] = 0;
$where = "";
if ($_POST['product'] != '') {
	$where = " and p.name like '%" . $_POST['product'] . "%' ";

}
$lista = R::getAll("SELECT s.total, s.created_at, p.name  as name from sell as s
	left join operation as o on o.sell_id=s.id
	left join product as p on p.id=o.product_id
	where s.operation_type_id=2 and s.box_id is NULL and s.p_id=1 and s.is_draft=0 and
	o.stock_id = " . $_POST['stock_id'] . $where . "  and s.user_id =" . $_POST['user_id'] . "
	order by s.created_at desc");
if ($lista) {
	foreach ($lista as $key) {
		$ventas['lista'] .= ' <tr>
		<td>' . $key['created_at'] . '</td>
		<td>' . $key['name'] . '</td>
		<td>$' . number_format($key['total'], 2) . '</td>
		</tr>';
		$ventas['total'] += $key['total'];
	}
}
$lista = R::getAll("SELECT count(p.name) as contador, p.name as name from sell as s
	left join operation as o on o.sell_id=s.id
	left join product as p on p.id=o.product_id
	where s.operation_type_id=2 and s.box_id is NULL and s.p_id=1 and s.is_draft=0 and
	o.stock_id = " . $_POST['stock_id'] . $where . "  and s.user_id =" . $_POST['user_id'] . "
	group by p.name order by s.created_at desc");
if ($lista) {
	foreach ($lista as $key) {
		if (strlen($key['name']) > 20) {
			$key['name'] = substr($key['name'], 0, 20);

		} else {
			for ($i = strlen($key['name']); $i < 20; $i++) {
				$key['name'] .= ' ';
			}

		}
		$ventas['lista_ticket'] .= $key['name'] . '          ' . $key['contador'] . "\n";
	}
}
$lista = R::getAll("SELECT count(*) as contador, SUM(importe) as sumatoria from devoluciones
	where stock_id = " . $_POST['stock_id'] . "  and user_id =" . $_POST['user_id'] . " and cortado=0");
$ventas['total_dev'] = 0;
if ($lista) {
	foreach ($lista as $key) {
		if (strlen($key['name']) > 20) {
			$key['name'] = substr($key['name'], 0, 20);

		} else {
			for ($i = strlen($key['name']); $i < 20; $i++) {
				$key['name'] .= ' ';
			}

		}
		$ventas['lista_ticket'] .= 'Devoluciones        ' . '          ' . $key['contador'] . "\n";
		$ventas['total_dev'] += $key['sumatoria'];
	}
}
echo json_encode($ventas);

?>