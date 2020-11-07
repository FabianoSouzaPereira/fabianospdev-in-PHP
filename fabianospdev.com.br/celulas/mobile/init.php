<?php
if (! isset($_SESSION)) {
    session_start();
}

ini_set('display_errors', true);
@ini_set("log_errors", 1);

/* O ~ desabilita o erros se em php.ini display_errors=Off */
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

date_default_timezone_set('America/Sao_Paulo');

include_once 'modulos/dao/Connection.php';
require_once 'functions.php';

?>