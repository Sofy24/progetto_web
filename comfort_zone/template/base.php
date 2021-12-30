<!DOCTYPE html>
<html lang="it">
    <head>
        <title><?php echo $templateParams["titolo"]; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
        <script
		src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous" defer="defer"></script>
        <script src="./js/base.js" defer="defer"></script>
        <script src="./js/cart.js" defer="defer"></script>
        <script src="./js/venditore.js" defer="defer"></script>
        <script src="./js/banner.js" defer="defer"></script>
        <script src="./js/uscita.js" defer="defer"></script>
    </head>
    <body>
        <?php 
            if( empty($_SESSION["isonline"]) ||
            $_SESSION["isonline"]==0){
                $Host=1;
                $str="index.php";
                $pos="";
            }else{
                $Host=0;
                $str="home-".$_SESSION["account"].".php";
                $pos="col-lg-pull-4";
            }
        ?>
        <!--header-->
        <header >
            <div class="overflow-hidden p-0 container-fluid ">
                <div class="row ">
                        <!-- menu -->
                        <div id="myNav" class=" overlay">
                            <!-- chiusura-->
                            <a aria-label="close" href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                            <!-- contenuto menu -->
                            <div class="overlay-content">
                                <?php if($Host|| ( $_SESSION["account"]=="Utente") ):?>
                                    <button type="button" class="dropdown-btn" onclick="myFunction()">Categorie</button>
                                    <div class="dropdown-container">
                                        <?php foreach($dbh->getCategories() as $cat): ?>
                                            <a href="categorie.php?cat=<?php echo $cat["id_categoria"]; ?>"> <?php echo $cat["nome"]; ?></a>
                                        <?php endforeach;?>
                                    </div>
                                    <?php if($Host ):?>
                                        <a href="./login_set.php">Accedi o registrati</a>
                                    <?php endif; ?>        
                                <?php endif; ?>
                                <?php if(!$Host ):?>
                                    <a href="notifiche.php?username=<?php echo $_SESSION["user"] ;?>">Notifiche</a>
                                    <?php if($_SESSION["account"]=="Utente"):?>
                                        <a href="carrello.php">Carrello</a>
                                        <a href="ordini.php?username=<?php echo $_SESSION["user"] ;?>">Ordini</a>
                                    <?php endif; ?>
                                    <?php if( $_SESSION["account"]=="Venditore"):?>
                                        <a href="aggiunta_prodotto.php?action=1&id=">Aggiungi prodotto</a>
                                    <?php endif; ?>
                                    <a href="./modifica_dati.php">Modifica i dati del tuo account</a>
                                    <a onclick="esci()">Logout</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="w3-container">
                            <div class="w3-display-container">
                                <span aria-label="menù" id="nav" class=" col-xs-1 col-lg-1 w3-display-right" onclick="openNav()">&#9776;</span>
                            </div>
                        </div>
                        
                        
                        <!--logo-->
                        <div id="div_logo_head" class="px-0 py-3 col-xs-3 col-lg-2 justify-content-xs-center">
                            <a href="<?php echo $str?>"><img id="logo_header" src="./upload/logo.png" alt="home"/></a>
                        </div>

                        <?php if(!$Host):?>
                            <!--notifiche-->
                            <div id="notifiche_head" class="col-xs-2 col-xs-push-2 text-right col-lg-1 col-lg-push-6">
                                <a  href="notifiche.php?username=<?php echo $_SESSION["user"] ;?>"><span class="glyphicon glyphicon-comment text-light" aria-label="notifiche"></span><span class="badge"><?php 
                                    $num = $dbh->getUnreadNumber($_SESSION["user"])[0]["num"] ;
                                    if($num>9){
                                        $num="9+";
                                    }
                                    echo $num;
                                    ?></span></a>
                            </div>

                            <!--modifica dati-->
                            <div id="utente_head" class="col-xs-2 col-xs-push-2 text-center col-lg-1 col-lg-push-6">
                                <a href="./modifica_dati.php"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION["user"];?></a>
                            </div>

                            <!--bottone esci-->
                            <div id="esci_head" class="col-xs-1 col-xs-push-2 text-left col-lg-1 col-lg-push-6">
                                <span onclick="esci()"><span class="glyphicon glyphicon-log-out" aria-label="esci"></span></span>
                            </div>

                            <?php if( $_SESSION["account"]=="Utente"):?>
                                <!--carrello-->
                                <div id="carrello_head" class="col-xs-2 col-xs-pull-5 text-right col-lg-1 col-lg-push-2">
                                    <a  href="carrello.php"><span class="glyphicon glyphicon-shopping-cart text-light" aria-label='carrello'></span><span class="badge"><?php
                                    $num = $dbh->getCartNumber($_SESSION["user"])[0]["num"] ;
                                    if($num>9){
                                        $num="9+";
                                    }
                                    echo $num;
                                    ?></span></a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if($Host): ?>
                            <div id="accesso" class="col-xs-4 col-xs-push-3 text-right col-lg-1 col-lg-push-7 ">
                                <a  href="./login_set.php">Accedi o Registrati</a>
                            </div>
                        <?php endif; ?>

                        <?php if($Host || $_SESSION["account"]=="Utente"):?>
                            <!--barra di ricerca-->
                            <div class="col-xs-12 col-lg-5 <?php echo $pos;?>  align-self-center overflow-hidden">
                                <div class="row justify-content-center">
                                    <div class=" input-group col-xs-12 col-lg-12  ">
                                        <form class="form-inline" action="./prodotti.php" method="get">
                                            <button class=" btn-xs col-xs-2 col-lg-1 " type="submit" id="cerca" aria-label="cerca" ><span class="glyphicon glyphicon-search" ></span></button>
                                            <label id="sr" for="gsearch">barra di ricerca</label>
                                            <input class="col-xs-6 col-lg-8 " list="tags" id="gsearch"  name="gsearch" />                                    
                                            <datalist id="tags">
                                                <?php foreach($dbh->getTags() as $tag): ?>
                                                    <option value="<?php echo $tag["nome"]; ?>">
                                                <?php endforeach;?>
                                            </datalist>
                                            <input class=" btn-xs col-xs-4 col-lg-3 order-12 " id="add_tag_btn" type="button" value="aggiungi tag" onclick="addTag()"/>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                </div>
            </div> 
        </header>
        <!--main-->
        <main>
            <?php
                if(isset($templateParams["nome"])){
                    echo '<h1>'.$templateParams["titolo"].'</h1>';
                    require($templateParams["nome"]);
                }
            ?>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!--footer-->
        <footer>
            <div class="row overflow-hidden text-center">
                <section >
                    <h2>chi siamo?</h2>
                    <div class="col-lg-3">
                        <img id="logo_footer" src="./upload/logo.png" alt=""/>
                    </div>
                    <div class="col-lg-7 col-xs-12">
                        <p>
                            Noi di Comfort Zone ci occupiamo di fornire prodotti supporto a tutti gli studenti in crisi. In fondo, a chi non &egrave; mai capitato un esame andato male? Per tirarsi su baster&agrave; un click, e il prodotto di conforto che preferisci sar&agrave; portato direttamente in aula! Rendi pi&ugrave; allegri i fallimenti tuoi e dei tuoi amici! che aspetti?
                        </p>
                    </div>
                </section>
            </div>
                
            <?php if($Host || $_SESSION["account"]=="Utente"):?>
                <div class="row overflow-hidden text-align-left">
                    <section>
                        <h2>i nostri fornitori</h2>
                        <ul>
                            <?php foreach(($dbh->getAllSeller()) as $venditore) :?>
                                    <li>
                                        <a href="prodotti_venditore.php?username=<?php echo $venditore["username_venditore"]; ?>">
                                            <img src="<?php echo LOG_DIR.$venditore["username_venditore"];?>.png"  alt="<?php echo $venditore["nome_marchio"];?>"/>
                                        </a>
                                    </li>
                            <?php endforeach;?>
                        </ul>
                    </section>
                </div>
            <?php endif; ?>
        </footer>
    </body>
</html>


