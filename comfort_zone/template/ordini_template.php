<div id="ordini">
    <h2>I miei ordini</h2>
    <?php foreach($templateParams["ordini"] as $ordine): ?>
        <section id="<?php echo $ordine['id_ordine'];?>">
            <h3>Codice Ordine: <?php echo $ordine['id_ordine'];?></h3>
            <?php $totale = 0;
            foreach($templateParams["prodotti_ordinati"] as $prodotto): ?>
                <?php if ($prodotto["id_ordine"] != $ordine["id_ordine"]){
                        continue;
                    }?>
                <?php $totale += $prodotto["prezzo_unitario"] * $prodotto["quantità"];?>
                <article>
                    <a <?php isActive("prodotto_selezionato.php");?> href="prodotto_selezionato.php?id=<?php echo $prodotto["id_prodotto"]; ?>">
                        <h4><?php echo $prodotto["nome"];?></h4>
                    </a>
                    <p><?php echo $prodotto["descrizione"];?></p>
                    <label>
                        Venduto da: <a href="prodotti_venditore.php?username=<?php echo $prodotto["username_venditore"]; ?>">
                        <?php echo $prodotto["username_venditore"];?>
                        </a>
                    </label>
                    <a <?php isActive("prodotto_selezionato.php");?> href="prodotto_selezionato.php?id=<?php echo $prodotto["id_prodotto"]; ?>">
                        <img src="<?php echo PROD_DIR.strval($prodotto["id_prodotto"]);?>.jpg"  alt=""/>
                    </a>
                </article>
            <?php endforeach; ?>
            <label>Totale ordine: <?php echo $totale;?>€</label>
            <label>Ordine effettuato il: <?php echo $ordine["data_ordine"];?></label>
            <label>
                <?php if ($ordine["consegnato"] == 0){
                    echo "In Consegna";
                }
                if ($ordine["consegnato"] == 1){
                    echo "Consegnato il ".$ordine['data_consegna'];
                }
                ?>
            </label>    
        </section>
    <?php endforeach; ?>
</div>