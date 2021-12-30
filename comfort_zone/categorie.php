<?php
require_once 'bootstrap.php';



if( (!(empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0)) && $_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}


$templateParams["titolo"] = "Comfort Zone - Prodotti";
$templateParams["nome"] = "lista-prodotti.php";

if(!isset($_GET["cat"]) || empty($dbh->getProductsFromCategories($_GET["cat"])) ){
    $templateParams["prodotti"]=$dbh->getProductsFromCategories($dbh->getRandomCategories()[0]);
}else{
    $templateParams["prodotti"] = $dbh->getProductsFromCategories($_GET["cat"]);
}



require 'template/base.php';
?>