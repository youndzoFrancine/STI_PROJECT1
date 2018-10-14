<?php

session_start();
include_once 'config.php';

if (!isset($_SESSION["user"])) {
    header("location: " . __APP_URL . "/login.php");
}

?>