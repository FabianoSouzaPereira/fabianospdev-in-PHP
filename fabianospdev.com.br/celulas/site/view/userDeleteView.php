<?php

use modulos\Usuario;

require 'init.php';
include_once 'application/modulos/Usuario.php';

$usu = new Usuario();
if (isset($_GET['au'])){
    $id=$_GET['id'];
    
    $usu->pastorDeletePendente($id);
    
    header( "Location: index.php?pag=site_view_userReadView" );
    exit();
    
}

?>
