<section class="content">
<div class="row">
	<div class="col-md-12">
	<h1>Reporte de Productos Populares</h1>

						<form>
						<input type="hidden" name="view" value="popularproductsreport">
<div class="row">

<div class="col-md-4">
<select class="form-control" id="controles" name="opt">
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
<div class="col-md-3">
<input type="date" name="sd" value="<?php if (isset($_GET["sd"])) {echo $_GET["sd"];}?>" class="form-control">
</div>
<div class="col-md-3">
<input type="date" name="ed" value="<?php if (isset($_GET["ed"])) {echo $_GET["ed"];}?>" class="form-control">
</div>

<div class="col-md-2">
<input type="submit" class="btn btn-success btn-block" value="Procesar">
</div>

</div>
</form>

	</div>
	</div>
<br><!--- -->
<div class="row">

	<div class="col-md-12">
		<?php if (isset($_GET["sd"]) && isset($_GET["ed"])): ?>
<?php if ($_GET["sd"] != "" && $_GET["ed"] != ""): ?>
			<?php
$operations = array();
$elemento = null;
if (isset($_GET["opt"])) {
	$elemento = $_GET["opt"];
}
$operations = OperationData::getPPByDateOfficial($elemento, $_GET["sd"], $_GET["ed"]);

?>

			 <?php if (count($operations) > 0): ?>
<div class="box box-primary">
<table class="table table-bordered">
	<thead>
		<th>Id</th>
		<th>Producto</th>
		<th>Cantidad</th>
		<th>Operacion</th>
		<th>Fecha</th>
	</thead>
<?php foreach ($operations as $operation): ?>
	<tr>
		<td><?php echo $operation->id; ?></td>
		<td><?php echo $operation->getProduct()->name; ?></td>
		<td><?php echo $operation->total; ?></td>
		<td><?php echo $operation->getOperationType()->name; ?></td>
		<td><?php echo $operation->created_at; ?></td>
	</tr>
<?php endforeach;?>

</table>
</div>
			 <?php else:
	// si no hay operaciones
	?>
				<script>
					$("#wellcome").hide();
				</script>
				<div class="jumbotron">
					<h2>No hay operaciones</h2>
					<p>El rango de fechas seleccionado no proporciono ningun resultado de operaciones.</p>
				</div>

							 <?php endif;?>
<?php else: ?>
<script>
	$("#wellcome").hide();
</script>
<div class="jumbotron">
	<h2>Fecha Incorrectas</h2>
	<p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
</div>
<?php endif;?>

		<?php endif;?>
	</div>
</div>

<br><br><br><br>
</section>