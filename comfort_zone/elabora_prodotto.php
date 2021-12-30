<?php
    require_once "bootstrap.php";



    $numero_categorie=count($dbh->getCategories());
    if($_POST["action"]==3 || (isset($_POST["nome"]) && isset($_POST["descrizione"]) && isset($_POST["prezzo"]) && isset($_POST["quantita"]) 
    && isset($_POST["categoria"]) && strlen($_POST["nome"])>0 && strlen($_POST["descrizione"])>0 && $_POST["categoria"]<=$numero_categorie
    && $_POST["categoria"]>0 && $_POST["prezzo"] > 0 && $_POST["quantita"] > 0 && !(strlen($_POST["nome"]) == strspn($_POST["nome"]," ")))){

        //caso aggiunta
        if($_POST["action"]==1){ 
            $nome= htmlspecialchars($_POST["nome"]);
            $descrizione = htmlspecialchars($_POST["descrizione"]);
            $prezzo = floatval(htmlspecialchars($_POST["prezzo"]));
            $quantita = intval($_POST["quantita"]);
            $categoria = intval($_POST["categoria"]);
            $venditore = $_SESSION["user"];
        

            //tag
            $tags = array();
            foreach($dbh->getTags() as $t){
                if(isset($_POST["tag".$t["id_tag"]])){
                    array_push($tags, $t["id_tag"]);
                }
            }

            //immagine
            list($result, $msg)=uploadImage(PROD_DIR, $_FILES["imgprodotto"], array("jpg"));
            /*
            result=1    ok  ->  msg=fullpath immagine
            result=0    ko  ->  msg=messaggio di errore
            */

            //aggiunta prodotto
            if($result!=0){
                $id=$dbh->insertProdotto( $quantita, $prezzo, $nome, $descrizione, $categoria, $venditore);
                // rinomino l'immagine
                rename($msg,PROD_DIR.$id.".jpg");
                // aggiungo i tag
                if($id!=false){
                    foreach ($tags as $t) {
                        $dbh->insertTagOfProduct($id, $t);
                    }
                    $msg="Prodotto inserito correttamente!";
                }else{
                    //msg errore
                    $msg.="Si è verificato un'errore nell'inserimento dei dati";
                }
            }else{
                $msg="Errore:".$msg;
            }
            header("location: home-Venditore.php?formmsg=".$msg);
        }



        // caso modifica
        if($_POST["action"]==2){
            $nome= htmlspecialchars($_POST["nome"]);
            $descrizione = htmlspecialchars($_POST["descrizione"]);
            $prezzo = floatval(htmlspecialchars($_POST["prezzo"]));
            $quantita = intval($_POST["quantita"]);
            $categoria = intval($_POST["categoria"]);
            $id=intval($_POST["id"]);
            $venditore = $_SESSION["user"];

            //update immagine
            if(isset($_FILES["imgprodotto"]) && strlen($_FILES["imgprodotto"]["name"])>0){

                list($result, $msg) = uploadImage(PROD_DIR, $_FILES["imgprodotto"], array("jpg"));
                /*
                result=1    ok  ->  msg=fullpath immagine
                result=0    ko  ->  msg=messaggio di errore
                */
                if($result == 0){
                    
                    header("location: home-Venditore.php?formmsg=Errore:".$msg);
                    exit();
                    // FINISCE QUI
                }
                //se andato bene procede
                unlink(PROD_DIR.$id.".jpg");
                rename($msg,PROD_DIR.$id.".jpg");
            }
        
            //update prodotto
            $dbh->updateProductOfVenditore($quantita, $prezzo, $nome, $descrizione, $categoria, $venditore, $id);
        
            //update tags
            $tags = array();
            foreach($dbh->getTags() as $t){
                if(isset($_POST["tag".$t["id_tag"]])){
                    array_push($tags, $t["id_tag"]);
                }
            }
            $old_tag = explode(",", $_POST["old_tags"]);
            $del_tag = array_diff($old_tag, $tags);
            foreach($del_tag as $t){
                $dbh->deleteTagOfProduct($id, $t);
            }
            $ins_tag = array_diff($tags, $old_tag);
            foreach($ins_tag as $t){
                $dbh->insertTagOfProduct($id, $t);
            }
    
            $msg=$result."Modifica completata correttamente!";
            header("location: home-Venditore.php?formmsg=".$msg);
        }


        //caso cancellazione
        if($_POST["action"]==3){
            $prodotto = intval($_POST["id"]);
            $venditore = $_SESSION["user"];

            $dbh->deleteTagsOfProduct($prodotto);
            $dbh->deleteProduct($prodotto ,$venditore);
            unlink(PROD_DIR.$_POST["id"].".jpg"); 
        
            $msg = "Cancellazione completata correttamente!";
            header("location: home-Venditore.php?formmsg=".$msg);
        }

    }else {
        $msg = "Si è verificato un errore.";
        header("location: home-Venditore.php?formmsg=".$msg);
    }

?>