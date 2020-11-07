<?php

if (! isset($_SESSION)) {
    session_start();
}

use application\modulos\dao\Connection;

include_once '../../Ajax_config.php';
include_once '../../application/modulos/dao/Connection.php';

header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true); 


//$idusuario= json_decode($_GET['idusuario'],true);


if(isset($_GET['idusuario'])){
    
	$id=$_GET['idusuario']; // id do usuario
  	$celula=$_GET['idcelula'];  
    $tipo=$_SESSION['usutipofrompesp'];
    $igreja=$_SESSION['igrejaId'];
    
    try { 
     $stmt = $conn = new Connection();
           
       $query2="INSERT INTO tabelasacessos
                (usuario,igreja,celulas,relatorios,level,status)
                values(:usuario,:igreja,:celulas,:relatorios,:level,:status);";
      $stmt=$conn->getInstance()->prepare($query2);
      $stmt->bindValue(':usuario',$id, PDO::PARAM_STR);
      $stmt->bindValue(':igreja',$igreja, PDO::PARAM_STR); //veio do sha1
      $stmt->bindValue(':celulas',$celula, PDO::PARAM_STR);
      $stmt->bindValue(':relatorios',$celula, PDO::PARAM_STR);
      $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
      $stmt->bindValue(':status','1', PDO::PARAM_STR);
      $stmt->execute(); 
     
      $reposta[]=array('celula'=>$celula,'id'=>$id,);
      $stmt=null;
       
     echo( json_encode($reposta) );    
      exit();
      
       }catch ( PDOException $e ) {
        throw $e;
         exit();
     }
    
}


?>