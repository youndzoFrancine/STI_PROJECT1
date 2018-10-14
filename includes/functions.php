<?php

function isAdmin() {

    if (!isset($_SESSION['user'])) {
        return false;
    }


    return (($_SESSION['user']['isAdmin'] == 1) ? true : false);
}