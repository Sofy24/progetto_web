<?php
require_once 'bootstrap.php';


if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}elseif($_SESSION["account"]!="Fattorino"){
    header("Location:./login_set.php");
}

$username_fattorino = $_SESSION["user"];

$templateParams["titolo"] = "Comfort Zone - Home Fattorini";
$templateParams["nome"] = "home_fattorini_template.php";
$templateParams["info_fattorino"] = ($dbh->getDelivererInfo($username_fattorino))[0];
$templateParams["ordini"] = $dbh->getOrdersByDeliverer($username_fattorino);


require 'template/base.php';
?>