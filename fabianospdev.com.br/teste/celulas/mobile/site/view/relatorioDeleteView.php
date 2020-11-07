<?php

use mobile\modulos\modelosRelatorios\Relatorio;

require 'init.php';
include_once '../mobile/modulos/modelosRelatorios/Relatorio.php';

$relatorio= new Relatorio();
$logtipo=null;
$logtipo=$_SESSION['tipo'];
if(isset($_GET['ar'])){
    $ac=$_GET['ar'];
    $id=$_GET['id'];
    switch ($logtipo) {
                case 1: $relatorio->adminRead($id);
                   break;
                case 2: $relatorio->coordenadorRead($id);
                   break;
                case 3: $relatorio->pastorDeleteByid($id);
                   break;
                case 4: $relatorio->liderDeleteByid($id);
                   break;
                case 5: $relatorio->colaboradorRead($id);
                   break;
                case 6: $relatorio->comumRead($id);
                   break;
                case 7: '0';
                   break;
                default:
                    ;
                break;
            } 
}


header( "Location: index.php?pag=site_view_readRelatorioView" );
exit(); 
?>
