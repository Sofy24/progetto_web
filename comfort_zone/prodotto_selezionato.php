<?php
require_once 'bootstrap.php';

if( (!(empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0)) && $_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}



$templateParams["titolo"] = "Comfort Zone - Prodotto Selezionato";
$templateParams["nome"] = "prodotto_corrente.php";



if(!isset($_GET["id"]) || empty( $dbh->getProductById($_GET["id"]))){
    $templateParams["prodotto"]=$dbh->getProductById($dbh->getRandomProducts()[0]["id_prodotto"]);
}else{
    $templateParams["prodotto"] = $dbh->getProductById($_GET["id"]);
}



require 'template/base.php';
?>
