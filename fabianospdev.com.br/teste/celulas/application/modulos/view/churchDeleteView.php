<?php
use modulos\Igreja;

require 'init.php';
include_once 'modulos/Igreja.php';


$igr = new Igreja();

if(isset($_GET['ac'])){
    $id=$_GET['id'];
    $igr->deleteByid($id);
    
    header( "Location: index.php?pag=modulos_view_churchReadView" );
    exit();
}

?>