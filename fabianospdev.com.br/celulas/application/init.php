<?php

if (! isset($_SESSION)) {
    session_start();
}

if ($_SESSION['login'] == false) {
    require 'application/modulos/dao/Login.php';
}

ini_set('display_errors', true);
@ini_set("log_errors", 1);
error_reporting(E_ALL & ~E_DEPRECATED & E_STRICT);

date_default_timezone_set('America/Sao_Paulo');

include_once 'application/modulos/dao/Connection.php';
require_once 'functions.php';


?>