<?php
require_once 'bootstrap.php';

if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}elseif($_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}


$templateParams["titolo"] = "Comfort Zone - Ordini";
$templateParams["nome"] = "ordini_template.php";
$templateParams["ordini"] = $dbh->getAllOrder();
$templateParams["prodotti_ordinati"] = $dbh->getOrderedProducts($_SESSION["user"]);

require 'template/base.php';
?>