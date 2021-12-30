<?php
    require_once 'bootstrap.php';
    if(isset($_POST['function']) && $_POST["username"] == $_SESSION["user"]){
        if ($_POST['function'] == "addToCart") {$dbh->addProductToCart($_POST['id'], $_POST['username']); }
        if ($_POST['function'] == "deleteFromCart") {$dbh->deleteProductFromCart($_POST['id'], $_POST['username']); }
        if ($_POST['function'] == "removeFromCart") {$dbh->removeProductFromCart($_POST['id'], $_POST['username']); }
        if ($_POST['function'] == "exeDeliver") {$dbh->deliverOrder($_POST['id']); }
        if ($_POST['function'] == "requestRestock") {$dbh->requestRestock($_POST['id'], $_POST['username']); }
    }

?>