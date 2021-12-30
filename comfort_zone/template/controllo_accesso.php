<?php
require_once "../db/database.php";
require_once "../bootstrap.php";




if(!isset($_POST["user"]) || !isset($_POST["password"]) || !isset($_POST["account"])){
    header("Location:../login_set.php?error=Errore. Dati mancanti");
}
else{
    $user = strval($_POST["user"]);
    
    $password = strval($_POST["password"]);
    $pepper = "B8ef1uel4sStDaLvOpoUk1s2kXfTUsZKTXsMOSRKDrCK40DU8M";
    $max_attempts = 4; //impostiamo a 5(0-based) il numero di tentativi massimi che puoi fare mentre effettui 
    //il login con un determinato user per evitare un attacco di brute force 
    
    $account = strval($_POST["account"]);
    

    $dbh->incrementaTentativiUtente($user, $account);
    $tentativi= $dbh->getTentativiUtente($user, $account)[0]["tentativi"];
    $is_not_enabled = $dbh->getAbilitatoUtente($user, $account)[0]["abilitato"];
    $random_salt = strval($dbh->getSaleUtente($user, $account)[0]["sale"]);
    $password = hash('sha512', $password.$random_salt.$pepper);
    if($dbh->checkUtente($user, $password, $account)[0]["count(*)"]!=1 || $is_not_enabled){
        if($tentativi > $max_attempts){
            //tentativi max superati
            if(!$is_not_enabled){
                //è abilitato
                $is_not_enabled = 1;
                $dbh->setAbilitazioneUtente($is_not_enabled, $user, $account);
                $tempoblocco = (explode("/",strval(date("Y/m/d/H/i/s"))));
                $tempoblocco[4] += 1;
                $tempoblocco = implode("/",$tempoblocco);
                $dbh->setTempoDisabilitatoUtente($user, $tempoblocco, $account);
                header("Location:../login_set.php?error=Account disabilitato");
            } else{
                //non è abilitato
                $tempo_attuale = (explode("/",strval(date("Y/m/d/H/i/s"))));;
                $tempo_attuale = implode("/",$tempo_attuale);
                $dbh->setTempoAttualeUtente($user, $tempo_attuale, $account);
                $tempo_attuale = (explode("/",$tempo_attuale));
                $tempoblocco = (explode("/",$dbh->getTempoDisabilitatoUtente($user, $account)[0]["tempo_disabilitato"]));
                if(($tempo_attuale[4] > $tempoblocco[4]) ||  ($tempo_attuale[3] > $tempoblocco[3]) || ($tempo_attuale[2] > $tempoblocco[2])){
                    //abilita
                    $is_not_enabled = 0;
                    $dbh->setAbilitazioneUtente($is_not_enabled, $user, $account);
                    $tentativi = 0;
                    $dbh->setTentativiUtente($tentativi,$user, $account);
                    $dbh->setTempoAttualeUtente($user, "", $account);
                    $dbh->setTempoDisabilitatoUtente($user, "", $account);
                    header("Location:../login_set.php?error=Account abilitato, prova ora a rieffettuare il login in modo corretto");
                } else{
                    //wait
                    header("Location:../login_set.php?error=Tempo sospensione non passato. La preghiamo di attendere");
                }
            }
            
        } else{
            //tentativi max non superati
            if($tentativi == NULL){
                header("Location:../login_set.php?error=Account non registrato. Controlla che i dati inseriti siano corretti.");
            }
            else{
                header("Location:../login_set.php?error=Account non registrato. Controlla che i dati inseriti siano corretti.<br>Tentativo numero:"
                .$tentativi);
            }
        }
        
    }if($dbh->checkUtente($user, $password, $account)[0]["count(*)"] == 1 && !$is_not_enabled){
        $_SESSION["user"] = strval($_POST["user"]);
        $_SESSION["account"] = strval($_POST["account"]);
        setcookie("user",$_SESSION["user"],time()+(86400*30),"/");
        $tentativi = 0;
        $is_not_enabled = 0;
        $dbh->setAbilitazioneUtente($is_not_enabled, $user, $account);
        $dbh->setTentativiUtente($tentativi,$user, $account);
        $dbh->notify("Hai effettuato il login alle ".date("H:i:s")." del ".date("d/m/Y").".", "<a href='index.php'>Comfort Zone</a>", $_SESSION["user"]);
        header('Location: ../home-'.$account.'.php') ;
        $_SESSION["isonline"] = 1;
    }
    

}
?>