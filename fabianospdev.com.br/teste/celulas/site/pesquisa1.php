<?php
if (! isset($_SESSION)) {
    session_start();
}
require '../init.php';
include_once '../Ajax_config.php';
include_once '../application/functions/Pesquisa.php';

header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true );

if(isset($_GET['estado']) && isset($_GET['cidade']) && isset($_GET['igreja']) && isset($_GET['celula'])){
    $_SESSION['idestado']=$_GET['idestado'];
    $_SESSION['idcidade']=$_GET['idcidade'];
    $_SESSION['idigreja']=$_GET['idigreja'];
    $_SESSION['idcelula']=$_GET['idcelula'];
    
    $_SESSION['estado']=$_GET['estado'];
    $_SESSION['cidade']=$_GET['cidade'];
    $_SESSION['igreja']=$_GET['igreja'];
    $_SESSION['celula']=$_GET['celula'];
}


?>

