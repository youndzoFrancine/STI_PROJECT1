<?php

session_start();
if (!isset($_SESSION["Authenticated"])) {
    header("location: http://sti.lozann.ch/login.php");
}

?>