<?php
namespace mobile\modulos;

use mobile\modulos\dao\Connection;
use Exception;
use PDO;
use PDOException;
use mobile\functions\Validador;

include_once 'modulos/dao/Login.php';
include_once 'functions/Validador.php';


/**
 *
 * @author fabiano
 *        
 */
class Celula
{
    public $insert=null;
    public $update=null;
    public $delete=null;
    private $id=null;
    private $uid=null;
    private $rede=null;
    private $celula=null;   
    private $lider=null;
    private $vicelider=null;
    private $secretario;
    private $anfitriao=null; 
    private $colaborador=null;
    private $data=null;
    private $dia=null;
    private $hora=null;
    private $Endereco=null;
    private $bairro=null;  
    private $estado=null; 
    private $cidade=null; 
    private $pais=null; 
    private $cep=null;
    private $celuserid=null;
    private $igreja=null;
    private $status=null;
    private $dados=null;
    private $dadosWhole=null;
    private $lastId=null;


   
  
    /** Pega o ultimo id */
    function lastId(){
        try{
        $query="SELECT MAX(celId) FROM celulas;";
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
    
    /** Pega celulas conforme as permissoes do usuario */
    function readCelulas(){
        try{
        $id=$_SESSION['id'];  
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid']; 
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
            ."HAVING a.celStatus = '1' "
            ."AND a.celId IN(SELECT celulas FROM tabelasacessos WHERE usuario = '$id' OR cellevel >='$tipo') " 
            ."AND a.celIgrejaId IN (SELECT igreja FROM tabela_acesso_igreja WHERE usuario='$id' ) " 
            ."AND b.chuStatus = '1' "
            ."ORDER BY a.celId "
            ."LIMIT 1001;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Não foi possível recuperar os dados da célula do banco de dados.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Pega todos os dados de uma celula especifica */
    function readWholebyId($celid){
        try {
        $id=$_SESSION['usuId'];
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
                ."a.celData,"
                ."a.celLevel,"
                ."a.celuserId,"
                ."a.celIgrejaId,"
                ."a.celStatus,"
                    ."b.chuId,"
                    ."b.chuIgreja,"
                    ."b.chuEstado,"
                    ."b.chuCidade,"
                    ."b.chuStatus "
            ."FROM celulas as a "
            ."INNER JOIN igrejas as b "
                ."ON b.chuId = a.celIgrejaId "
              ."GROUP BY celId "
              ."HAVING a.celId = '$celid' AND a.celStatus = '1' "
                  ."AND a.celuserId IN(SELECT celulas FROM tabelasacessos WHERE usuario= $id or level >='$tipo' ) "            
                  ."AND a.celIgrejaId IN (SELECT igreja FROM tabela_acesso_igreja WHERE usuario='$id' ) "                
                  ."AND b.chuStatus = '1' "
                  ."ORDER BY celId "
                  ."LIMIT 1;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDadosWhole($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
            $stmt=null;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /** Insere a celula no DB */
     function insertCelula(){
         $tipo=$_SESSION['tipo'];
         $uid=$_SESSION['uid'];
         $usuId=$_SESSION['usuId'];
         
         $stmt = $conn = new Connection();
         $stmt::$instance;
        try {

       $stmt::$instance->beginTransaction();
       $query="  INSERT INTO celulas ("
                    ."celId,"
                    ."celuuid,"
                    ."celCelula,"
                    ."celRede,"
                    ."celLider,"
                    ."celViceLider,"
                    ."celSecretario,"
                    ."celAnfitriao,"
                    ."celColaborador,"
                    ."celDia,"
                    ."celHora,"
                    ."celData,"
                    ."celuserid,"
                    ."celigrejaid,"
                    ."celStatus)"
                    ."values("
                        .":celId,"  
                        .":celuuid,"                 
                        .":celCelula,"
                        .":celRede,"
                        .":celLider,"
                        .":celViceLider,"
                        .":celSecretario,"
                        .":celAnfitriao,"
                        .":celColaborador,"
                        .":celDia,"
                        .":celHora,"
                        .":celData,"                      
                        .":celuserid,"
                        .":celigrejaid,"
                        .":celStatus"
                        .");";
       
       $stmt=$conn->getInstance()->beginTransaction(); 
       $stmt = $conn = new Connection();
       $stmt = $conn->getInstance()->prepare($query);
       $stmt->bindValue(':celId', $this->getId(), PDO::PARAM_INT);
       $stmt->bindValue(':celuuid', $this->getUid(), PDO::PARAM_STR);
       $stmt->bindValue(':celCelula' ,$this->getCelula(), PDO::PARAM_STR);
       $stmt->bindValue(':celRede' ,$this->getRede(), PDO::PARAM_STR);
       $stmt->bindValue(':celLider' ,$this->getLider(), PDO::PARAM_STR);
       $stmt->bindValue(':celViceLider' , $this->getVicelider(), PDO::PARAM_STR);
       $stmt->bindValue(':celSecretario' , $this->getSecretario(), PDO::PARAM_STR);
       $stmt->bindValue(':celAnfitriao' , $this->getAnfitriao(), PDO::PARAM_STR);
       $stmt->bindValue(':celColaborador' , $this->getColaborador(), PDO::PARAM_STR);
       $stmt->bindValue(':celDia' , $this->getDia(), PDO::PARAM_STR);
       $stmt->bindValue(':celHora' , $this->getHora(), PDO::PARAM_STR);
       $stmt->bindValue(':celData', $this->getData(), PDO::PARAM_STR);     
       $stmt->bindValue(':celuserid', $usuId, PDO::PARAM_INT);
       $stmt->bindValue(':celigrejaid', $this->getIgreja(), PDO::PARAM_INT);
       $stmt->bindValue(':celStatus', $this->getStatus(), PDO::PARAM_STR);
       
       
      $stmt->execute();
      
      // Get the generated `id`
      $id=$this->id;            // mesmo da celula
      $usuId=$_SESSION['id'];   //do usuario
      $tipo=$_SESSION['tipo'];  // de usuario
      
       $query2="INSERT INTO tabelasacessos
                (id,usuario,igreja,celulas,relatorios,level,status)
                values(:id,:usuario,:igreja,:celulas,:relatorios,:level,:status);";
      $stmt=$conn->getInstance()->prepare($query2);
      $stmt->bindValue(':id',$id, PDO::PARAM_INT);
      $stmt->bindValue(':usuario',$usuId, PDO::PARAM_STR);
      $stmt->bindValue(':igreja',$this->getIgreja(), PDO::PARAM_STR); //veio do sha1
      $stmt->bindValue(':celulas',$this->getId(), PDO::PARAM_STR);
      $stmt->bindValue(':relatorios',$this->getId(), PDO::PARAM_STR);
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
    
     
    /** Atualiza tabela de celulas na id especificada. */
    function updateCelulaforId($id){
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid'];
        try {
            $query="UPDATE celulas
                    SET celCelula = :celCelula,
                        celRede =  :celRede,
                        celLider =  :celLider,
                        celViceLider =  :celViceLider,
                        celSecretario =  :celSecretario,
                        celAnfitriao =  :celAnfitriao,
                        celColaborador =  :celColaborador,
                        celDia =  :celDia,
                        celHora =  :celHora,
                        celData =  :celData
                    WHERE celId =  :celId 
                    AND  celId IN(SELECT celulas
                                  FROM tabelasacessos
                                  WHERE usuario = '$id' or level >= '$tipo') 
                    AND celStatus =  :celStatus;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':celCelula' ,$this->getCelula());
            $stmt->bindValue(':celRede' ,$this->getRede());
            $stmt->bindValue(':celLider' ,$this->getLider());
            $stmt->bindValue(':celViceLider' , $this->getVicelider());
            $stmt->bindValue(':celSecretario' , $this->getSecretario());
            $stmt->bindValue(':celAnfitriao' , $this->getAnfitriao());
            $stmt->bindValue(':celColaborador' , $this->getColaborador());
            $stmt->bindValue(':celDia' , $this->getDia());
            $stmt->bindValue(':celHora' , $this->getHora());
            $stmt->bindValue(':celData', $this->getData());
            $stmt->bindValue(':celId', $id);
            $stmt->bindValue(':celStatus', '1');         
 
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

        
    }
       
    /** Seleciona todos os nomes dos usuarios que o usuario tem permissão */
    function readCelulaforId($id){
        $query="select a.usuID, a.usuNome,a.usuStatus, b.id, b.usuario,b.celulas,b,status, c.celId, c.celcelula,c.celStatus 
                FROM usuarios a 
                JOIN tabelasacessos b 
                ON a.usuId = b.usuario
                JOIN celulas c
                ON b.id = c.celId
                where a.usuId=$id AND a.usuStatus='1' AND b.status='1' AND b.AND c.celStatus='1';";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                $this->setDados($raw);
            }
            $stmt = null;
        }else {
            echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
        }
        
    }  
    
    /** Apaga celula definitivamente do DB */
    function deleteById($id){
       
        try{
            $query="DELETE FROM celulas WHERE celID = $id;";
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
    
    /** Atribui celula à pendencia para posteriormente ser apagada definitivamente.
     * 
     * Atribui status 0 para a celula. 
     */
    function deletCelulaPen($id){
        try {
            $query="UPDATE celulas
                    SET celStatus =  :celStatus
                    WHERE celId =  :celId;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':celId', $id);
            $stmt->bindValue(':celStatus', 0);         
            
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                echo "window.location='index.php'";
                echo "<script>alert(Apagado célula);</script>";
                  
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    function readDeleteds(){
        try{
            $id=$_SESSION['id'];
            $query="SELECT celId,
                celCelula,
                celRede,
                celLider,
                celViceLider,
                celSecretario,
                celAnfitriao,
                celColaborador,
                celDia,
                celHora,
                celData,
                celStatus
            FROM
                celulas
            GROUP BY
                celId
            HAVING
                celId IN(
                SELECT
                    celulas
                FROM
                    tabelasacessos
                WHERE
                    status = '0' )
            AND celStatus = '0' 
            ORDER BY
                celId
            LIMIT 1001;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Não foi possível recuperar os dados da célula do banco de dados.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Apaga todas as celulas do DB */
    function deleteAllCelulas(){
        try{
            $query="DELETE FROM celulas;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    
    
    /** Pega celulas conforme as permissoes do usuario */
    function pastorReadCelulas(){
        try{
        $id=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid'];
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
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Não foi possível recuperar os dados da célula do banco de dados.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Pega todos os dados de uma celula especifica */
    function pastorReadWholebyId($celid){
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
                ."a.celPais," 
                ."a.celCep,"
                ."a.celData,"
                ."a.celLevel,"
                ."a.celuserId,"
                ."a.celIgrejaId,"
                ."a.celStatus,"
                    ."b.chuId,"
                    ."b.chuIgreja,"
                    ."b.chuEstado,"
                    ."b.chuCidade,"
                    ."b.chuStatus "
            ."FROM celulas as a "
            ."INNER JOIN igrejas as b "
                ."ON b.chuId = a.celIgrejaId "
              ."GROUP BY a.celId "
              ."HAVING a.celId = '$celid' AND a.celStatus = '1' "
                  ."AND a.celId IN(SELECT celulas FROM tabelasacessos WHERE usuario= $id or level >='$tipo') "            
                  ."AND a.celIgrejaId IN (SELECT igreja FROM tabela_acesso_igreja WHERE usuario='$id' And status = '1') "                
                  ."AND b.chuStatus = '1' "
                  ."ORDER BY a.celId "
                  ."LIMIT 1;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDadosWhole($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
            $stmt=null;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /** Insere a celula no DB */
     function pastorInsertCelula(){
        $id=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid'];
        $igreja=$_SESSION['igrejaId'];

         $stmt = $conn = new Connection();
         $stmt->getInstance()->beginTransaction();
        try {

       $query="  INSERT INTO celulas ("
                    ."celuuid,"
                    ."celCelula,"
                    ."celRede,"
                    ."celLider,"
                    ."celViceLider,"
                    ."celSecretario,"
                    ."celAnfitriao,"
                    ."celColaborador,"
                    ."celDia,"
                    ."celHora,"
                    ."celEndereco,"
                    ."celBairro," 
                    ."celCidade," 
                    ."celEstado," 
                    ."celPais," 
                    ."celCep,"
                    ."celData,"
                    ."celuserid,"
                    ."celigrejaid ) "
                    ."values("
                        .":celuuid,"                 
                        .":celCelula,"
                        .":celRede,"
                        .":celLider,"
                        .":celViceLider,"
                        .":celSecretario,"
                        .":celAnfitriao,"
                        .":celColaborador,"
                        .":celDia,"
                        .":celHora,"
                        .":celEndereco,"
                        .":celBairro," 
                        .":celCidade," 
                        .":celEstado," 
                        .":celPais," 
                        .":celCep,"
                        .":celData,"                      
                        .":celuserid,"
                        .":celigrejaid"
                        .");";
       

       $stmt = $conn->getInstance()->prepare($query);
       $stmt->bindValue(':celuuid', $this->getUid(), PDO::PARAM_STR);
       $stmt->bindValue(':celCelula' ,$this->getCelula(), PDO::PARAM_STR);
       $stmt->bindValue(':celRede' ,$this->getRede(), PDO::PARAM_STR);
       $stmt->bindValue(':celLider' ,$this->getLider(), PDO::PARAM_STR);
       $stmt->bindValue(':celViceLider' , $this->getVicelider(), PDO::PARAM_STR);
       $stmt->bindValue(':celSecretario' , $this->getSecretario(), PDO::PARAM_STR);
       $stmt->bindValue(':celAnfitriao' , $this->getAnfitriao(), PDO::PARAM_STR);
       $stmt->bindValue(':celColaborador' , $this->getColaborador(), PDO::PARAM_STR);
       $stmt->bindValue(':celDia' , $this->getDia(), PDO::PARAM_STR);
       $stmt->bindValue(':celHora' , $this->getHora(), PDO::PARAM_STR);
       $stmt->bindValue(':celEndereco' , $this->getEndereco(), PDO::PARAM_STR);
       $stmt->bindValue(':celBairro' , $this->getBairro(), PDO::PARAM_STR);
       $stmt->bindValue(':celCidade' , $this->getCidade(), PDO::PARAM_STR);  
       $stmt->bindValue(':celEstado' , $this->getEstado(), PDO::PARAM_STR); 
       $stmt->bindValue(':celCep' , $this->getCep(), PDO::PARAM_STR);
       $stmt->bindValue(':celPais' , $this->getPais(), PDO::PARAM_STR); 
       $stmt->bindValue(':celData', $this->getData(), PDO::PARAM_STR);     
       $stmt->bindValue(':celuserid', $this->getCeluserid(), PDO::PARAM_INT);
       $stmt->bindValue(':celigrejaid', $this->getIgreja(), PDO::PARAM_INT);
      
       $stmt->execute();
           
        $query2="SELECT MAX(celId) FROM celulas;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query2);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                foreach ($raw as $ret) {
                    $celid=$ret['MAX(celId)'];
                    $this->setLastId($celid);
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
      $stmt->bindValue(':igreja',$igreja, PDO::PARAM_STR); //veio do sha1
      $stmt->bindValue(':celulas',$this->getLastId(), PDO::PARAM_STR);
      $stmt->bindValue(':relatorios','0', PDO::PARAM_STR);
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
 
     
 /** Atualiza tabela de celulas na id especificada. */
    function pastorUpdateCelulaforId($id){
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid'];
        $userId=$_SESSION['id'];
        try {
            $query="UPDATE celulas "
                    ."SET celCelula = :celCelula,"
                        ."celRede =  :celRede,"
                        ."celLider =  :celLider,"
                        ."celViceLider =  :celViceLider,"
                        ."celSecretario =  :celSecretario,"
                        ."celAnfitriao =  :celAnfitriao,"
                        ."celColaborador =  :celColaborador,"
                        ."celDia =  :celDia,"
                        ."celHora =  :celHora,"
                        ."celEndereco =  :celEndereco,"
                        ."celBairro =  :celBairro," 
                        ."celCidade =  :celCidade,"  
                        ."celEstado =  :celEstado,"
                        ."celPais =  :celPais," 
                        ."celCep =  :celCep,"
                        ."celData =  :celData "
                   ."WHERE celId =  :celId " 
                    ."AND  celId IN(SELECT celulas FROM tabelasacessos WHERE usuario = '$userId')" 
                    ."AND celStatus =  :celStatus;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':celCelula' ,$this->getCelula());
            $stmt->bindValue(':celRede' ,$this->getRede());
            $stmt->bindValue(':celLider' ,$this->getLider());
            $stmt->bindValue(':celViceLider' , $this->getVicelider());
            $stmt->bindValue(':celSecretario' , $this->getSecretario());
            $stmt->bindValue(':celAnfitriao' , $this->getAnfitriao());
            $stmt->bindValue(':celColaborador' , $this->getColaborador());
            $stmt->bindValue(':celDia' , $this->getDia());
            $stmt->bindValue(':celHora' , $this->getHora());
            $stmt->bindValue(':celEndereco' , $this->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(':celBairro' , $this->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(':celCidade' , $this->getCidade(), PDO::PARAM_STR);  
            $stmt->bindValue(':celEstado' , $this->getEstado(), PDO::PARAM_STR); 
            $stmt->bindValue(':celPais' , $this->getPais(), PDO::PARAM_STR);
            $stmt->bindValue(':celCep' , $this->getCep(), PDO::PARAM_STR);
            $stmt->bindValue(':celData', $this->getData());
            $stmt->bindValue(':celId', $id);
            $stmt->bindValue(':celStatus', '1');        
 
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

        
    }
       
    /** Seleciona todos os nomes dos usuarios que o usuario tem permissão */
    function pastorReadCelulaforId($id){
        $query="select a.usuID, a.usuNome,a.usuStatus, b.id, b.usuario,b.celulas,b,status, c.celId, c.celcelula,c.celStatus 
                FROM usuarios a 
                JOIN tabelasacessos b 
                ON a.usuId = b.usuario
                JOIN celulas c
                ON b.id = c.celId
                where a.usuId=$id AND a.usuStatus='1' AND b.status='1' AND b.AND c.celStatus='1';";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                $this->setDados($raw);
            }
            $stmt = null;
        }else {
            echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
        }
        
    }  
    
    /** Apaga celula definitivamente do DB */
    function pastorDeleteById($id){
        //TODO fazer controle de permissões aqui.
        try{
            $query="DELETE FROM celulas WHERE celID = $id;";
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
    
    /** Atribui celula à pendencia para posteriormente ser apagada definitivamente.
     * 
     * Atribui status 0 para a celula. 
     */
    function pastorDeletCelulaPen($id){
        try {
            $query="UPDATE celulas
                    SET celStatus =  :celStatus
                    WHERE celId =  :celId;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':celId', $id);
            $stmt->bindValue(':celStatus', 0);         
            
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                echo "window.location='index.php'";
                echo "<script>alert(Apagado célula);</script>";
                  
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    function pastorReadDeleteds(){
        try{
            $id=$_SESSION['id'];
            $query="SELECT celId,"
                ."celCelula,"
                ."celRede,"
                ."celLider,"
                ."celViceLider,"
                ."celSecretario,"
                ."celAnfitriao,"
                ."celColaborador,"
                ."celDia,"
                ."celHora,"
                ."celEndereco,"
                ."celBairro," 
                ."celCidade," 
                ."celEstado," 
                ."celPais," 
                ."celCep,"
                ."celData,"
                ."celStatus "
            ."FROM "
                ."celulas "
            ."GROUP BY "
                ."celId "
            ."HAVING "
                ."celId IN("
                ."SELECT "
                    ."celulas "
                ."FROM "
                    ."tabelasacessos "
                ."WHERE "
                    ."status = '0' )"
            ."AND celStatus = '0' "
            ."ORDER BY "
                ."celId "
            ."LIMIT 1001;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Não foi possível recuperar os dados da célula do banco de dados.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Apaga todas as celulas do DB */
    function pastorDeleteAllCelulas(){
        try{
            $query="DELETE FROM celulas;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
             
             /* LIDER */
    
    /** Pega celulas conforme as permissoes do usuario */
    function liderReadCelulas(){
        try{
        $userid=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid'];
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
                ."a.celEstado," 
                ."a.celPais,"
                ."a.celCep,"
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
            ."AND a.celId IN(SELECT celulas FROM tabelasacessos WHERE status = '1' AND usuario = '$userid') "            
            ."ORDER BY celId "
            ."LIMIT 1001;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Não foi possível recuperar os dados da célula do banco de dados.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Pega todos os dados de uma celula especifica */
    function liderReadWholebyId($celid){
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
                ."a.celEndereco," 
                ."a.celCidade," 
                ."a.celBairro," 
                ."a.celEstado," 
                ."a.celCidade," 
                ."a.celPais," 
                ."a.celEstado," 
                ."a.celData,"
                ."a.celCep,"
                ."a.celLevel,"
                ."a.celuserId,"
                ."a.celIgrejaId,"
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
            ."HAVING a.celId = '$celid' AND a.celStatus = '1' AND b.chuStatus = '1' "
            ."AND a.celId IN(SELECT celulas FROM tabelasacessos WHERE status = '1' AND usuario = '$id') "            
            ."ORDER BY celId "
            ."LIMIT 1;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDadosWhole($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
            $stmt=null;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /** Insere a celula no DB */
     function liderInsertCelula(){
        $id=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid'];
        $igreja=$_SESSION['igrejaId'];
       // $stmt=null;
         $stmt = $conn = new Connection();
         $stmt->getInstance()->beginTransaction();
        try {

      // $stmt::$instance->beginTransaction();
       $query="  INSERT INTO celulas ("
                    ."celuuid,"
                    ."celCelula,"
                    ."celRede,"
                    ."celLider,"
                    ."celViceLider,"
                    ."celSecretario,"
                    ."celAnfitriao,"
                    ."celColaborador,"
                    ."celDia,"
                    ."celHora,"
                    ."celData,"
                    ."celuserid,"
                    ."celigrejaid ) "
                    ."values("
                        .":celuuid,"                 
                        .":celCelula,"
                        .":celRede,"
                        .":celLider,"
                        .":celViceLider,"
                        .":celSecretario,"
                        .":celAnfitriao,"
                        .":celColaborador,"
                        .":celDia,"
                        .":celHora,"
                        .":celData,"                      
                        .":celuserid,"
                        .":celigrejaid"
                        .");";
       
//        $stmt = $conn = new Connection();
       $stmt = $conn->getInstance()->prepare($query);
       $stmt->bindValue(':celuuid', $this->getUid(), PDO::PARAM_STR);
       $stmt->bindValue(':celCelula' ,$this->getCelula(), PDO::PARAM_STR);
       $stmt->bindValue(':celRede' ,$this->getRede(), PDO::PARAM_STR);
       $stmt->bindValue(':celLider' ,$this->getLider(), PDO::PARAM_STR);
       $stmt->bindValue(':celViceLider' , $this->getVicelider(), PDO::PARAM_STR);
       $stmt->bindValue(':celSecretario' , $this->getSecretario(), PDO::PARAM_STR);
       $stmt->bindValue(':celAnfitriao' , $this->getAnfitriao(), PDO::PARAM_STR);
       $stmt->bindValue(':celColaborador' , $this->getColaborador(), PDO::PARAM_STR);
       $stmt->bindValue(':celDia' , $this->getDia(), PDO::PARAM_STR);
       $stmt->bindValue(':celHora' , $this->getHora(), PDO::PARAM_STR);
       $stmt->bindValue(':celData', $this->getData(), PDO::PARAM_STR);     
       $stmt->bindValue(':celuserid', $this->getCeluserid(), PDO::PARAM_INT);
       $stmt->bindValue(':celigrejaid', $this->getIgreja(), PDO::PARAM_INT);
      
       $stmt->execute();
           
        $query2="SELECT MAX(celId) FROM celulasdb.celulas;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query2);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                foreach ($raw as $ret) {
                    $celid=$ret['MAX(celId)'];
                    $this->setLastId($celid);
                }
                
            }
        }
        
      // Get the generated `id`
    //  $id=$this->id;
      $usuId=$_SESSION['id'];
      $tipo=$_SESSION['tipo'];
      
       $query3="INSERT INTO tabelasacessos
                (usuario,igreja,celulas,relatorios,level,status)
                values(:usuario,:igreja,:celulas,:relatorios,:level,:status);";
      $stmt=$conn->getInstance()->prepare($query3);
      $stmt->bindValue(':usuario',$usuId, PDO::PARAM_STR);
      $stmt->bindValue(':igreja',$igreja, PDO::PARAM_STR); //veio do sha1
      $stmt->bindValue(':celulas',$this->getLastId(), PDO::PARAM_STR);
      $stmt->bindValue(':relatorios','0', PDO::PARAM_STR);
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
 
     
    /** Atualiza tabela de celulas na id especificada. */
    function liderUpdateCelulaforId($id){
        $tipo=$_SESSION['tipo'];
        $uid=$_SESSION['uid'];
        $userId=$_SESSION['id'];
        try {
            $query="UPDATE celulas "
                    ."SET celCelula = :celCelula,"
                        ."celRede =  :celRede,"
                        ."celLider =  :celLider,"
                        ."celViceLider =  :celViceLider,"
                        ."celSecretario =  :celSecretario,"
                        ."celAnfitriao =  :celAnfitriao,"
                        ."celColaborador =  :celColaborador,"
                        ."celDia =  :celDia,"
                        ."celHora =  :celHora,"
                        ."celData =  :celData,"
                        ."celEndereco =  :celEndereco,"
                        ."celBairro =  :celBairro," 
                        ."celCidade =  :celCidade,"  
                        ."celEstado =  :celEstado,"
                        ."celPais =  :celPais," 
                        ."celCep =  :celCep "
                    ."WHERE celId =  :celId "
                    ."AND  celId IN(SELECT celulas FROM tabelasacessos WHERE usuario = '$userId') "
                    ."AND celStatus =  :celStatus;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':celCelula' ,$this->getCelula());
            $stmt->bindValue(':celRede' ,$this->getRede());
            $stmt->bindValue(':celLider' ,$this->getLider());
            $stmt->bindValue(':celViceLider' , $this->getVicelider());
            $stmt->bindValue(':celSecretario' , $this->getSecretario());
            $stmt->bindValue(':celAnfitriao' , $this->getAnfitriao());
            $stmt->bindValue(':celColaborador' , $this->getColaborador());
            $stmt->bindValue(':celDia' , $this->getDia());
            $stmt->bindValue(':celHora' , $this->getHora());
            $stmt->bindValue(':celEndereco' , $this->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(':celBairro' , $this->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(':celCidade' , $this->getCidade(), PDO::PARAM_STR);  
            $stmt->bindValue(':celEstado' , $this->getEstado(), PDO::PARAM_STR); 
            $stmt->bindValue(':celPais' , $this->getPais(), PDO::PARAM_STR);
            $stmt->bindValue(':celCep' , $this->getCep(), PDO::PARAM_STR);
            $stmt->bindValue(':celData', $this->getData());
            $stmt->bindValue(':celId', $id);
            $stmt->bindValue(':celStatus', '1');         
 
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

        
    }
       
    /** Seleciona todos os nomes dos usuarios que o usuario tem permissão */
    function liderReadCelulaforId($id){
        $query="select a.usuID, a.usuNome,a.usuStatus, b.id, b.usuario,b.celulas,b,status, c.celId, c.celcelula,c.celStatus 
                FROM usuarios a 
                JOIN tabelasacessos b 
                ON a.usuId = b.usuario
                JOIN celulas c
                ON b.id = c.celId
                where a.usuId=$id AND a.usuStatus='1' AND b.status='1' AND b.AND c.celStatus='1';";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                $this->setDados($raw);
            }
            $stmt = null;
        }else {
            echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
        }
        
    }  
    
    /** Apaga celula definitivamente do DB */
    function liderDeleteById($id){
        //TODO fazer controle de permissões aqui.
        try{
            $query="DELETE FROM celulas WHERE celID = $id;";
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
    
    /** Atribui celula à pendencia para posteriormente ser apagada definitivamente.
     * 
     * Atribui status 0 para a celula. 
     */
    function liderDeletCelulaPen($id){
        try {
            $query="UPDATE celulas
                    SET celStatus =  :celStatus
                    WHERE celId =  :celId;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':celId', $id);
            $stmt->bindValue(':celStatus', 0);         
            
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                echo "window.location='index.php'";
                echo "<script>alert(Apagado célula);</script>";
                  
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    function liderReadDeleteds(){
        try{
            $id=$_SESSION['id'];
            $query="SELECT celId,
                celCelula,
                celRede,
                celLider,
                celViceLider,
                celSecretario,
                celAnfitriao,
                celColaborador,
                celDia,
                celHora,
                celData,
                celStatus
            FROM
                celulas
            GROUP BY
                celId
            HAVING
                celId IN(
                SELECT
                    celulas
                FROM
                    tabelasacessos
                WHERE
                    status = '0' )
            AND celStatus = '0' 
            ORDER BY
                celId
            LIMIT 1001;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Não foi possível recuperar os dados da célula do banco de dados.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Apaga todas as celulas do DB */
    function liderDeleteAllCelulas(){
        try{
            $query="DELETE FROM celulas;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
     
    
    
    
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return mixed
     */
    public function getRede()
    {
        return $this->rede;
    }

    /**
     * @return mixed
     */
    public function getCelula()
    {
        return $this->celula;
    }

    /**
     * @return mixed
     */
    public function getLider()
    {
        return $this->lider;
    }

    /**
     * @return mixed
     */
    public function getVicelider()
    {
        return $this->vicelider;
    }

    /**
     * @return mixed
     */
    public function getSecretario()
    {
        return $this->secretario;
    }

    /**
     * @return mixed
     */
    public function getAnfitriao()
    {
        return $this->anfitriao;
    }

    /**
     * @return mixed
     */
    public function getColaborador()
    {
        return $this->colaborador;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
       return $this->data;
    }
    
    /**
     * @param mixed $datahora
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
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @return mixed
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @param mixed $rede
     */
    public function setRede($rede)
    {
        $this->rede = $rede;
    }

    /**
     * @param mixed $celula
     */
    public function setCelula($celula)
    {
        $this->celula = $celula;
    }

    /**
     * @param mixed $lider
     */
    public function setLider($lider)
    {
        $this->lider = $lider;
    }

    /**
     * @param mixed $vicelider
     */
    public function setVicelider($vicelider)
    {
        $this->vicelider = $vicelider;
    }

    /**
     * @param mixed $secretario
     */
    public function setSecretario($secretario)
    {
        $this->secretario = $secretario;
    }

    /**
     * @param mixed $anfitriao
     */
    public function setAnfitriao($anfitriao)
    {
        $this->anfitriao = $anfitriao;
    }

    /**
     * @param mixed $colaborador
     */
    public function setColaborador($colaborador)
    {
        $this->colaborador = $colaborador;
    }

 

    /**
     * @param mixed $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @param mixed $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }
    
    /**
     * @return mixed
     */
    public function getCeluserid()
    {
        return $this->celuserid;
    }

    /**
     * @param mixed $celuserid
     */
    public function setCeluserid($celuserid)
    {
        $this->celuserid = $celuserid;
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
     * @param mixed $dadosall
     */
    public function setDadosWhole($dadosWhole)
    {
        $this->dadosWhole= $dadosWhole;
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
    
    
    /**
     */
    public function __construct()
    {

        // TODO - Insert your code here
    }

    /**
     */
    function __destruct()
    {

        // TODO - Insert your code here
    }
    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->Endereco;
    }

    /**
     * @param mixed $Endereco
     */
    public function setEndereco($Endereco)
    {
        $this->Endereco = $Endereco;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }



    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    
 

}

