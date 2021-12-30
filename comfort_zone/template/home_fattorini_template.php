<section id="ordinicorrenti">
    <h2>Ordini correnti</h2>
    <label>Hai 
        <?php 
            $numero_ordini = $templateParams["info_fattorino"]["ordini_correnti"];
            echo $numero_ordini;
            if ($numero_ordini == 1){
                echo " ordine";
            }
            else{
                echo " ordini";
            }
        ?>  da consegnare</label>
</section>

<div class="riepilogo-ordini">
    <?php foreach($templateParams["ordini"] as $ordine): ?>
        <?php if($ordine["consegnato"] == 1){
            continue;
        }?>
        <div class="grid-container-fattorini">
                <ul>
                    <li>ID Ordine: <?php echo $ordine["id_ordine"];?></li>
                    <li>Consegnare a: <?php echo $ordine["nome_utente"].' '.$ordine["cognome_utente"];?></li>
                    <li>In aula: <?php echo $ordine["numero_aula"];?></li>
                </ul>
                <div>
                    <a href="home-Fattorino.php" onclick="exeDeliver(<?php echo $ordine['id_ordine'];?>, '<?php echo $_SESSION['user'];?>')">Effettua Consegna</a>
                </div> 
        </div>
    <?php endforeach; ?>
</div>

<div class="editVenditore">
<section> 
    <h2>I tuoi dati</h2>
    <label> nome: <?php echo $templateParams["info_fattorino"]["nome_fattorino"]; ?> </label><br>
    <label> cognome: <?php echo $templateParams["info_fattorino"]["cognome_fattorino"]; ?> </label><br>
    <label> username: <?php echo $templateParams["info_fattorino"]["username_fattorino"]; ?> </label><br>
    <label> email: <?php echo $templateParams["info_fattorino"]["email_fattorino"]; ?> </label><br>

    <button id="btnedit" type="button" onclick="location.href='./modifica_dati.php'"> 
        Modifica i tuoi dati
    </button>
</section>
</div>

