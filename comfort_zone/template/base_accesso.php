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
        <script src="./js/hide_input.js" defer="defer"></script>
    </head>
    <body class="overflow-hidden">
        <?php
            if($templateParams["nome"]=='registrati_template.php'){
                $path= "./login_set.php";
                $text="Accedi";
            }else{
                $path= "./registrati.php";
                $text="Registrati";
            }
        ?>
        <!--header-->
        <header class="overflow-hidden">
            <div class="overflow-hidden p-0 container-fluid  ">
            
                <div class="row overflow-hidden " >
                        <!--logo-->
                        <div class=" col-xs-4 col-lg-3 justify-content-lg-center" >
                            <a href="./index.php"><img id="logo_header" src="./upload/logo.png" alt="home"/></a>
                        </div>
                        
                        <div id="accesso" class="col-xs-4 col-xs-offset-3 col-lg-1 col-lg-offset-7">
                            <a href='<?php echo $path; ?>'><?php echo $text; ?></a>
                        </div>
                </div>
            </div> 
        </header>
        <!--main-->
        <main  class="overflow-hidden">
            <?php
                if(isset($templateParams["nome"])){
                    echo '<h1>'.$templateParams["titolo"].'</h1>';
                    require($templateParams["nome"]);
                }
            ?>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <!--footer con fornitori-->
        <footer>
            <div class="row overflow-hidden text-center">
                <section >
                    <h2>chi siamo?</h2>
                    <div class="col-lg-3 col-xs-4">
                        <img id="logo_footer" src="./upload/logo.png" alt=""/>
                    </div>
                    <div class="col-lg-7 col-xs-12">
                        <p>
                            Noi di Comfort Zone ci occupiamo di fornire prodotti supporto a tutti gli studenti in crisi. In fondo, a chi non &egrave; mai capitato un esame andato male? Per tirarsi su baster&agrave; un click, e il prodotto di conforto che preferisci sar&agrave; portato direttamente in aula! Rendi pi&ugrave; allegri i fallimenti tuoi e dei tuoi amici! che aspetti?
                        </p>
                    </div>
                </section>
            </div>
        </footer>
    </body>
</html>
