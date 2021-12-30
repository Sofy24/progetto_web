<?php
require_once "bootstrap.php";



$check = true;
$info_utente = ($dbh->getUserInfo($_SESSION["user"]))[0];
$aule = array();
$aula_inserita = strval($_POST["aula"]);
foreach($dbh->getAllClassroom() as $aula){
    array_push($aule, $aula["numero_aula"]);
}
foreach($aule as $aula){
    if($aula == $aula_inserita){
        $check = false;
    } 
}

if(!isset($_POST["nome"]) || !isset($_POST["cognome"]) || !isset($_POST["email"]) || !isset($_POST["metodo_pagamento"]) || !isset($_POST["aula"])
   || $_POST["nome"] != $info_utente["nome_utente"] || $_POST["cognome"] != $info_utente["cognome_utente"] || $_POST["email"] != $info_utente["email_utente"] 
   || $_POST["metodo_pagamento"] != $info_utente["metodo_pagamento"] || $check){
    header("location: acquisto_form.php?user=".$_SESSION["user"]."&error=error");
   } 
else {
    $dbh->notifyIfProductIsOutOfStock($_SESSION["user"]);
    
    $id_ordine = $dbh->cartToOrder($_SESSION["user"], $_POST["aula"]);
 
    $testo = "Hai effettuato un ordine alle ".date("H:i:s")." del ".date("d/m/Y").".<br/>
            ID ordine: <a href='ordini.php#".$id_ordine."'>".$id_ordine."</a>";
    $dbh->notify($testo, "<a href='index.php'>Comfort Zone</a>", $_SESSION["user"]);
    header("location: thank_you_redirect.php");
}
?>