<?php 
use application\modulos\modelosRelatorios\Estatisticas;



include_once 'application/modulos/modelosRelatorios/Estatisticas.php';


$est=new Estatisticas();
$est->getDadosMaisVisitantes();

?>
