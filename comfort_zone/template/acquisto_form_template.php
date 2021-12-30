<div class="order-recap">
    <h2>Riepilogo Ordine</h2>
    <?php $utente = $templateParams["info_utente"][0];?>
    <?php if (isset($error)):?>
        <div class="text-center panel panel-danger">
            <div class="panel-heading">Errore</div>
            <div class="panel-body">dati non conformi o assenti</div>
        </div>
    <?php endif; ?>
    <form action="thank_you.php" method="POST">
        <div>
            <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" readonly value="<?php echo $utente["nome_utente"];?>" required/>
            <label for="cognome">Cognome: </label>
            <input type="text" id="cognome" name="cognome" readonly value="<?php echo $utente["cognome_utente"];?>" required/>
            <label for="email">Email: </label>
            <input type="text" id="email" name="email" readonly value="<?php echo $utente["email_utente"];?>" required/>
            <label for="metodo_pagamento">Metodo Pagamento: </label>
            <input type="text" id="metodo_pagamento" name="metodo_pagamento" readonly value="<?php echo $utente["metodo_pagamento"];?>" required/>
            <label for="aula"> Seleziona Aula</label>
            <input list="aule" type="text" id="aula" name="aula" aria-label="cerca" required/>                                   
            <datalist id="aule">
                <?php foreach($dbh->getAllClassroom() as $aula): ?>
                    <option value="<?php echo $aula["numero_aula"]; ?>">
                <?php endforeach;?>
            </datalist>
            <div>
                <a href="#acquista_ora">Vai in fondo alla pagina</a>
            </div>
        </div>
        <section>
            <h2 id="riepilogo-ordine">Riassunto Articoli</h2>
            <?php
                $totale = 0;
                foreach($templateParams["prodotti_in_carrello"] as $prodotto): ?>
                    <article>
                        <div class="grid-container">
                            <h3><?php echo $prodotto["nome"];?></h3>
                            <div>
                                <img src="<?php echo PROD_DIR.strval($prodotto["id_prodotto"]); ?>.jpg"  alt=""/>
                            </div>
                            <label>Quantità:  <?php echo $prodotto["quantità"];?></label>   
                            <label>Costo Complessivo: <?php $totale += $prodotto["prezzo_unitario"]*$prodotto["quantità"]; echo $prodotto["prezzo_unitario"]*$prodotto["quantità"];?> €</label>
                            <label>
                                Venduto da: <?php echo $prodotto["username_venditore"];?>
                            </label>
                        </div>
                    </article>
                <?php endforeach; 
            ?>
        </section>
        <section>
        <?php if($totale > 0) :?>
            <h2>Totale Ordine: <?php echo $totale;?>€</h2>
            <input type="submit" value="Acquista ora"/>
        <?php else:?>
            <label>Non ci sono articoli in questo ordine</label>
        <?php endif; ?>
        </section>
    </form>
</div>