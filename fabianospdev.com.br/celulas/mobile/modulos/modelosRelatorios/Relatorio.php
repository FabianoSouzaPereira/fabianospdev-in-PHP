<?php
namespace mobile\modulos\modelosRelatorios;

use mobile\modulos\Crud;
use mobile\modulos\dao\Connection;
use Exception;
use PDO;
use PDOException;
use mobile\functions\Validador;
//necessário ternario porque o caminho de application e site são diferentes;
file_exists('../mobile/modulos/dao/Login.php')?include_once '../mobile/modulos/dao/Login.php':include_once 'mobile/modulos/dao/Login.php';
file_exists('../mobile/functions/Validador.php')?include_once '../mobile/functions/Validador.php':include_once 'mobile/functions/Validador.php';
file_exists('../mobile/modulos/Crud.php')?include_once '../mobile/modulos/Crud.php':include_once 'mobile/modulos/Crud.php';

/**
 *
 * @author fabiano
 *        
 */
class Relatorio
{
 public $insert=null;
    public $update=null;
    public $delete=null;
    private $id=null;
    private $uid=null;
    private $base=null;
    private $membros=null;
    private $visitantes=null;
    private $criancas=null;
    private $adultos=null;
    private $jovens=null;
    private $estudo=null;
    private $quebragelo=null;
    private $lanche=null;
    private $aceitou=null;
    private $reconcilhacao=null;
    private $testemunho=null;
    private $igreja=null;
    private $celula=null;
    private $usuario=null;
    private $total=null;
    private $data=null;
    private $dados=null;
    private $dadosWhole=null;
    private $lastId=null;
    

    public function __construct(){}
    function __destruct(){}
    
    public function deletePendente($id)
    {}
    
    public function readWholeByid($id)
    {}
    
