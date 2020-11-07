<?php ob_start();

if (! isset($_SESSION)) {
    session_start();
}

if( !(isset($_SESSION['login']) && $_SESSION['login'] == true) ){
    header('location: loginView.php');
    exit();
}
require 'init.php';
require_once 'modulos/dao/Connection.php';


$fullpath = "";
$ret = array();

if (strpos($_SERVER['REQUEST_URI'], "=") != 0) {

    $url = Urlnow();
} else {
    $url = 'celulas.fabianospdev.com.br/application/index.php';
}
$ret = viewpage($url);

if ((isset($ret) !== false) && $ret !== "") {
    $fullpath = $ret[0] . '/' . $ret[1] . '/' . $ret[2] . '.php';
} else {
    $fullpath = "begin.php";
}

include_once 'indexView.php';

?>