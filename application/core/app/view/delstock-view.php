<?php

$category = StockData::delById($_GET["id"]);
//$category->del();
Core::redir("./index.php?view=stocks");


?>