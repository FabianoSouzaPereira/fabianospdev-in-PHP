<?php 
use modulos\Igreja;
use application\functions\Validador;

require 'init.php';
include_once 'application/modulos/Igreja.php';

$igr = new Igreja();
	$logtipo=null;
	$logtipo=$_SESSION['tipo'];
	
//TODO delete

?>