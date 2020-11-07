<?php
use mobile\modulos\Igreja;

require 'init.php';
include_once '../mobile/modulos/Igreja.php';

$igr = new Igreja();

if(isset($_GET['ac'])){
    $id=$_GET['id'];
    $igr->pastorDeleteByid($id);
    
    header( "Location: index.php?pag=site_view_churchReadView" );
    exit();
}

?>