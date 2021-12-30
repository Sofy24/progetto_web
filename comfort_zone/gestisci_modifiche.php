<?php
require "./db/database.php";
require "./bootstrap.php";


if(isset($_POST["password"]) && isset($_POST["email"]) 
&& strlen($_POST["password"]) > 0 && strlen($_POST["email"]) > 0){
    $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
    if(preg_match($regex, $_POST["email"])) {
        $password = strval($_POST["password"]);
        $email = strval($_POST["email"]);
        $user = $_SESSION['user'];
        $account = $_SESSION['account'];
    
        $salt = strval(($dbh->getSaleUtente($user, $account))[0]["sale"]);
        $pepper = "B8ef1uel4sStDaLvOpoUk1s2kXfTUsZKTXsMOSRKDrCK40DU8M";
        $password = hash('sha512', $password.$salt.$pepper);

        if($_SESSION['account'] == "Utente"){
            if(isset($_POST["pagamento"]) && isset($_POST["nome"]) && isset($_POST["cognome"]) 
            && strlen($_POST["nome"]) > 0 && strlen($_POST["cognome"]) > 0 && strlen($_POST["pagamento"]) > 0
            && (preg_match_all('/[0-9a-z\s]/i',$_POST["pagamento"]) == strlen($_POST["pagamento"]) )
            && (preg_match_all('/[a-z]/i',$_POST["nome"]) == strlen($_POST["nome"]))
            && (preg_match_all('/[a-z]/i',$_POST["cognome"]) == strlen($_POST["cognome"])) 
            && !(strlen($_POST["pagamento"]) == strspn($_POST["pagamento"]," "))){
                $nome = strval($_POST["nome"]);
                $cognome = strval($_POST["cognome"]);
                $pagamento=strval($_POST["pagamento"]);

                $dbh->editDati($nome, $cognome, $password, $email, $user, $pagamento, $account, "", "");
                $dbh->notify("Hai correttamente modificato i tuoi dati.","<a href='index.php'>Comfort Zone</a>",$_SESSION["user"]);
                header("Location:./home-Utente.php");
                }
            else{
                header("Location:modifica_dati.php?dati_mancanti=Dati mancanti o non conformi"); 
            }
        }

        if($_SESSION['account'] == "Fattorino"){
            if(isset($_POST["nome"]) && isset($_POST["cognome"]) 
            && strlen($_POST["nome"]) > 0 && strlen($_POST["cognome"]) > 0
            && (preg_match_all('/[a-z]/i',$_POST["nome"]) == strlen($_POST["nome"])) 
            && (preg_match_all('/[a-z]/i',$_POST["cognome"]) == strlen($_POST["cognome"]) )){
                $nome = strval($_POST["nome"]);
                $cognome = strval($_POST["cognome"]);

                $dbh->editDati($nome, $cognome, $password, $email, $user, "", $account, "", "");    
                $dbh->notify("Hai correttamente modificato i tuoi dati.","<a href='index.php'>Comfort Zone</a>",$_SESSION["user"]);
                header("Location:./home-Fattorino.php");
            }
            else{
                header("Location:modifica_dati.php?dati_mancanti=Dati mancanti o non conformi");
            }
        }

        if($_SESSION['account'] == "Venditore"){
            if(isset($_POST["marchio"]) && isset($_POST["codice_bancario"]) 
            && strlen($_POST["marchio"]) > 0 && strlen($_POST["codice_bancario"]) > 0
            && (preg_match_all('/[0-9a-z\s]/i',$_POST["marchio"]) == strlen($_POST["marchio"]))
            && (preg_match_all('/[0-9a-z]/i',$_POST["codice_bancario"]) == strlen($_POST["codice_bancario"]))
            && !(strlen($_POST["marchio"]) == strspn($_POST["marchio"]," ")) ){
                
                if(isset($_FILES["imgmarchio"]) && strlen($_FILES["imgmarchio"]["name"])>0){
                    
                    list($result, $msg) = uploadImage(LOG_DIR, $_FILES["imgmarchio"], array("png"));
                    /*
                    result=1    ok  ->  msg=fullpath immagine
                    result=0    ko  ->  msg=messaggio di errore
                    */
                    if($result == 0){
                        header("Location:modifica_dati.php?dati_mancanti=Dati mancanti o non conformi-".$msg);
                        exit();
                        // FINISCE QUI
                    }
                    //se andato bene procede
                    unlink(LOG_DIR.$user.".png");
                    rename($msg,LOG_DIR.$user.".png");
                    
                }
                $codice_bancario = strval($_POST["codice_bancario"]);
                $marchio = strval($_POST["marchio"]);
                $dbh->editDati("", "", $password, $email, $user, "", $account, $marchio, $codice_bancario);    
                $dbh->notify("Hai correttamente modificato i tuoi dati.","<a href='index.php'>Comfort Zone</a>",$_SESSION["user"]);
                
                header("Location:./home-Venditore.php");
            }
            else {
                header("Location:modifica_dati.php?dati_mancanti=Dati mancanti o non conformi altro");
            }
        }
    }
    else{
        header("Location:modifica_dati.php?dati_mancanti=Formato email non conforme"); 
    }
}
else{
    header("Location:modifica_dati.php?dati_mancanti=Dati mancanti"); 
}
?>