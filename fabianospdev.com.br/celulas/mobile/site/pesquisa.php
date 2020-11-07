<?php 

use mobile\modulos\dao\Connection;

require '../init.php';
include_once '../Ajax_config.php';
include_once '../functions/Pesquisa.php';
//include_once '../mobile/modulos/dao/Connection.php'; 

header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true );


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
            exit();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    
}

if(isset($_GET['nome'])){
    $id=$_GET['id'];
    $nome=$_GET['nome'];
    $usuId=null;
    
     try{
          if ($_SESSION['uid']){

        $uid=$_SESSION['uid'];
        $query= "Select usuId,usuuid,usuEmail,usuNome,usuSobreNome,usuSenha,usuTentativa,"
                   ."usuBloqueado,usuData,usuTipo,usuAcesso,usuStatus "
                 ."FROM usuarios "
                 ."GROUP BY usuId "
                 ."HAVING usuId = '$id' "
                 ."AND usuuid IN( SELECT permissao  FROM tabela_acesso_usuarios "
                 ."WHERE usuuid =  '$uid'  And usuStatus = 1 )"
                 ."ORDER BY usuId "
                 ."LIMIT 1;";
           
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($ret=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                  Foreach($ret as $raw ){
                    $_SESSION['idfrompesq'] = $usuId= $raw['usuId'];     //sessions vao direto para
                    $_SESSION['nomefrompesq'] = $nome= $raw['usuNome'];  //associausuario.php
                    $_SESSION['usuidfrompesp'] = $raw['usuuid'];
                    $_SESSION['usutipofrompesp'] = $raw['usuTipo'];
                    $usuarios[]= array( 'id'=>$usuId,'nome'=>$nome, );
                  }
               }
                   if(!empty($usuId)){
                       echo( json_encode($usuarios) );
                   }else{
                       $usuarios[]=array('id'=>'0','nome'=>"Usuario Não Associável");
                       echo(json_encode( $usuarios ));
                   }
            $stmt=null;
            
            }
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
        $id=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
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
                ."a.celEndereco,"
                ."a.celBairro," 
                ."a.celCidade," 
                ."a.celEstado,"
                ."a.celCep,"
                ."a.celPais," 
                ."a.celData,"
                ."a.celLevel,"
                ."a.celIgrejaId,"
                ."a.celuserId,"
                ."a.celStatus,"
                    ."b.chuId,"
                    ."b.chuIgreja,"
                    ."b.chuEstado,"
                    ."b.chuCidade,"
                    ."b.chuStatus "
            ."FROM celulas as a "
            ."INNER JOIN igrejas as b "
                ."ON b.chuId = a.celIgrejaId "
            ."GROUP BY a.celCelula  "
            ."HAVING a.celStatus = '1' AND b.chuStatus = '1' "
            ."AND a.celId IN(SELECT celulas FROM tabelasacessos WHERE status = '1' AND usuario = '$id') " 
            ."AND a.celIgrejaId IN (SELECT igreja FROM tabela_acesso_igreja WHERE status = '1' AND usuario='$id' ) "           
            ."ORDER BY celId "
            ."LIMIT 1001;";
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
        exit;
    }
    
}

?>
