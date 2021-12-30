<div class="product-list">
    <?php if( empty($templateParams["prodotti"]) ):?>
        <div id="no-product">
            <p>Non ci sono prodotti corrispondenti</p>
        </div>
    <?php else: ?>
    
    <?php foreach($templateParams["prodotti"] as $prodotto): ?>
        <article>
            <div class="grid-container">
                <div>
                    <a <?php isActive("prodotto_selezionato.php");?> href="prodotto_selezionato.php?id=<?php echo $prodotto["id_prodotto"]; ?>">
                        <img src="<?php echo PROD_DIR.strval($prodotto["id_prodotto"]); ?>.jpg"  alt=""/>
                    </a>
                </div>
                <h2>
                <a <?php isActive("prodotto_selezionato.php");?> href="prodotto_selezionato.php?id=<?php echo $prodotto["id_prodotto"]; ?>">
                    <?php echo $prodotto["nome"];?>
                </a></h2>
                <p><?php echo $prodotto["descrizione"];?></p>
                <label>Prezzo: <?php echo $prodotto["prezzo_unitario"];?>€</label>
                <label>
                    <?php if ($prodotto["quantità"] == 0) {
                        echo "esaurito";
                    }
                    elseif ($prodotto["quantità"] < 0) {
                        echo "disponibile";
                    }           
                    elseif ($prodotto["quantità"] == 1) {
                        echo "ne rimane solo ". $prodotto['quantità'];
                    }  
                    elseif ($prodotto["quantità"] < 10) {
                        echo "ne rimangono solo ". $prodotto['quantità'];
                    }
                    else {
                        echo "disponibile"; 
                    }
                    ?>
                </label>
                <label>
                    Venduto da: <a href="prodotti_venditore.php?username=<?php echo $prodotto["username_venditore"]; ?>">
                    <?php echo $prodotto["username_venditore"];?> </a>
                </label>
            </div>
        </article>
    <?php endforeach; ?>
    
</div>
<?php endif; ?>