<?php

$category = UserData::delById($_GET["id"]);
//$category->del();
Core::redir("./index.php?view=users");


?>