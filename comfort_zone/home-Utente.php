<?php
require_once 'bootstrap.php';


if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}elseif($_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}

$templateParams["titolo"] = "Comfort Zone - Home utenti";
$templateParams["nome"] = "home.php";
$templateParams["categorie"] = $dbh->getRandomCategories();
$templateParams["prodotti_casuali"] = $dbh->getRandomProducts();
$templateParams["info_utente"] = ($dbh->getUserInfo($_SESSION["user"]))[0];


require 'template/base.php';
?>