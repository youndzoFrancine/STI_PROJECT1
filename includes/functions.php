<?php

/**
 * @file        copyright.php
 *
 * @description This file has the functions used in the application.
 *
 * @version     PHP version 5.5.9
 *
 * @author      Francine Vanessa Youndzo Kengne
 * @author      Cyril de Bourgues
 * @author      Nuno Miguel Cerca Abrantes Sivla
 */
?>

<?php

/**
 * Verify if the user is an admin or not.
 * @return bool
 */
function isAdmin() {

    if (!isset($_SESSION['user'])) {
        return false;
    }

    return (($_SESSION['user']['isAdmin'] == 1) ? true : false);
}

/**
 * This function takes a string as parameter. With 'trim' it removes the spaces at the beginning and at the end
 * of the string. Then with 'stripslashes' it removes the backslashes in a string. If two backslashes are together
 * it only removes one. With 'htmlspecialchars' it converts the special characters in HTML entities.
 * @param $data
 * @return string
 */
function test_input($data) {

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}