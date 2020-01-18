<section class="content">
  <div class="row">
   <div class="col-md-12">
    <div class="btn-group pull-right" style="display: none;">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-download"></i> Descargar <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a href="report/byreceive-word.php">Word 2007 (.docx)</a></li>
        <li><a href="report/byreceive-xlsx.php">Excel 2007 (.xlsx)</a></li>
        <li><a onclick="thePDF()" id="makepdf" class="">PDF (.pdf)</a></li>

      </ul>
    </div>

    <h1><i class='glyphicon glyphicon-shopping-cart'></i> Devoluciones</h1>
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
$elemento = null;
if (isset($_GET["opt"])) {
	$elemento = $_GET["opt"];
}
if (isset($_GET["opt"])) {
	$products = OperationData::getDevoluciones($elemento);
}

if (count($products) > 0) {
	?>
     <br>
     <div class="box box-primary">
      <table class="table table-bordered table-hover	">
       <thead>
        <th>Concepto</th>
        <th>Importe</th>
        <th>Fecha</th>

        <th>Tienda</th>
        <th>Usuario</th>
      </thead>
      <?php foreach ($products as $sell):

	?>

       <tr>
        <td>#<?php echo $sell->id; ?></td>

        <td><?php echo $sell->concepto; ?></td>
        <td><?php echo "$" . number_format($sell->importe, 2, ".", ","); ?></td>
        <td><?php echo $sell->created_at; ?></td>
        <td><?php echo $sell->name; ?></td>
        <td style="width:120px;"><?php echo $sell->username; ?></td>
      </tr>

    <?php endforeach;?>

  </table>
</div>

<?php
} else {
	?>
	<div class="jumbotron">
		<h2>No hay datos</h2>
		<p>No se ha realizado ninguna operacion.</p>
	</div>
	<?php
}

?>
<br><br><br><br><br><br><br><br><br><br>
</div>
</div>

<script type="text/javascript">
  function thePDF() {
    var doc = new jsPDF('p', 'pt');
    doc.setFontSize(26);
    doc.text("<?php echo ConfigurationData::getByPreffix("company_name")->val; ?>", 40, 65);
    doc.setFontSize(18);
    doc.text("COMPRAS POR RECIBIR", 40, 80);
    doc.setFontSize(12);
    doc.text("Usuario: <?php echo Core::$user->name . " " . Core::$user->lastname; ?>  -  Fecha: <?php echo date("d-m-Y h:i:s"); ?> ", 40, 90);
    var columns = [
    {title: "Id", dataKey: "id"},
    {title: "Proveedor", dataKey: "client"},
    {title: "Total", dataKey: "total"},
    {title: "Estado de pago", dataKey: "p"},
    {title: "Estado de entrega", dataKey: "d"},
    {title: "Almacen", dataKey: "stock"},
    {title: "Fecha", dataKey: "created_at"},
    ];
    var rows = [
    <?php foreach ($products as $sell):
?>
      {
        "id": "<?php echo $sell->id; ?>",
        "client": "<?php if ($sell->person_id != null) {
	$c = $sell->getPerson();
	echo $c->name . " " . $c->lastname;}?>",
        "total": "<?php
$total = $sell->total - $sell->discount;
echo "$ " . number_format($total, 2, ".", ",");
?>	",
        "p": "<?php echo $sell->getP()->name; ?>",
        "d": "<?php echo $sell->getD()->name; ?>",
        "stock": "<?php echo $sell->getStockTo()->name; ?>",
        "created_at": "<?php echo $sell->created_at; ?>",
      },
    <?php endforeach;?>
    ];
    doc.autoTable(columns, rows, {
      theme: 'grid',
      overflow:'linebreak',
      styles: {
        fillColor: <?php echo Core::$pdf_table_fillcolor; ?>
      },
      columnStyles: {
        id: {fillColor: <?php echo Core::$pdf_table_column_fillcolor; ?>}
      },
      margin: {top: 100},
      afterPageContent: function(data) {
      }
    });
    doc.setFontSize(12);
    doc.text("<?php echo Core::$pdf_footer; ?>", 40, doc.autoTableEndPosY()+25);
    <?php
$con = ConfigurationData::getByPreffix("report_image");
if ($con != null && $con->val != ""):
?>
      var img = new Image();
      img.src= "storage/configuration/<?php echo $con->val; ?>";
      img.onload = function(){
        doc.addImage(img, 'PNG', 495, 20, 60, 60,'mon');
        doc.save('resbyreceive-<?php echo date("d-m-Y h:i:s", time()); ?>.pdf');
      }
      <?php else: ?>
        doc.save('resbyreceive-<?php echo date("d-m-Y h:i:s", time()); ?>.pdf');
      <?php endif;?>
    }
  </script>
  <script type="text/javascript">
  function cambio(){
    if($("#controles").val()!=""){
      window.location.href="./?view=devoluciones&opt="+$("#controles").val();
    }else{
      window.location.href="./?view=devoluciones";
    }
  }
</script>
