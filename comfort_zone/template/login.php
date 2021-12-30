

            <?php if(isset($_GET["error"])):?>
                <div class="text-center panel panel-danger">
                    <div class="panel-heading">Errore</div>
                    <div class="panel-body"><?php echo $_GET["error"]; ?> </div>
                </div>
            <?php endif; ?>
            <form name="accesso" action="template/controllo_accesso.php" method="POST">

                <div class="container-login">
                    <fieldset >
                        <legend>Accedi Come:</legend>
                        <div>
                            <input type="radio" id="utente" name="account" value="Utente" required>
                            <label for="utente">Utente</label>
                        </div>
                        <div>
                            <input type="radio" id="venditore" name="account" value="Venditore" required>
                            <label for="venditore">Venditore</label>
                        </div>
                        <div>
                            <input type="radio" id="fattorino" name="account" value="Fattorino" required>
                            <label for="fattorino">Fattorino</label>
                        </div>
                    </fieldset>

                    <label for="user">Username:</label>
                    <input type="text" id="user" name="user" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <input type="submit" value="Accedi">
            </form>
