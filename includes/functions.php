<?php

function isAdmin() {

    if (!isset($_SESSION['user'])) {
        return false;
    }

    return (($_SESSION['user']['isAdmin'] == 1) ? true : false);
}

function truncate($text, $chars = 25) {

    if (strlen($text) <= $chars) {
        return $text;
    }

    $text = $text." ";
    $text = substr($text,0,$chars);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text."...";

    return $text;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}