<?php unset($_POST["nome"])?>
<div class="thank-you">
    <h2><?php echo $_SESSION["user"] ;?>, grazie per il tuo acquisto!</h2>
    <a href="index.php">Pagina principale</a>
    <a href="ordini.php?username=<?php echo $_SESSION["user"] ;?>">Vai ai tuoi ordini</a>
</div>