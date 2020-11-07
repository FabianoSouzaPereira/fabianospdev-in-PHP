<?php
if(!isset($_SESSION)) {
    session_start();
}

ini_set('display_errors', true);
@ini_set("log_errors", 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

require_once 'functions.php';

?>