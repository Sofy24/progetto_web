<?php require_once "./bootstrap.php"; 



if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}

$templateParams["titolo"] = "Modifica i tuoi dati";
$templateParams["nome"] = "modifica_dati_template.php";

require "template/base.php";

?>