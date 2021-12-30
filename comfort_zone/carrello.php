<?php
require_once 'bootstrap.php';

if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}elseif($_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}


$username_utente=$_SESSION["user"];//username del proprietario del carrello. in caso modificare a seconda del login

$templateParams["titolo"] = "Comfort Zone - Carrello";
$templateParams["nome"] = "carrello_template.php";
$templateParams["prodotti_in_carrello"] = ($dbh->getAllUserProducts($username_utente));

require 'template/base.php';
?>