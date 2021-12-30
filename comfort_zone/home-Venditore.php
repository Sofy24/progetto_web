<?php
require_once 'bootstrap.php';

if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}elseif($_SESSION["account"]!="Venditore"){
    header("Location:./login_set.php");
}

$username_venditore = $_SESSION["user"]; 

$templateParams["titolo"] = "Comfort Zone - Home Venditori";
$templateParams["nome"] = "home_venditori_template.php";
$templateParams["info_venditore"] = ($dbh->getSellerInfo($username_venditore))[0];
$templateParams["prodotti_venduti"] = $dbh->getProductsBySeller($username_venditore);


require 'template/base.php';
?>