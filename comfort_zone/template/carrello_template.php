<div class="cart">
    <?php $user = $_SESSION["user"];?>
    <?php
        $totale = 0;
        if (count($templateParams["prodotti_in_carrello"]) == 0) {
            echo"<label>Il carrello è vuoto</label>";
        }
        foreach($templateParams["prodotti_in_carrello"] as $prodotto): ?>
        <article>
            <div class="grid-container">
                <h2><?php echo $prodotto["nome"];?></h2>    
                <div>
                    <img src="<?php echo PROD_DIR.strval($prodotto["id_prodotto"]); ?>.jpg"  alt=""/>
                </div>
                <?php if($prodotto["quantità"] > 0):?>
                    <a href="carrello.php" onclick="removeFromCart(<?php echo $prodotto['id_prodotto'];?>, '<?php echo $user;?>')">-</a>
                <?php endif;?>
                <label>Quantità:  <?php echo $prodotto["quantità"];?></label>   
                <?php if($prodotto["quantità_residua"] > 0 or $prodotto["quantità_residua"] == -1) :?>
                    <a href="carrello.php" onclick="addToCart(<?php echo $prodotto['id_prodotto'];?>, '<?php echo $user;?>')">+</a>
                <?php else:?>
                    <p>Quantitativo massimo raggiunto</p>
                <?php endif;?>

                <label>
                    Costo Complessivo: <?php $totale += $prodotto["prezzo_unitario"]*$prodotto["quantità"]; echo $prodotto["prezzo_unitario"]*$prodotto["quantità"];?> €
                </label>
                <label>
                    Venduto da: <?php echo $prodotto["username_venditore"];?>
                </label>
                <a href="carrello.php" onclick="deleteFromCart(<?php echo $prodotto['id_prodotto'];?>, '<?php echo $user;?>')">Cancella</a>
            </div>    
        </article>
    <?php endforeach; ?>
    <section>
        <?php if($totale > 0):?>
            <h3>Totale Provvisorio: <?php echo $totale;?>€</h3>
            <a href="acquisto_form.php?user=<?php echo $user;?>">
                Procedi all'ordine
            </a>
        <?php endif; ?>
    </section>
</div>