    public function read()
    {
        
    try{
        $usuId=$_SESSION['usuId'];
        $tipo=$_SESSION['tipo'];
        $query="SELECT a.chuId,"
                ."a.chuuid,a.chuIgreja,a.chuEndereco,a.chuBairro,a.chuCidade,a.chuEstado,a.chuPais,a.chuCep,"
                ."a.chuData,a.chuTelefone,a.chuEmail,a.chuRegiao,a.chuLevel,a.chuStatus,"
                    ."b.relAid, b.relUid, b.relBase, b.relMembros, b.relVisitantes,b.relCriancas, b.relAdultos,"
                    ."b.relJovens, b.relEstudo, b.relQuebragelo, b.relLanche, b.relAceitou, b.relReconcilhacao," 
                    ."b.relTestemunho, b.relCelula, b.relIgreja, b.relUsuario,b.relData, b.relStatus,"
                        ."c.`celId`, c.`celuuid`, c.`celCelula`, c.`celRede`, c.`celLider`, c.`celViceLider`,"
                        ."c.`celSecretario`, c.`celAnfitriao`, c.`celColaborador`,c.`celDia`, c.`celHora`, c.`celData`,"
                        ."c.`celuserId`, c.`celIgrejaId`, c.`celLevel`, c.`celStatus` "
                ."FROM celulasdb.igrejas as a "
                    ."INNER JOIN celulasdb.relatoriosa as b "
                    ."ON b.relIgreja = a.chuId "
                    ."INNER JOIN celulasdb.celulas as c "
                    ."ON b.relCelula = c.celId "
                ."GROUP BY a.chuId "
                ."HAVING a.chuStatus = '1' "
                ."AND a.chuid IN(SELECT igreja FROM celulasdb.tabela_acesso_igreja WHERE usuario = '$usuId' OR chuLevel >= '$tipo') "
                ."AND c.celStatus = '1' "
                ."ORDER BY a.chuIgreja "
                ."LIMIT 1001;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                        while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    public function deleteByid($id)
    {
         try{
            $query="DELETE FROM relatoriosa WHERE relAid = $id;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }else {
                echo "<div style='margin-top:100px;' class='alert-success'>Erro: Não foi possível apagar os dados do banco de dados</div>";
            }
            $stmt = null;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    public function deleteAll()
    {}
    
    public function insert()
    {
        $stmt = $conn = new Connection();
        try {
            $stmt=$conn->getInstance()->beginTransaction(); 
            $query="INSERT INTO relatoriosa("
                    ."relAid,"
                    ."relUid,"
                    ."relBase,"
                    ."relMembros,"
                    ."relVisitantes,"
                    ."relCriancas," 
                    ."relAdultos," 
                    ."relJovens," 
                    ."relEstudo," 
                    ."relQuebragelo," 
                    ."relLanche," 
                    ."relAceitou," 
                    ."relReconcilhacao,"
                    ."relTestemunho,"
                    ."relCelula,"
                    ."relIgreja,"
                    ."relUsuario,"
                    ."relData,"
                    ."relStatus) "
                      ."VALUES(:relAid,"
                        .":relUid,"
                        .":relBase,"                        
                        .":relMembros,"
                        .":relVisitantes,"
                        .":relCriancas," 
                        .":relAdultos," 
                        .":relJovens," 
                        .":relEstudo," 
                        .":relQuebragelo," 
                        .":relLanche," 
                        .":relAceitou," 
                        .":relReconcilhacao,"
                        .":relTestemunho,"
                        .":relCelula,"
                        .":relIgreja,"
                        .":relUsuario,"
                        .":relData,"
                        .":relStatus)";
            
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':relAid', $this->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':relUid', $this->getUid(), PDO::PARAM_STR);
            $stmt->bindValue(':relBase', $this->getBase(), PDO::PARAM_INT);
            $stmt->bindValue(':relMembros', $this->getMembros(), PDO::PARAM_INT);
            $stmt->bindValue(':relVisitantes', $this->getVisitantes(), PDO::PARAM_INT);
            $stmt->bindValue(':relCriancas', $this->getCriancas(), PDO::PARAM_INT);
            $stmt->bindValue(':relAdultos', $this->getAdultos(), PDO::PARAM_INT);
            $stmt->bindValue(':relJovens', $this->getJovens(), PDO::PARAM_INT);
            $stmt->bindValue(':relEstudo', $this->getEstudo(), PDO::PARAM_STR);
            $stmt->bindValue(':relQuebragelo', $this->getQuebragelo(), PDO::PARAM_STR);
            $stmt->bindValue(':relLanche', $this->getLanche(), PDO::PARAM_STR);
            $stmt->bindValue(':relAceitou', $this->getAceitou(), PDO::PARAM_STR);
            $stmt->bindValue(':relReconcilhacao', $this->getReconcilhacao(), PDO::PARAM_STR);
            $stmt->bindValue(':relTestemunho', $this->getTestemunho(), PDO::PARAM_STR);
            $stmt->bindValue(':relCelula', $this->getCelula(), PDO::PARAM_INT);
            $stmt->bindValue(':relIgreja', $this->getIgreja(), PDO::PARAM_INT);
            $stmt->bindValue(':relUsuario', $this->getUsuario(), PDO::PARAM_INT);
            $stmt->bindValue(':relData', $this->getData(), PDO::PARAM_STR);
            $stmt->bindValue(':relStatus' ,'1', PDO::PARAM_STR);
            $stmt->execute();
            
            // Make the changes to the database permanent
            $stmt=$conn->getInstance()->commit();
            $stmt=null;
        }catch ( PDOException $e ) {
            // Failed to insert the order into the database so we rollback any changes
            $conn::$instance->rollBack();
            throw $e;
        }
    }
    
    public function update()
    {}
    
    public function lastId()
    {
                try{
        $query="SELECT MAX(relAid) FROM celulasdb.relatoriosa;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                $id= $raw[0];
                $this->setLastId($id);
            }
        }else {
            echo "Erro ";
        }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    public function readById($id)
    {}
    
    public function readDeleteds()
    {}
    
                /** PASTOR */    
    
    public function pastorReadDeleteds()
    {}

    public function pastorRead()
    {
                
    try{
        $tipo=$_SESSION['tipo'];
        $id=$_SESSION['id'];
 
        $query="SELECT a.`celId`,a.`celCelula`,a.`celStatus`,b.`relAid`, b.`relUid`, b.`relBase`, b.`relMembros`, b.`relVisitantes`,"
                    ."b.`relCriancas`, b.`relAdultos`, b.`relJovens`, b.`relEstudo`, b.`relQuebragelo`,"
                    ."b.`relLanche`, b.`relAceitou`, b.`relReconcilhacao`, b.`relTestemunho`, b.`relCelula`,"
                    ."b.`relIgreja`, b.`relUsuario`, b.`relData`,b.`relStatus` "
                ."FROM celulas as a "
                    ."INNER JOIN relatoriosa b "
                    ."ON  a.`celId` = b.`relCelula` "
                ."GROUP BY b.relAid "
                ."HAVING  b.relstatus = '1' AND a.celstatus = '1' "
                ."AND celId IN (SELECT celulas FROM tabelasacessos where usuario = '$id') "
                ."LIMIT 1000;";

        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                        while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }

    public function pastorInsert()
    {
        $stmt = $conn = new Connection();
        try {
            $stmt=$conn->getInstance()->beginTransaction(); 
            $query="INSERT INTO relatoriosa("
                    ."relAid,"
                    ."relUid,"
                    ."relBase,"
                    ."relMembros,"
                    ."relVisitantes,"
                    ."relCriancas," 
                    ."relAdultos," 
                    ."relJovens," 
                    ."relEstudo," 
                    ."relQuebragelo," 
                    ."relLanche," 
                    ."relAceitou," 
                    ."relReconcilhacao,"
                    ."relTestemunho,"
                    ."relCelula,"
                    ."relIgreja,"
                    ."relUsuario,"
                    ."relTotal,"
                    ."relData,"
                    ."relStatus) "
                      ."VALUES(:relAid,"
                        .":relUid,"
                        .":relBase,"                        
                        .":relMembros,"
                        .":relVisitantes,"
                        .":relCriancas," 
                        .":relAdultos," 
                        .":relJovens," 
                        .":relEstudo," 
                        .":relQuebragelo," 
                        .":relLanche," 
                        .":relAceitou," 
                        .":relReconcilhacao,"
                        .":relTestemunho,"
                        .":relCelula,"
                        .":relIgreja,"
                        .":relUsuario,"
                        .":relTotal,"
                        .":relData,"
                        .":relStatus)";
            
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':relAid', $this->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':relUid', $this->getUid(), PDO::PARAM_STR);
            $stmt->bindValue(':relBase', $this->getBase(), PDO::PARAM_INT);
            $stmt->bindValue(':relMembros', $this->getMembros(), PDO::PARAM_INT);
            $stmt->bindValue(':relVisitantes', $this->getVisitantes(), PDO::PARAM_INT);
            $stmt->bindValue(':relCriancas', $this->getCriancas(), PDO::PARAM_INT);
            $stmt->bindValue(':relAdultos', $this->getAdultos(), PDO::PARAM_INT);
            $stmt->bindValue(':relJovens', $this->getJovens(), PDO::PARAM_INT);
            $stmt->bindValue(':relEstudo', $this->getEstudo(), PDO::PARAM_STR);
            $stmt->bindValue(':relQuebragelo', $this->getQuebragelo(), PDO::PARAM_STR);
            $stmt->bindValue(':relLanche', $this->getLanche(), PDO::PARAM_STR);
            $stmt->bindValue(':relAceitou', $this->getAceitou(), PDO::PARAM_STR);
            $stmt->bindValue(':relReconcilhacao', $this->getReconcilhacao(), PDO::PARAM_STR);
            $stmt->bindValue(':relTestemunho', $this->getTestemunho(), PDO::PARAM_STR);
            $stmt->bindValue(':relCelula', $this->getCelula(), PDO::PARAM_INT);
            $stmt->bindValue(':relIgreja', $this->getIgreja(), PDO::PARAM_INT);
            $stmt->bindValue(':relUsuario', $this->getUsuario(), PDO::PARAM_INT);
            $stmt->bindValue(':relTotal', $this->getTotal(), PDO::PARAM_INT);
            $stmt->bindValue(':relData', $this->getData(), PDO::PARAM_STR);
            $stmt->bindValue(':relStatus' ,'1', PDO::PARAM_STR);
            $stmt->execute();
            
            
            $query2="SELECT MAX(relAid) FROM relatoriosa;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query2);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                foreach ($raw as $ret) {
                    $relAid=$ret['MAX(relAid)'];
                    $this->setLastId($relAid);
                }
                
            }
        }
         
        
      $usuId=$_SESSION['id'];
      $tipo=$_SESSION['tipo'];
      
       $query3="INSERT INTO tabelasacessos
                (usuario,igreja,celulas,relatorios,level,status)
                values(:usuario,:igreja,:celulas,:relatorios,:level,:status);";
      $stmt=$conn->getInstance()->prepare($query3);
      $stmt->bindValue(':usuario',$usuId, PDO::PARAM_STR);
      $stmt->bindValue(':igreja',$this->getIgreja(), PDO::PARAM_STR); //veio do sha1
      $stmt->bindValue(':celulas',$this->getCelula(), PDO::PARAM_STR);
      $stmt->bindValue(':relatorios',$this->getLastId(), PDO::PARAM_STR);
      $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
      $stmt->bindValue(':status','1', PDO::PARAM_STR);
      $stmt->execute();
            
            
            // Make the changes to the database permanent
            $stmt=$conn->getInstance()->commit();
            $stmt=null;
        }catch ( PDOException $e ) {
            // Failed to insert the order into the database so we rollback any changes
            $conn::$instance->rollBack();
            throw $e;
        }
    }

    public function pastorUpdate()
    {
        $userId=$_SESSION['id'];
        try {
            $query="UPDATE relatoriosa "
                    ."SET "
                        ."relBase = :relBase,"
                        ."relMembros = :relMembros,"
                        ."relVisitantes = :relVisitantes,"
                        ."relCriancas = :relCriancas," 
                        ."relAdultos = :relAdultos," 
                        ."relJovens = :relJovens," 
                        ."relEstudo = :relEstudo," 
                        ."relQuebragelo = :relQuebragelo," 
                        ."relLanche = :relLanche," 
                        ."relAceitou = :relAceitou," 
                        ."relReconcilhacao = :relReconcilhacao,"
                        ."relTestemunho = :relTestemunho,"
                        ."relTotal = :relTotal,"
                        ."relData = :relData,"
                        ."relStatus = :relStatus "
                    ."WHERE relAid =  :relAid "
                    ."AND  relCelula IN(SELECT celulas FROM tabelasacessos WHERE usuario = '$userId') "
                    ."AND relIgreja IN (SELECT igreja FROM tabelasacessos WHERE usuario = '$userId') "
                    ."AND relStatus =  :relStatus;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':relAid', $this->getId());
            $stmt->bindValue(':relBase' ,$this->getBase());
            $stmt->bindValue(':relMembros' ,$this->getMembros());
            $stmt->bindValue(':relVisitantes' ,$this->getVisitantes());
            $stmt->bindValue(':relCriancas' , $this->getCriancas());
            $stmt->bindValue(':relAdultos' , $this->getAdultos());
            $stmt->bindValue(':relJovens' , $this->getJovens());
            $stmt->bindValue(':relEstudo' , $this->getEstudo());
            $stmt->bindValue(':relQuebragelo' , $this->getQuebragelo());
            $stmt->bindValue(':relLanche' , $this->getLanche());
            $stmt->bindValue(':relAceitou', $this->getAceitou());
            $stmt->bindValue(':relReconcilhacao', $this->getReconcilhacao());
            $stmt->bindValue(':relTestemunho', $this->getTestemunho());
            $stmt->bindValue(':relTotal', $this->getTotal());
            $stmt->bindValue(':relData', $this->getData());
            $stmt->bindValue(':relStatus', '1');         
 
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function pastorReadWholeByid($id)
    {
        try{
        $tipo=$_SESSION['tipo'];
        $usuId=$_SESSION['id'];
        $query="SELECT a.`celId`, a.`celuuid`, a.`celCelula`, a.`celRede`, a.`celLider`, a.`celViceLider`, a.`celSecretario`, a.`celAnfitriao`,"
                ."a.`celColaborador`, a.`celDia`, a.`celHora`, a.`celData`, a.`celuserId`, a.`celIgrejaId`, a.`celLevel`, a.`celStatus`,"
                ."b.`relAid`, b.`relUid`, b.`relBase`, b.`relMembros`, b.`relVisitantes`,b.`relCriancas`," 
                ."b.`relAdultos`, b.`relJovens`,b.`relTotal`, b.`relEstudo`, b.`relQuebragelo`, b.`relLanche`, b.`relAceitou`," 
                ."b.`relReconcilhacao`, b.`relTestemunho`, b.`relCelula`, b.`relIgreja`, b.`relUsuario`,b.`relData`,b.relTotal, b.`relStatus` " 
                ."FROM relatoriosa as b "
                ."INNER JOIN celulas a  "
                ."ON  a.`celId` = b.`relCelula` "
                ."GROUP BY b.relAid "
                ."HAVING  b.relStatus = '1' AND a.celStatus = '1' AND b.`relAid` = '$id' "
                ."AND b.relCelula IN (SELECT celulas FROM tabelasacessos WHERE usuario = '$usuId') "
                ."AND b.relIgreja IN (SELECT igreja FROM tabelasacessos WHERE usuario = '$usuId') "
                ."LIMIT 1;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                        while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
        echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
        echo $e->getMessage();
        exit;
    }
    }

    public function pastorDeleteAll()
    {}

    public function pastorReadById($id)
    {}

    public function pastorDeleteByid($id)
    {
        try{
            $query="DELETE FROM relatoriosa WHERE relAid = $id;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }else {
                echo "<div style='margin-top:100px;' class='alert-success'>Erro: Não foi possível apagar os dados do banco de dados</div>";
            }
            $stmt = null;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function pastorDeletePendente($id)
    {}


    
           /*   LIDER   */
    
    public function liderRead()
    {
                
    try{
        $tipo=$_SESSION['tipo'];
        $usuId=$_SESSION['usuId'];
 
        $query="SELECT a.`celId`,a.`celCelula`,a.`celStatus`,b.`relAid`, b.`relUid`, b.`relBase`, b.`relMembros`, b.`relVisitantes`,"
                    ."b.`relCriancas`, b.`relAdultos`, b.`relJovens`, b.`relEstudo`, b.`relQuebragelo`,"
                    ."b.`relLanche`, b.`relAceitou`, b.`relReconcilhacao`, b.`relTestemunho`, b.`relCelula`,"
                    ."b.`relIgreja`, b.`relUsuario`, b.`relData`,b.`relStatus` "
                ."FROM celulasdb.celulas as a "
                    ."INNER JOIN celulasdb.relatoriosa b "
                    ."ON  a.`celId` = b.`relCelula` "
                ."GROUP BY b.relAid "
                ."HAVING  b.relstatus = '1' AND a.celstatus = '1' "
                ."AND celId IN (SELECT celulas FROM celulasdb.tabelasacessos where usuario = '$usuId') "
                ."LIMIT 1000;";

        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                        while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }

    public function liderInsert()
    {
        $stmt = $conn = new Connection();
        try {
            $stmt=$conn->getInstance()->beginTransaction(); 
            $query="INSERT INTO relatoriosa("
                    ."relAid,"
                    ."relUid,"
                    ."relBase,"
                    ."relMembros,"
                    ."relVisitantes,"
                    ."relCriancas," 
                    ."relAdultos," 
                    ."relJovens," 
                    ."relEstudo," 
                    ."relQuebragelo," 
                    ."relLanche," 
                    ."relAceitou," 
                    ."relReconcilhacao,"
                    ."relTestemunho,"
                    ."relCelula,"
                    ."relIgreja,"
                    ."relUsuario,"
                    ."relTotal,"
                    ."relData,"
                    ."relStatus) "
                      ."VALUES(:relAid,"
                        .":relUid,"
                        .":relBase,"                        
                        .":relMembros,"
                        .":relVisitantes,"
                        .":relCriancas," 
                        .":relAdultos," 
                        .":relJovens," 
                        .":relEstudo," 
                        .":relQuebragelo," 
                        .":relLanche," 
                        .":relAceitou," 
                        .":relReconcilhacao,"
                        .":relTestemunho,"
                        .":relCelula,"
                        .":relIgreja,"
                        .":relUsuario,"
                        .":relTotal,"
                        .":relData,"
                        .":relStatus)";
            
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':relAid', $this->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':relUid', $this->getUid(), PDO::PARAM_STR);
            $stmt->bindValue(':relBase', $this->getBase(), PDO::PARAM_INT);
            $stmt->bindValue(':relMembros', $this->getMembros(), PDO::PARAM_INT);
            $stmt->bindValue(':relVisitantes', $this->getVisitantes(), PDO::PARAM_INT);
            $stmt->bindValue(':relCriancas', $this->getCriancas(), PDO::PARAM_INT);
            $stmt->bindValue(':relAdultos', $this->getAdultos(), PDO::PARAM_INT);
            $stmt->bindValue(':relJovens', $this->getJovens(), PDO::PARAM_INT);
            $stmt->bindValue(':relEstudo', $this->getEstudo(), PDO::PARAM_STR);
            $stmt->bindValue(':relQuebragelo', $this->getQuebragelo(), PDO::PARAM_STR);
            $stmt->bindValue(':relLanche', $this->getLanche(), PDO::PARAM_STR);
            $stmt->bindValue(':relAceitou', $this->getAceitou(), PDO::PARAM_STR);
            $stmt->bindValue(':relReconcilhacao', $this->getReconcilhacao(), PDO::PARAM_STR);
            $stmt->bindValue(':relTestemunho', $this->getTestemunho(), PDO::PARAM_STR);
            $stmt->bindValue(':relCelula', $this->getCelula(), PDO::PARAM_INT);
            $stmt->bindValue(':relIgreja', $this->getIgreja(), PDO::PARAM_INT);
            $stmt->bindValue(':relUsuario', $this->getUsuario(), PDO::PARAM_INT);
            $stmt->bindValue(':relTotal', $this->getTotal(), PDO::PARAM_INT);
            $stmt->bindValue(':relData', $this->getData(), PDO::PARAM_STR);
            $stmt->bindValue(':relStatus' ,'1', PDO::PARAM_STR);
            $stmt->execute();
            
            
            $query2="SELECT MAX(relAid) FROM celulasdb.relatoriosa;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query2);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                foreach ($raw as $ret) {
                    $relAid=$ret['MAX(relAid)'];
                    $this->setLastId($relAid);
                }
                
            }
        }
         
        
      $usuId=$_SESSION['id'];
      $tipo=$_SESSION['tipo'];
      
       $query3="INSERT INTO celulasdb.tabelasacessos
                (usuario,igreja,celulas,relatorios,level,status)
                values(:usuario,:igreja,:celulas,:relatorios,:level,:status);";
      $stmt=$conn->getInstance()->prepare($query3);
      $stmt->bindValue(':usuario',$usuId, PDO::PARAM_STR);
      $stmt->bindValue(':igreja',$this->getIgreja(), PDO::PARAM_STR); //veio do sha1
      $stmt->bindValue(':celulas',$this->getCelula(), PDO::PARAM_STR);
      $stmt->bindValue(':relatorios',$this->getLastId(), PDO::PARAM_STR);
      $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
      $stmt->bindValue(':status','1', PDO::PARAM_STR);
      $stmt->execute();
            
            
            // Make the changes to the database permanent
            $stmt=$conn->getInstance()->commit();
            $stmt=null;
        }catch ( PDOException $e ) {
            // Failed to insert the order into the database so we rollback any changes
            $conn::$instance->rollBack();
            throw $e;
        }
    }

    public function liderUpdate()
    {
        $userId=$_SESSION['id'];
        try {
            $query="UPDATE celulasdb.relatoriosa "
                    ."SET "
                        ."relBase = :relBase,"
                        ."relMembros = :relMembros,"
                        ."relVisitantes = :relVisitantes,"
                        ."relCriancas = :relCriancas," 
                        ."relAdultos = :relAdultos," 
                        ."relJovens = :relJovens," 
                        ."relEstudo = :relEstudo," 
                        ."relQuebragelo = :relQuebragelo," 
                        ."relLanche = :relLanche," 
                        ."relAceitou = :relAceitou," 
                        ."relReconcilhacao = :relReconcilhacao,"
                        ."relTestemunho = :relTestemunho,"
                        ."relTotal = :relTotal,"
                        ."relData = :relData,"
                        ."relStatus = :relStatus "
                    ."WHERE relAid =  :relAid "
                    ."AND  relCelula IN(SELECT celulas FROM celulasdb.tabelasacessos WHERE usuario = '$userId') "
                    ."AND relIgreja IN (SELECT igreja FROM celulasdb.tabelasacessos WHERE usuario = '$userId') "
                    ."AND relStatus =  :relStatus;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':relAid', $this->getId());
            $stmt->bindValue(':relBase' ,$this->getBase());
            $stmt->bindValue(':relMembros' ,$this->getMembros());
            $stmt->bindValue(':relVisitantes' ,$this->getVisitantes());
            $stmt->bindValue(':relCriancas' , $this->getCriancas());
            $stmt->bindValue(':relAdultos' , $this->getAdultos());
            $stmt->bindValue(':relJovens' , $this->getJovens());
            $stmt->bindValue(':relEstudo' , $this->getEstudo());
            $stmt->bindValue(':relQuebragelo' , $this->getQuebragelo());
            $stmt->bindValue(':relLanche' , $this->getLanche());
            $stmt->bindValue(':relAceitou', $this->getAceitou());
            $stmt->bindValue(':relReconcilhacao', $this->getReconcilhacao());
            $stmt->bindValue(':relTestemunho', $this->getTestemunho());
            $stmt->bindValue(':relTotal', $this->getTotal());
            $stmt->bindValue(':relData', $this->getData());
            $stmt->bindValue(':relStatus', '1');         
 
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function liderReadWholeByid($id)
    {
        try{
        $tipo=$_SESSION['tipo'];
        $usuId=$_SESSION['usuId'];
        $query="SELECT a.`celId`, a.`celuuid`, a.`celCelula`, a.`celRede`, a.`celLider`, a.`celViceLider`, a.`celSecretario`, a.`celAnfitriao`,"
                ."a.`celColaborador`, a.`celDia`, a.`celHora`, a.`celData`, a.`celuserId`, a.`celIgrejaId`, a.`celLevel`, a.`celStatus`,"
                ."b.`relAid`, b.`relUid`, b.`relBase`, b.`relMembros`, b.`relVisitantes`,b.`relCriancas`," 
                ."b.`relAdultos`, b.`relJovens`,b.`relTotal`, b.`relEstudo`, b.`relQuebragelo`, b.`relLanche`, b.`relAceitou`," 
                ."b.`relReconcilhacao`, b.`relTestemunho`, b.`relCelula`, b.`relIgreja`, b.`relUsuario`,b.`relData`,b.relTotal, b.`relStatus` " 
                ."FROM celulasdb.relatoriosa as b "
                ."INNER JOIN celulasdb.celulas a  "
                ."ON  a.`celId` = b.`relCelula` "
                ."GROUP BY b.relAid "
                ."HAVING  b.relStatus = '1' AND a.celStatus = '1' AND b.`relAid` = '$id' "
                ."AND b.relCelula IN (SELECT celulas FROM celulasdb.tabelasacessos WHERE usuario = '$usuId') "
                ."AND b.relIgreja IN (SELECT igreja FROM celulasdb.tabelasacessos WHERE usuario = '$usuId') "
                ."LIMIT 1;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                        while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
        echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
        echo $e->getMessage();
        exit;
       }
    }

    public function liderDeleteAll()
    {}

    public function liderReadById($id)
    {}

    public function liderDeleteByid($id)
    {
         try{
            $query="DELETE FROM relatoriosa WHERE relAid = $id;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }else {
                echo "<div style='margin-top:100px;' class='alert-success'>Erro: Não foi possível apagar os dados do banco de dados</div>";
            }
            $stmt = null;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function liderDeletePendente($id)
    {}
    
    public function liderReadDeleteds(){}
    
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @param mixed 
     */
    public function getUid()
    {
        return $this->uid;
    }
    
    /**
     * @param mixed $uid 
     */
    public function setUid($uid1)
    {   
        if(!empty($uid1)){
            $uid=sha1($uid1);
            $this->uid = $uid;

        }
    }
    
    /**
     * @return mixed
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param mixed $base
     */
    public function setBase($base)
    {
        $this->base = $base;
    }

    /**
     * @return mixed
     */
    public function getMembros()
    {
        return $this->membros;
    }

    /**
     * @param mixed $membros
     */
    public function setMembros($membros)
    {
        $this->membros = $membros;
    }

    /**
     * @return mixed
     */
    public function getVisitantes()
    {
        return $this->visitantes;
    }

    /**
     * @param mixed $visitantes
     */
    public function setVisitantes($visitantes)
    {
        $this->visitantes = $visitantes;
    }

    /**
     * @return mixed
     */
    public function getCriancas()
    {
        return $this->criancas;
    }

    /**
     * @param mixed $criancas
     */
    public function setCriancas($criancas)
    {
        $this->criancas = $criancas;
    }

    /**
     * @return mixed
     */
    public function getAdultos()
    {
        return $this->adultos;
    }

    /**
     * @param mixed $adultos
     */
    public function setAdultos($adultos)
    {
        $this->adultos = $adultos;
    }

    /**
     * @return mixed
     */
    public function getJovens()
    {
        return $this->jovens;
    }

    /**
     * @param mixed $jovens
     */
    public function setJovens($jovens)
    {
        $this->jovens = $jovens;
    }

    /**
     * @return mixed
     */
    public function getEstudo()
    {
        return $this->estudo;
    }

    /**
     * @param mixed $estudo
     */
    public function setEstudo($estudo)
    {
        $this->estudo = $estudo;
    }

    /**
     * @return mixed
     */
    public function getQuebragelo()
    {
        return $this->quebragelo;
    }

    /**
     * @param mixed $quebragelo
     */
    public function setQuebragelo($quebragelo)
    {
        $this->quebragelo = $quebragelo;
    }

    /**
     * @return mixed
     */
    public function getLanche()
    {
        return $this->lanche;
    }

    /**
     * @param mixed $lanche
     */
    public function setLanche($lanche)
    {
        $this->lanche = $lanche;
    }

    /**
     * @return mixed
     */
    public function getAceitou()
    {
        return $this->aceitou;
    }

    /**
     * @param mixed $aceitou
     */
    public function setAceitou($aceitou)
    {
        $this->aceitou = $aceitou;
    }

    /**
     * @return mixed
     */
    public function getReconcilhacao()
    {
        return $this->reconcilhacao;
    }

    /**
     * @param mixed $reconcilhacao
     */
    public function setReconcilhacao($reconcilhacao)
    {
        $this->reconcilhacao = $reconcilhacao;
    }

    /**
     * @return mixed
     */
    public function getTestemunho()
    {
        return $this->testemunho;
    }

    /**
     * @param mixed $testemunho
     */
    public function setTestemunho($testemunho)
    {
        $this->testemunho = $testemunho;
    }
    /**
     * @return mixed
     */
    public function getIgreja()
    {
        return $this->igreja;
    }

    /**
     * @param mixed $igreja
     */
    public function setIgreja($igreja)
    {
        $this->igreja = $igreja;
    }

    /**
     * @return mixed
     */
    public function getCelula()
    {
        return $this->celula;
    }

    /**
     * @param mixed $celula
     */
    public function setCelula($celula)
    {
        $this->celula = $celula;
    }
    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        if($this->insert == TRUE || $this->update == TRUE){
            $d=Validador::dataToBanco($data);
            $this->data = $d;
        }else{
            $this->data = $data;
        }
    }

    /**
     * @return mixed
     */
    public function getDados()
    {
        return $this->dados;
    }

    /**
     * @param mixed $dados
     */
    public function setDados($dados)
    {
        $this->dados = $dados;
    }

    /**
     * @return mixed
     */
    public function getDadosWhole()
    {
        return $this->dadosWhole;
    }

    /**
     * @param mixed $dadosWhole
     */
    public function setDadosWhole($dadosWhole)
    {
        $this->dadosWhole = $dadosWhole;
    }

    /**
     * @return mixed
     */
    public function getLastId()
    {
        return $this->lastId;
    }

    /**
     * @param mixed $lastId
     */
    public function setLastId($lastId)
    {
        $this->lastId = $lastId;
    }
    
  
}
    

