<?php
require_once 'bootstrap.php';

if( isset($_SESSION["user"]) ){
    //sono loggato
    $_SESSION["isonline"] = 1;
    header("Location:./home-".$_SESSION["account"].".php");

}else{
    //effettua login
    $_SESSION["isonline"] = 0;
    
}


$templateParams["titolo"] = "Comfort Zone - Home ";
$templateParams["nome"] = "home.php";
$templateParams["categorie"] = $dbh->getRandomCategories();
$templateParams["prodotti_casuali"] = $dbh->getRandomProducts();

require 'template/base.php';
?>