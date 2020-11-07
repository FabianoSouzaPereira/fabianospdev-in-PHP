<?php

use application\modulos\dao\Connection;


include_once '../../Ajax_config.php';
include_once '../../application/functions/Pesquisa.php';
include_once '../../application/modulos/dao/Connection.php';

header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true );

$estado= NULL;
$cidade= NULL;
$id= NULL;
$tipo= NULL;
$uid= NULL;
if(isset($_GET['estado'])){
    $estado=$_GET['estado']; 
    $cidade=$_GET['cidade'];
    $id=$_SESSION['id'];
    $tipo=$_SESSION['tipo'];
    $uid=$_SESSION['uid'];
    try {
    $query="SELECT a.celId,"
        ."a.celuuid,"
        ."a.celCelula,"
        ."a.celRede,"
        ."a.celLider,"
        ."a.celViceLider,"
        ."a.celSecretario,"
        ."a.celAnfitriao,"
        ."a.celColaborador,"
        ."a.celDia,"
        ."a.celHora,"
        ."a.celData,"
        ."a.celLevel,"
        ."a.celIgrejaId,"
        ."a.celStatus,"
        ."b.chuId,"
        ."b.chuIgreja,"
        ."b.chuEstado,"
        ."b.chuCidade,"
        ."b.chuStatus "
        ."FROM celulasdb.celulas as a "
        ."INNER JOIN celulasdb.igrejas as b "
        ."ON b.chuId = a.celIgrejaId "
        ."GROUP BY a.celCelula  "
        ."HAVING a.celStatus = '1'  AND a.celIgrejaId IN(SELECT celulas FROM celulasdb.tabelasacessos WHERE usuario = '$id') "
        ."OR cellevel >='$tipo' AND a.celIgrejaId IN (SELECT igreja FROM celulasdb.tabela_acesso_igreja WHERE usuario='$id' ) "
        ."AND b.chuStatus = '1' "
        ."ORDER BY celId "
        ."LIMIT 1001;";

        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($ret=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                Foreach($ret as $raw ){
                    $id=$raw['celID']; $celula= $raw['celCelula'];
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
