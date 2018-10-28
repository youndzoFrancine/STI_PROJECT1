<?php

/**
 * @file        auth.php
 *
 * @description This file checks if the user has a valid session opened. If he has not, the user
 *              is redirected to the login page. All files of the application have this include
 *              at the beginning of the page except the login page.
 *
 * @version     PHP version 5.5.9
 *
 * @author      Francine Vanessa Youndzo Kengne
 * @author      Cyril de Bourgues
 * @author      Nuno Miguel Cerca Abrantes Sivla
 */
?>

<?php

session_start();
include_once 'config.php';

if (!isset($_SESSION["user"])) {
    header("location: " . __APP_URL . "/login.php");
}

?>