<?php

use modulos\Celula;

require 'init.php';
include_once 'application/modulos/Celula.php';

$celula= new Celula();
if(isset($_GET['ac'])){
    $ac=$_GET['ac'];
    $id=$_GET['id'];
    
    $celula->pastorDeleteById($id);
}


header( "Location: index.php?pag=site_view_celulasApagadasView" );
exit();
?>
