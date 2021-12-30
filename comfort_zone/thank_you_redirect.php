<?php   
    require_once "bootstrap.php";

    if( empty($_SESSION["isonline"]) || $_SESSION["isonline"]==0){
        header("Location:./index.php");
    }elseif($_SESSION["account"]!="Utente"){
        header("Location:./login_set.php");
    }

    $templateParams["titolo"] = "Comfort Zone - Grazie!";
    $templateParams["nome"] = "thank_you_template.php";
    require "template/base.php";

?>