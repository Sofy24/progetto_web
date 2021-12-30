<?php
require_once "bootstrap.php";


if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
    header("Location:./index.php");
}elseif( $_SESSION["account"]!="Venditore" || !isset($_GET["action"]) || ($_GET["action"]!=1 && $_GET["action"]!=2 && $_GET["action"]!=3) ){
    //reindirizzo l'utente al login
    header("location: login_set.php");
}




if($_GET["action"]!=1){
$risultato = $dbh->getProductByIdAndVenditore(intval($_GET["id"]), $_SESSION["user"]);
    if(count($risultato)==0){
        $templateParams["prodotto"] = null;
    }
    else{
        $templateParams["prodotto"] = $risultato[0];
        $templateParams["prodotto"]["tag"] = explode(",", $templateParams["prodotto"]["tag"]);
    }
}
else{
    $templateParams["prodotto"] = array("id" => "", "quantità" => "", "prezzo_unitario" => "", "nome" => "", "descrizione" => "", "id_categoria" => "", "username_venditore" => "", "tag" => array());

}

$templateParams["titolo"] = "Prodotto";
$templateParams["nome"] = "nuovo_prodotto_form.php";
$templateParams["azione"] = $_GET["action"];
$templateParams["tags"] = $dbh->getTags();


//includi template
require "template/base.php";

?>