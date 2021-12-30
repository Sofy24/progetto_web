<?php
require_once 'bootstrap.php';

if( (!(empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0)) && $_SESSION["account"]!="Utente"){
    header("Location:./login_set.php");
}



$tags = array();
foreach($_GET as $g){
    if(strlen($g)>0 && !empty($dbh->getIdFromTag($g)) && count($tags)<5 ){

        array_push($tags,$dbh->getIdFromTag($g)[0]["id_tag"]);
    }
    
}

$tags=array_unique($tags);




$templateParams["titolo"] = "Comfort Zone - Prodotti";
$templateParams["nome"] = "lista-prodotti.php";
$templateParams["prodotti"] = $dbh->getProductsByTags($tags);

require 'template/base.php';
?>