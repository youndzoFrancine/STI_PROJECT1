<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define( '__SITE_PATH', realpath( dirname( __FILE__ ) ) );
define( '__DB_NAME', 'sti.sqlite' );

$defaultDir = 'inbox';