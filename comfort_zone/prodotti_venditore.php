<?php
require_once 'bootstrap.php';



if( (!(empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0)) && $_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}


$templateParams["titolo"] = "Comfort Zone - Prodotti";
$templateParams["nome"] = "lista-prodotti.php";



if(!isset($_GET["username"]) || empty($dbh->getProductsFromSeller($_GET["username"])) ){
    $templateParams["prodotti"]=$dbh->getProductsFromSeller($dbh->getAllSeller()[0]["username_venditore"]);
}else{
    $templateParams["prodotti"] = $dbh->getProductsFromSeller($_GET["username"]);
}

require 'template/base.php';
?>