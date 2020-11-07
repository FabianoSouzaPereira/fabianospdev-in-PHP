<?php

use mobile\modulos\Usuario;
use mobile\modulos\dao\Connection;

require 'init.php';
include_once '../mobile/modulos/Usuario.php';
include_once '../mobile/modulos/dao/Connection.php'; 


$id=null;
if(isset($_GET['id'])){
    $id=$_GET['id'];   
    $uid=$_SESSION['uid']; //usuario logado
    $usuuid=$_GET['usuuid']; //usuario para habilitar
    try{
        $query="Update celulasdb.usuarios "
                ."SET usuStatus = :usuStatus "
                ."WHERE usuId = $id "
                ."AND usuuid IN (SELECT permissao FROM tabela_acesso_usuarios  where usuuid >='$uid' );"; 
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        $stmt->bindValue(':usuStatus' , '1');
        $stmt->execute();
 
        header( "Location: index.php?pag=site_view_userReadView" );
        exit();
            
        
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    
}
