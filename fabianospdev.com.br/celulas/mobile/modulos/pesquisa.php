<?php 

use application\modulos\dao\Connection;


include_once '../../Ajax_config.php';
include_once '../../mobile/functions/Pesquisa.php';
include_once '../../mobile/modulos/dao/Connection.php'; 

header( 'Cache-Control: no-cache' );
header( 'Content-type: mobile/json; charset="utf-8"', true );


$uf=null;
$nome= null;
$cidade=null;
$igrejas=null;
if(isset($_GET['estados'])){
    $uf=$_GET['estados'];   
    $cidades = array();
    try{
        $query="SELECT uf, nome FROM tb_cidades WHERE uf = '$uf';";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($ret=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                Foreach($ret as $raw ){
                    $uf= $raw['uf']; $nome= $raw['nome'];
                    $cidades[]= array( 'cidade'=>$nome, 'nome'=>$nome, );
                }
            }
            
            echo( json_encode($cidades) );
            $stmt=null;
            exit();
            
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    
}


if(isset($_GET['cidades'])){
    $cidade=$_GET['cidades'];
    $igrejas= array();
    
    try {
        $query="SELECT chuId,chuIgreja FROM igrejas WHERE chuCidade = '$cidade';";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($ret=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                Foreach($ret as $raw ){
                    $id=$raw['chuId']; $igreja= $raw['chuIgreja'];
                    $igrejas[]= array( 'id'=>$id,'igreja'=>$igreja, );
                }
            }
            
            echo( json_encode($igrejas) );
            $stmt=null;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    
}

if(isset($_GET['igrejas'])){
    $igreja=$_GET['igrejas'];
    $celulas= array();
    
    try {
        $id=$_SESSION['usuId'];
        $tipo=$_SESSION['tipo'];
        $query="SELECT "
                    ."celId,"
                    ."celCelula,"
                    ."celIgrejaId,"
                    ."celStatus "  
                ."FROM "
                        ."celulasdb.celulas "
                ."GROUP BY "
                        ."celId "
                ."HAVING "
                        ."celId IN(SELECT celulas FROM celulasdb.tabelasacessos WHERE usuario= $id  or level >='$tipo' ) "
                        ."AND celIgrejaId = '$igreja'"
                        ."AND celStatus = 1 "
                ."ORDER BY "
                        ."celId "
                ."LIMIT 1000;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($ret=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                Foreach($ret as $raw ){
                    $id=$raw['celId']; $celula= $raw['celCelula'];
                    $celulas[]= array( 'id'=>$id,'celula'=>$celula, );
                }
            }
            
            echo( json_encode($celulas) );
            $stmt=null;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    
}

?>
