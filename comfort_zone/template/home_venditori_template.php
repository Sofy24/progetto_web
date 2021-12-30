<?php if(isset($_GET["formmsg"])):?>
    <div class="text-center panel panel-default">
        <div class="panel-heading">Esito</div>
        <div class="panel-body"><?php echo $_GET["formmsg"]; ?> </div>
        
    </div>
<?php endif; ?>

<div class="editVenditore">
<section>
    <h2 id="editdati">I tuoi dati</h2>
    <label>  
        codice_bancario: <?php echo $templateParams["info_venditore"]["codice_bancario"]; ?> 
    </label><br>
    <label>
        nome_marchio: <?php echo $templateParams["info_venditore"]["nome_marchio"]; ?>
    </label><br>
    <label>
        username_venditore: <?php echo $templateParams["info_venditore"]["username_venditore"]; ?>
    </label><br>
    <label>
        email_venditore: <?php echo $templateParams["info_venditore"]["email_venditore"]; ?>
    </label><br>
    <button id="btnedit" type="button" onclick="location.href='./modifica_dati.php'"> 
        Modifica i tuoi dati
    </button>
</section>
</div>

<a id="addprod" href='aggiunta_prodotto.php?action=1&id='>Aggiungi prodotto</a>

<section id="sectprod">
    <h2>I tuoi prodotti</h2>
    <div class="grid-container-prod prodotti">
        <?php foreach($templateParams["prodotti_venduti"] as $prodotto): ?>
                <div class="eleimg">
                    <img src='<?php echo PROD_DIR.strval($prodotto["id_prodotto"]); ?>.jpg' alt="" />
                </div>
                <div class="ele">
                    <h3><?php echo $prodotto["nome"];?></h3>
                    <div class="prodinfo">
                        <label><?php echo $prodotto["prezzo_unitario"];?> €</label>
                        <label>
                            <?php if ($prodotto["quantità"] == 0) {
                                echo "esaurito";
                            }
                            elseif ($prodotto["quantità"] < 0) {
                                echo "disponibile";
                            }           
                            elseif ($prodotto["quantità"] < 10) {
                                echo "ne rimangolo solo ". $prodotto['quantità'];
                            }
                            else {
                                echo "disponibile";     
                            }
                            ?>
                        </label>
                    </div>
                </div>
                <div class="ele">
                    <p><?php echo $prodotto["descrizione"];?></p>
                </div>
                <div class="ele">
                    <h4>Tag del Prodotto:</h4>
                    <ul>
                        <?php foreach($dbh->getTagsByProduct($prodotto["id_prodotto"]) as $tag): ?>
                            <?php $tagg=str_replace("_", " ", $tag["nome"]); ?>
                            <li>&#x25BA;<?php echo $tagg;?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="ele linkedit">
                    <a href='aggiunta_prodotto.php?action=2&id=<?php echo $prodotto["id_prodotto"]; ?>'>Modifica i dati del prodotto</a><br>
                </div>
                <div class="ele linkdelete">
                    <a href='aggiunta_prodotto.php?action=3&id=<?php echo $prodotto["id_prodotto"]; ?>'>Elimina Prodotto</a><br>
                </div>
                
        <?php endforeach; ?>
    </div>
</section>

