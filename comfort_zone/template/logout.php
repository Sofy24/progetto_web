<?php
require_once "../bootstrap.php";
$dbh->notify("Hai effettuato il logout alle ".date("H:i:s")." del ".date("d/m/Y").".", "<a href='index.php'>Comfort Zone</a>", $_SESSION["user"]);
$_SESSION["isonline"] = 0;
unset($_SESSION["user"]);
unset($_SESSION["account"]);
session_destroy();

header("Location:../index.php");

?>