<?php

use modulos\Celula;

require 'init.php';
include_once 'modulos/Celula.php';
include_once '../application/functions/Validador.php';
include_once '../js/functions.js';

$celula= new Celula();
if(isset($_GET['ac'])){
    $ac=$_GET['ac'];
    $id=$_GET['id'];
    
    $celula->deleteById($id);
}


header( "Location: index.php?pag=site_view_celulasApagadasView" );
exit();
?>
