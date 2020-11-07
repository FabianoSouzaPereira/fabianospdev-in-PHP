<?php
use modulos\Igreja;

require 'init.php';
include_once 'application/modulos/Igreja.php';

$igr = new Igreja();
	$logtipo=null;
	$logtipo=$_SESSION['tipo'];

if(isset($_GET['ac'])){
    $id=$_GET['id'];
            switch ($logtipo) {
                case 1: $igr->adminRead();
                   break;
                case 2: $igr->coordenadorRead();
                   break;
                case 3: $igr->pastorDeleteByid($id);
                   break;
                case 4: $igr->liderDeleteByid($id);
                   break;
                case 5: $igr->colaboradorDeleteByid($id);
                   break;
                case 6: $igr->comumDeleteByid($id);
                   break;
                case 7: '0';
                   break;
                default:
                    ;
                break;
            }
    
    header( "Location: index.php?pag=site_view_churchReadView" );
    exit();
}

?>