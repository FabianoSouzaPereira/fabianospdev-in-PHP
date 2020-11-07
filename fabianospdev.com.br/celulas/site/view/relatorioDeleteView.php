<?php

use application\modulos\modelosRelatorios\Relatorio;

require 'init.php';
include_once 'application/modulos/modelosRelatorios/Relatorio.php';

$relatorio= new Relatorio();
if(isset($_GET['ar'])){
    $ac=$_GET['ar'];
    $id=$_GET['id'];
    
    $relatorio-> pastorDeleteByid($id);
}


header( "Location: index.php?pag=site_view_readRelatorioView" );
exit(); 
?>
