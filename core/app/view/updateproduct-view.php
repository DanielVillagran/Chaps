<?php

if(count($_POST)>0){
	$product = ProductData::getById($_POST["product_id"]);
	$product->name = $_POST["name"];
	$product->price_out = $_POST["price_out"];
  $product->description = $_POST["description"];
  $category_id="NULL";
  if($_POST["category_id"]!=""){ $category_id=$_POST["category_id"];}

  $is_active=0;
  if(isset($_POST["is_active"])){ $is_active=1;}

  $product->is_active=$is_active;
  $product->category_id=$category_id;

	$product->user_id = $_SESSION["user_id"];
	$product->update();

	if(isset($_FILES["image"])){
		$image = new Upload($_FILES["image"]);
		if($image->uploaded){
			$image->Process("storage/products/");
			if($image->processed){
				$product->image = $image->file_dst_name;
				$product->update_image();
			}
		}
	}

	setcookie("prdupd","true");
	print "<script>window.location='index.php?view=editproduct&id=$_POST[product_id]';</script>";


}


?>