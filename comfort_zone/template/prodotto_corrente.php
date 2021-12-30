<?php $prodotto = $templateParams["prodotto"][0];?>
<div class="current-product">
    <article>
        <div class="grid-container">
            <h2><?php echo $prodotto["nome"];?></h2>

            <div>
                <img  src="<?php echo PROD_DIR.strval($prodotto["id_prodotto"]); ?>.jpg"  alt=""/>
            </div>

            <p><?php echo $prodotto["descrizione"];?></p>
            <label>Prezzo: <?php echo $prodotto["prezzo_unitario"];?> €</label>
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
                    <?php echo $prodotto["username_venditore"];?>
                </a>
            </label>

            <?php if (!$Host):?>
                <?php $username_utente=$_SESSION["user"];
                if ($prodotto["quantità"] <> 0):?>
                    <a href="prodotto_selezionato.php?id=<?php echo $prodotto["id_prodotto"]; ?>" onclick="addToCart(<?php echo $prodotto['id_prodotto'];?>, '<?php echo $username_utente;?>')">
                        Aggiungi al Carrello
                    </a>
                <?php endif;
                if ($prodotto["quantità"] == 0): ?>
                    <a href="prodotto_selezionato.php?id=<?php echo $prodotto["id_prodotto"]; ?>" onclick="requestRestock(<?php echo $prodotto['id_prodotto'];?>, '<?php echo $username_utente;?>')">
                        Richiedi rifornimento prodotto
                    </a>               
                <?php endif;?>
            <?php endif;?>
        </div>  
    </article>


    <section>
        <h3>Prodotti consigliati</h3>
        <ul>
            <?php $prodotti_consigliati=array();
            $counter = 0?>
            <?php foreach($dbh->getTagsByProduct($prodotto["id_prodotto"]) as $tag_prodotto): ?>
                <?php $prodotto_consigliato = $dbh->getRandomProductByTag($tag_prodotto["id_tag"], $prodotto["id_prodotto"]);
                if ($counter == 4) {
                    break;
                }
                if (empty($prodotto_consigliato) or in_array($prodotto_consigliato[0]["id_prodotto"], $prodotti_consigliati)) {
                    while (true) {
                        $prodotto_consigliato = $dbh->getRandomProducts();
                        if (empty($prodotto_consigliato) or in_array($prodotto_consigliato[0]["id_prodotto"], $prodotti_consigliati) or 
                        ($prodotto_consigliato[0]["id_prodotto"] == $prodotto["id_prodotto"]) ) {
                            continue;
                        }
                        else {
                            break;
                        }
                    }
                }
                array_push($prodotti_consigliati,$prodotto_consigliato[0]["id_prodotto"]);
                $counter += 1;?>
                <li>
                    <div>
                        <a href="prodotto_selezionato.php?id=<?php echo $prodotto_consigliato[0]["id_prodotto"]; ?>">
                            <img src="<?php echo PROD_DIR.strval($prodotto_consigliato[0]["id_prodotto"]); ?>.jpg" alt="" />
                            <h4><?php echo $prodotto_consigliato[0]["nome"];?></h4>
                        </a>
                    </div>
                </li>

            <?php endforeach; ?>
        </ul>
    </section>
</div>