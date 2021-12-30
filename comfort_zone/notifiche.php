<?php
require_once 'bootstrap.php';


if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}

$templateParams["titolo"] = "Comfort Zone - Notifiche";
$templateParams["nome"] = "notifiche_template.php";
$templateParams["notifiche"] = $dbh->getNotification($_SESSION["user"]);


$notifiche_per_pagina = 15;
if (isset($_GET["id_start"])) {
    if (($_GET["id_start"] < 1) or ($_GET["id_start"] > count($templateParams["notifiche"]))) {
        $_GET["id_start"] = 1; 
    }
    while (true) {
        if (($_GET["id_start"] % $notifiche_per_pagina) == 1) {
            $templateParams["id_start"] = $_GET["id_start"];
            break;
        }
        else {
            $_GET["id_start"] -= 1;
        }
    }
}
else {
    $templateParams["id_start"] = 1;
}




require 'template/base.php';
?>