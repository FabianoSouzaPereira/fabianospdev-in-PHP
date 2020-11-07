<?php 
ob_start();
//error_reporting(0);
if(!isset($_SESSION)) {
    session_start();
}

date_default_timezone_set("Etc/GMT+3");

//diretorios a serem definidos no include patch
$mincludes = array( "../modulos","../../js" ,"../application/bootstrap/js/bootstrap/js", get_include_path() );

//monta string com os diretrios par o include path
$vincludes = implode( PATH_SEPARATOR, $mincludes );

//seta os novos diretorios que os arquivos de include farão uma busca
set_include_path( $vincludes );

include 'init.php';

?>