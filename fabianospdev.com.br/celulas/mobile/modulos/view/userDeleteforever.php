<?php

use modulos\Usuario;

require 'init.php';
include_once 'Usuario.php';


$usu = new Usuario();
if (isset($_GET['au'])){
    $id=$_GET['id'];
    
    $usu->deletebyid($id);
    
    header( "Location: index.php?pag=modulos_view_userDeletedView" );
    exit();
    
}

?>
