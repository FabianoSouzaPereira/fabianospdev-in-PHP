<?php

use modulos\Celula;

require 'init.php';
include_once 'modulos/Celula.php';


$celula= new Celula();
if(isset($_GET['ac'])){
    $ac=$_GET['ac'];
    $id=$_GET['id'];
    
    $celula->deletCelulaPen($id);
}


header( "Location: index.php?pag=site_view_celulasReadView" );
exit(); 
?>