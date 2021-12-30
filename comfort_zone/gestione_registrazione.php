<?php
require "./db/database.php";
require "./bootstrap.php";
require_once "./utils/functions.php";



if(!isset($_POST["user"]) || !isset($_POST["password"]) || !isset($_POST["email"]) 
 || !isset($_POST["account"]) || strlen($_POST["password"]) == 0 || !(preg_match_all('/[a-z_]/i',$_POST["user"]) == strlen($_POST["user"])) 
 || !preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $_POST["email"]) ){
    header("Location:registrati.php?error=Dati mancanti o non conformi");
}
else{
    $user=strval($_POST["user"]);
    

    $password=strval($_POST["password"]);
    $random_salt = generateRandomString();
    $pepper = "B8ef1uel4sStDaLvOpoUk1s2kXfTUsZKTXsMOSRKDrCK40DU8M";
    $password = hash('sha512', $password.$random_salt.$pepper);
    $email=strval($_POST["email"]);
    $account=strval($_POST["account"]);
    
    $uniqueu = $dbh->uniqueUserUtente($user)[0]["count(*)"];
    $uniquev = $dbh->uniqueUserVenditore($user)[0]["count(*)"];
    $uniquef = $dbh->uniqueUserFattorino($user)[0]["count(*)"];

    if($_POST["account"]=="Utente"){
        if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["pagamento"]) 
        && !empty($_POST["cognome"]) && !empty($_POST["nome"]) && !empty($_POST["pagamento"]) 
        && (preg_match_all('/[a-z]/i',$_POST["nome"]) == strlen($_POST["nome"])) 
        && (preg_match_all('/[a-z]/i',$_POST["cognome"]) == strlen($_POST["cognome"])) 
        && (preg_match_all('/[0-9a-z\s]/i',$_POST["pagamento"]) == strlen($_POST["pagamento"])) 
        && !(strlen($_POST["pagamento"]) == strspn($_POST["pagamento"]," "))){
            $nome=strval($_POST["nome"]);
            $cognome=strval($_POST["cognome"]);
            $pagam=strval($_POST["pagamento"]);
            if ($uniqueu==0 && $uniquev==0 && $uniquef==0){
            $dbh->insertUtente($pagam, $user, $password, $email, $nome, $cognome, $random_salt);
            
            $_SESSION["user"]=strval($_POST["user"]);
            $_SESSION["account"]=strval($_POST["account"]);
            setcookie("user",$_SESSION["user"],time()+(86400*30),"/");
            $_SESSION["isonline"] = 1;
            
            $dbh->notify("Benvenuto in Comfort Zone!","<a href='index.php'>Comfort Zone</a>",$_SESSION["user"]);
            header("Location:./home-Utente.php");
            
            } else{
                header("Location:registrati.php?error=Username già esistente");
            }
        }
        else{
            header("Location:registrati.php?error=Dati mancanti o non conformi");
        }
    }

    if($_POST["account"]=="Venditore"){
        if(isset($_POST["bankcode"]) && strlen($_POST["bankcode"])>0 && isset($_POST["nome_marchio"]) && strlen($_POST["nome_marchio"])>0 
        && (preg_match_all('/[0-9a-z\s]/i',$_POST["nome_marchio"]) == strlen($_POST["nome_marchio"])) 
        && (preg_match_all('/[0-9a-z]/i',$_POST["bankcode"]) == strlen($_POST["bankcode"])) 
        && !(strlen($_POST["nome_marchio"]) == strspn($_POST["nome_marchio"]," "))
        && isset($_FILES["imgmarchio"]) && strlen($_FILES["imgmarchio"]["name"])>0){
            var_dump($_FILES) ;
            $bankcode=strval($_POST["bankcode"]);
            $nome_marchio=strval($_POST["nome_marchio"]);

            if ($uniqueu==0 && $uniquev==0 && $uniquef==0){
                list($result, $msg) = uploadImage(LOG_DIR, $_FILES["imgmarchio"], array("png"));
                if($result == 0){
                    header("Location:registrati.php?error=Dati mancanti o non conformi-".$msg);
                    exit();
                }
                rename($msg,LOG_DIR.$user.".png");


                $dbh->insertVenditore($bankcode, $user, $password, $email, $nome_marchio, $random_salt);
                $_SESSION["user"]=strval($_POST["user"]);
                $_SESSION["account"]=strval($_POST["account"]);
                setcookie("user",$_SESSION["user"],time()+(86400*30),"/");
                $_SESSION["isonline"] = 1;

                $dbh->notify("Benvenuto in Comfort Zone!","<a href='index.php'>Comfort Zone</a>",$_SESSION["user"]);
                header("Location:./home-Venditore.php");
                
           } else{
            header("Location:registrati.php?error=Username già esistente");
            }
        }
        else{
            header("Location:registrati.php?error=Dati mancanti o non conformi");
        }
    }

    if($_POST["account"]=="Fattorino"){
        if(isset($_POST["nome"]) && ($_POST["cognome"]) && strlen($_POST["nome"])>0 && strlen($_POST["cognome"])>0 
        && (preg_match_all('/[a-z]/i',$_POST["nome"]) == strlen($_POST["nome"])) 
        && (preg_match_all('/[a-z]/i',$_POST["cognome"]) == strlen($_POST["cognome"]))){
            $nome=strval($_POST["nome"]);
            $cognome=strval($_POST["cognome"]);
            if ($uniqueu==0 && $uniquev==0 && $uniquef==0){
                $dbh->insertfattorino($cognome, $user, $password, $email, $nome, $random_salt);
                $_SESSION["user"]=strval($_POST["user"]);
                $_SESSION["account"]=strval($_POST["account"]);
                setcookie("user",$_SESSION["user"],time()+(86400*30),"/");
                $_SESSION["isonline"] = 1;
                
                $dbh->notify("Benvenuto in Comfort Zone!","<a href='index.php'>Comfort Zone</a>",$_SESSION["user"]);
                header("Location:./home-Fattorino.php");

            } else{
                header("Location:registrati.php?error=Username già esistente");
            }
        }
        else{
            header("Location:registrati.php?error=Dati mancanti o non conformi");
        }
    }
    
}
?>