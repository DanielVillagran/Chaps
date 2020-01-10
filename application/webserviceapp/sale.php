<?php

require ('conexion.php');

$url="application/storage/products/";
if($_POST['stock_id']=='admin'){
	$_POST['stock_id']="1";
}
 R::exec( "insert into sell (person_id,stock_to_id,iva,p_id,d_id,total,discount,user_id,created_at) values
 	(NULL,
 	".$_POST['stock_id'].",
    16,
 	1,
 	1,
 	". $_POST['price_out'].",
 	0,
 	".$_POST['user_id'].",
 	NOW()
)" );
  $id = R::getInsertID();

 R::exec( "insert into operation (price_in,price_out,stock_id,product_id,q,operation_type_id,sell_id,created_at) values
 	(0,
 	". $_POST['price_out'].",
 	".$_POST['stock_id'].",
 	". $_POST['product'].",
    1,
 	2,
 	".$id.",
 	NOW()
)" );

//echo json_encode($products);
?>
<!-- $servername = "localhost";
$username = "root";
$password = "";
$dbname = "chaps";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql='INSERT INTO sell (person_id,stock_to_id,iva,p_id,d_id,total,discount,user_id,created_at) 
 	(NULL,
 	'+$_POST['stock_id']+',
 	'+16+',
 	'+1+',
 	'+1+',
 	'+$_POST['price_out']+',
 	'+0+'
 	'+$_POST['user_id']+',
 	NOW()
)';
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close(); -->