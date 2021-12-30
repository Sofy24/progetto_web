<?php
    $prodotto=$templateParams["prodotto"];
    $azione = $templateParams["azione"];
    
    if ($azione == 3){
        $disable = "disabled";
    }else{
        $disable="";
    }

    
    
?>

<?php if($prodotto==null): ?>
    <p>Prodotto non trovato</p>
<?php else: ?>
    <form name="prodotto" action="elabora_prodotto.php" method="POST" enctype="multipart/form-data" >
        <ul>
            <li>
                <label for="nome">Nome prodotto</label>
                <input type="text" id="nome" name="nome" value="<?php echo $prodotto['nome']; ?>" maxlength="200" required <?php echo $disable ; ?>>
            </li>
            <li>
                <label for="descrizione">Descrizione prodotto</label><textarea id="descrizione" name="descrizione"  maxlength="500"  required <?php echo $disable ;?>><?php echo $prodotto['descrizione']; ?></textarea>
            </li>
            <li>
                <label for="prezzo">prezzo prodotto in euro</label>
                <input type="number" id="prezzo" name="prezzo" step="0.01" min="0.01" value="<?php echo $prodotto['prezzo_unitario']; ?>" required <?php echo $disable ;?> />
            </li>
            <li>
                <label for="quantita">Quantita prodotto</label>
                <input type="number" min=1 id="quantita" name="quantita"  value="<?php echo $prodotto["quantità"] ;?>" required <?php echo $disable ;?>>
            </li>

            <li>
                <h2>Immagine del prodotto</h2>
                <!--immagine vecchia-->
                <?php if($azione!=1): ?>
                    <img id="immagine_corrente" src="<?php echo PROD_DIR.$prodotto['id'].'.jpg'; ?>" alt="" />
                <?php endif; ?>
                <!--immagine da inserire-->
                <?php if($azione!=3): ?>
                    <label for="imgprodotto">Inserisci nuova immagine prodotto con estensione .jpg:</label>
                    <input type="file" id="imgprodotto" name="imgprodotto" accept=".jpg" <?php if($azione!=2){ echo 'required';} ?> <?php echo $disable; ?> />
                    
                <?php endif; ?>
            
            </li>
            <li>
                <fieldset>
                    <legend>Categoria del prodotto</legend>
                    <ul>
                        <?php foreach( $dbh->getCategories() as $c):?>
                            <li>
                                <input type="radio" id="categoria<?php echo $c["id_categoria"]; ?>" name="categoria" value=<?php echo $c["id_categoria"]; ?> required <?php echo $disable; ?>
                                    <?php 
                                        if($c["id_categoria"]== $prodotto["id_categoria"]){ 
                                            echo ' checked="checked" '; 
                                        } 
                                    ?>/>
                                <label for="categoria<?php echo $c["id_categoria"]; ?>"><?php echo $c["nome"]; ?></label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </fieldset>
            </li>
            <li>
                <h2 id="checkboxes">Tag del prodotto</h2>
                <ul>
                    <?php foreach( $templateParams["tags"] as $t):?>
                        <li>
                            <input type="checkbox" name="tag<?php echo $t["id_tag"]; ?>" id="tag<?php echo $t["id_tag"]; ?>" value='<?php echo $t["id_tag"]; ?>' <?php echo $disable ;?>
                                <?php 
                                    if(in_array($t["id_tag"], $prodotto["tag"])){ 
                                        echo ' checked="checked" '; 
                                    }
                                ?>/>
                        
                            <label for="tag<?php echo $t["id_tag"]; ?>"> <?php echo $t["nome"]; ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li>
                <?php if($templateParams["azione"]==2): ?>
                    <input type="hidden" name="old_tags" value="<?php echo implode(",", $prodotto["tag"]); ?>" />
                <?php endif; ?>
                <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" />
                <input type="hidden" name="action" value="<?php echo $azione ?>" />
                <input type="submit" value="conferma" onclick="check(<?php echo $azione ?>)"/>
            </li>
        </ul>
    </form>
<?php endif;?>
           
  
