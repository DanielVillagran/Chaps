<section class="content">
<div class="row">
	<div class="col-md-12">
<!-- Single button -->
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/boxhistory-word.php">Word 2007 (.docx)</a></li>
  </ul>
</div>
		<h1><i class='fa fa-archive'></i> Historial de Caja</h1>
		<div class="clearfix"></div>



<br>
<div class="row">
	<div class="col-md-6">
<select class="form-control" id="controles" onchange="cambio()">
	<option value="">-- Todas las Tiendas --</option>
	<?php
$aux = StockData::getAll();

foreach ($aux as $key) {
	$variable = "";
	if (isset($_GET["opt"]) && $_GET["opt"] == $key->id) {
		$variable = "selected";
	}
	echo '<option ' . $variable . ' value="' . $key->id . '">' . $key->name . '</option>';
}
?>
</select>
</div>
</div>
<?php
if (isset($_GET["opt"])) {
	$boxes = BoxData::getByStock($_GET['opt']);

} else {
	$boxes = BoxData::getAll();
}
$products = SellData::getSellsUnBoxed();
if (count($boxes) > 0) {
	$total_total = 0;
	?>
<br>
<div class="box box-primary">
<table class="table table-bordered table-hover	">
	<thead>
		<th></th>
		<th>Total</th>
		<th>Almacen</th>
		<th>Fecha</th>
	</thead>
	<?php foreach ($boxes as $box):
		$sells = SellData::getByBoxId($box->id);

		?>

																									<tr>
																										<td style="width:30px;">
																								<a href="./index.php?view=b&id=<?php echo $box->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>
																										</td>
																										<td>

																								<?php
	$total = 0;
		foreach ($sells as $sell) {
			$operations = OperationData::getAllProductsBySellId($sell->id);
			$total += $sell->total - $sell->discount;
		}
		$total_total += $total;
		echo "<b>$ " . number_format($total, 2, ".", ",") . "</b>";

		?>

																										</td>
																										<td><?php echo $box->getStock()->name; ?></td>
																										<td><?php echo $box->created_at; ?></td>
																									</tr>
																								<?php endforeach;?>
</table>
</div>
<h1>Total: <?php echo "$ " . number_format($total_total, 2, ".", ","); ?></h1>
	<?php
} else {

	?>
	<div class="jumbotron">
		<h2>No hay ventas</h2>
		<p>No se ha realizado ninguna venta.</p>
	</div>

<?php }?>
<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
</section>
<script type="text/javascript">
	function cambio(){
		if($("#controles").val()!=""){
			window.location.href="./?view=boxhistory&opt="+$("#controles").val();
		}else{
			window.location.href="./?view=boxhistory";
		}
	}
</script>