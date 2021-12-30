<?php
session_start();
define("PROD_DIR", "./upload/product/");
define("LOG_DIR", "./upload/marche/");
require_once("utils/functions.php");
require_once("db/database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "comfort_zone",3307);
?>