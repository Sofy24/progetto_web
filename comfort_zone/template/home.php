<!--immagini che scorrono-->

        <div class="row banner">
            <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 ">
                <div class="banners fade">
                    <img src="upload/banner/banner1.jpg" alt="">
                </div>

                <div class="banners fade">
                    <img src="upload/banner/banner2.jpg" alt="">
                </div>

                <div class="banners fade">
                    <img src="upload/banner/banner3.jpg" alt=""> 
                </div>
            </div>
        </div>
        <div class="row pallini">
            <div class="containerDot text-center">
                <span class="dot"></span> 
                <span class="dot"></span> 
                <span class="dot"></span> 
            </div> 
        </div>


<!--categorie-->
<section>
    <div id="categorie" class="row">
            <h2>Categorie</h2>
            <ul>
            <?php foreach($templateParams["categorie"] as $cat): ?>
                <li>
                    <a href="categorie.php?cat=<?php echo $cat["id_categoria"]?>">
                        <div class="col-xs-8 col-md-2 col-lg-2 col-sm-12">
                            <figure>
                                <?php $cate=str_replace("_", " ", $cat["nome"]); ?>
                                <img src="<?php echo PROD_DIR.strval($dbh->getRandomProductsFromCategories($cat["id_categoria"])[0]["id_prodotto"]); ?>.jpg" alt="<?php echo $cate;?>" />
                                <figcaption><?php echo $cate?></figcaption>
                            </figure>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
</section>

<!--prodotti-->
<section>
    <div class="row prodotti">
        <h2>Prodotti</h2>
        
        <div class="grid-container-prodotti">
            <ul>
                <?php foreach($templateParams["prodotti_casuali"] as $prod): ?>
                    
                    <li>
                        <a href="prodotto_selezionato.php?id=<?php echo $prod["id_prodotto"]?>">
                            <img src="<?php echo PROD_DIR.strval($prod["id_prodotto"]); ?>.jpg" alt='<?php echo $prod['nome']; ?>' />
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
    </div>
</section>
<?php if(!$Host): ?>
<section>
    <div class="row editUtente">
        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
            <h2 id="editdati">I tuoi dati</h2>
            <div class="grid-container-datiUtente">
                <label>  
                    nome: <?php echo $templateParams["info_utente"]["nome_utente"]; ?> 
                </label>
                <label>
                    cognome: <?php echo $templateParams["info_utente"]["cognome_utente"]; ?>
                </label>
                <label>
                    username: <?php echo $templateParams["info_utente"]["username_utente"]; ?>
                </label>
                <label>
                    email: <?php echo $templateParams["info_utente"]["email_utente"]; ?>
                </label>
                <label>
                    metodo di pagamento: <?php echo $templateParams["info_utente"]["metodo_pagamento"]; ?>
                </label>
            <button id="btnedit" type="button" onclick="location.href='./modifica_dati.php'"> 
                Modifica i tuoi dati
            </button>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!--consegne-->
<aside>
    <div class="row consegne">
             <h2>Info consegne</h2>
             <div class="grid-container-p-consegne">
                <div class="cnsfoto">
                    <img id="fotouni" src="./upload/uni.jpg" alt="foto università"/>
                </div>
                <div class="bg-primary cnsp"> 
                    <p id="p-consegne">
                        Consegnamo direttamente in aula!</p>
                    <p>Non dovrai nemmeno alzarti dalla sedia, </p>
                    <p>che aspetti?!</p>
                </div>
            </div>
    </div>
</aside>