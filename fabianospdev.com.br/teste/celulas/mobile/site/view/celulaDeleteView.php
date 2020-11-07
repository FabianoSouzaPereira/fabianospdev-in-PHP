<?php

use mobile\modulos\Celula;

require 'init.php';
include_once '../mobile/modulos/Celula.php';

$celula= new Celula();
if(isset($_GET['ac'])){
    $ac=$_GET['ac'];
    $id=$_GET['id'];
    
    $celula->pastorDeletCelulaPen($id);
}


header( "Location: index.php?pag=site_view_celulasReadView" );
exit(); 
?>