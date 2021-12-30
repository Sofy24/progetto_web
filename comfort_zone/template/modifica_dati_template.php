

            <?php if(isset($_GET["dati_mancanti"])):?>
                <div class="text-center panel panel-danger">
                    <div class="panel-heading">Errore</div>
                    <div class="panel-body"><?php echo $_GET["dati_mancanti"]; ?> </div>
                </div>
            <?php endif; ?> 


            <?php 
                if($_SESSION["account"] == "Venditore"){ 
                    $dati = ($dbh->getSellerInfo($_SESSION['user']))[0];
                }
                if($_SESSION["account"] == "Utente"){
                    $dati = ($dbh->getUserInfo($_SESSION['user']))[0];
                }
                if($_SESSION["account"] == "Fattorino"){
                    $dati = ($dbh->getDelivererInfo($_SESSION['user']))[0];
                }
            ?>

            <form name="edit_dati" action="gestisci_modifiche.php" method="POST" enctype="multipart/form-data">
                <label>User: <?php echo $_SESSION['user']?></label><br/>
                <?php if($_SESSION["account"] == "Utente" || $_SESSION["account"] == "Fattorino"): ?>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" placeholder="Caratteri amessi: A-z" value=<?php echo $dati["nome_".strtolower($_SESSION["account"])];?> required>

                    <label for="cognome">Cognome:</label>
                    <input type="text" id="cognome" name="cognome" placeholder="Caratteri amessi: A-z" value=<?php echo $dati["cognome_".strtolower($_SESSION["account"])];?> required>
                <?php endif ?>

                <?php if($_SESSION["account"] == "Venditore"): ?>

                    <!--immagine marchio-->

                    <img id="immagine_corrente" src="<?php echo LOG_DIR.$dati['username_venditore'].'.png'; ?>" alt="" />
                    <label for="imgmarchio">Inserisci nuova immagine marchio con estensione .png:</label>
                    <input type="file" id="imgmarchio" name="imgmarchio" accept=".png"/>
                    
                    
                    <label for="marchio">Nome del marchio:</label>
                    <input type="text" id="marchio" name="marchio" placeholder="Caratteri amessi: A-z, 0-9, 'space'" value="<?php echo $dati["nome_marchio"];?>" required>

                    <label for="codice_bancario">Codice Bancario:</label>
                    <input type="text" id="codice_bancario" name="codice_bancario" placeholder="Caratteri amessi: A-z, 0-9" value=<?php echo $dati["codice_bancario"]?> required>

                <?php endif ?>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="prova@comfort.zone" value=<?php echo $dati["email_".strtolower($_SESSION["account"])];?> required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <?php if($_SESSION["account"] == "Utente"): ?>
                    <label for="pagamento">Metodo di pagamento:</label>
                    <input type="text" id="pagamento" name="pagamento" placeholder="Caratteri amessi: A-z, 0-9, 'space'" value=<?php echo $dati["metodo_pagamento"]?> required>
                <?php endif ?>


                
                <input type="submit" value="Conferma">
            </form>
