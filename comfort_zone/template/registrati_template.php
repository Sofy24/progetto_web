
            <?php if(isset($_GET["error"])):?>
                <div class="text-center panel panel-danger">
                    <div class="panel-heading">Errore</div>
                    <div class="panel-body"><?php echo $_GET["error"]; ?> </div>
                </div>
            <?php endif; ?>

            <form class="flex-container" name="registrazione" action="gestione_registrazione.php" method="POST" enctype="multipart/form-data">
                <div class="container-login">
                    <fieldset>
                        <legend>Registrati Come:</legend>
                        <div>
                            <input type="radio" id="utente" name="account" value="Utente" checked >
                            <label for="utente">Utente</label>
                        </div>
                        <div>
                            <input type="radio" id="venditore" name="account" value="Venditore" >
                            <label for="venditore">Venditore</label>
                        </div>
                        <div>
                            <input type="radio" id="fattorino" name="account" value="Fattorino" >
                            <label for="fattorino">Fattorino</label>
                        </div>
                    </fieldset>
                </div>

                <!--immagine marchio-->
                <label for="imgmarchio">Inserisci immagine marchio con estensione .png:</label>
                <input type="file" id="imgmarchio" name="imgmarchio" accept=".png" />
                    


                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Caratteri amessi: A-z" >

                <label for="nome_marchio">Nome marchio:</label>
                <input type="text" id="nome_marchio" name="nome_marchio" placeholder="Caratteri amessi: A-z, 0-9, 'space'" >

                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" name="cognome" placeholder="Caratteri amessi: A-z" >

                <label for="pagamento">Metodo di pagamento:</label>
                <input type="text" id="pagamento" name="pagamento" placeholder="Caratteri amessi: A-z, 0-9, 'space'" >

                <label for="bankcode">Codice bancario:</label>
                <input type="text" id="bankcode" name="bankcode" placeholder="Caratteri amessi: A-z, 0-9" >

                <label for="user">Username:</label>
                <input type="text" id="user" name="user" placeholder="Caratteri amessi: A-z, '_'" required>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="prova@comfort.zone" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Registrati">
            </form>


