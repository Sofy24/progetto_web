<?php
require_once "bootstrap.php";

if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}elseif($_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}

$error=NULL;
if (isset($_GET["error"])){
    $error=$_GET["error"];
}
$templateParams["titolo"] = "Ordina";
$templateParams["nome"] = "acquisto_form_template.php";
$templateParams["info_utente"] = $dbh->getUserInfo($_SESSION["user"]);
$templateParams["prodotti_in_carrello"] = ($dbh->getAllUserProducts($_SESSION["user"]));


//includi template
require "template/base.php";

?>