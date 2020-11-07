<?php
namespace mobile\modulos;

use mobile\modulos\dao\Connection;
use Exception;
use PDO;
use PDOException;
use mobile\functions\Validador;

include_once 'modulos/dao/Login.php';
include_once '../mobile/functions/Validador.php';
include_once 'Crud.php';

/**
 *
 * @author fabiano
 *        
 */
class Igreja implements Crud
{
    public $insert=null;
    public $update=null;
    public $delete=null;
    private $id=null;
    private $uid=null;
    private $igreja=null;
    private $endereco=null;
    private $bairro=null;
    private $cidade=null;
    private $estado=null;
    private $pais=null;
    private $cep=null;
    private $data=null;
    private $telefone=null;
    private $email=null;
    private $level=null;
    private $regiao=null;
    private $status=null;
    private $dados=null;
    private $dadosWhole=null;
    private $lastId=null;
    
    

   /** Inicio funcoes admin */
    /**
     * (non-PHPdoc)
     *  Apagar registro pendente definitivamente
     * @see \modulos\Crud::deletePendente()
     */
    public function deletePendente($id)
    {

        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::readWholeByid()
     */
    public function readWholeByid($id_)
    {

        try{
            $id=$_SESSION['id'];
            $tipo=$_SESSION['tipo'];
            $query="SELECT chuId,
                chuuid,
                chuIgreja,
                chuEndereco,
                chuBairro,
                chuCidade,
                chuEstado,
                chuPais,
                chuCep,
                chuData,
                chuTelefone,
                chuEmail,
                chuRegiao,
                chuLevel,
                chuStatus
            FROM
                igrejas
            GROUP BY
                chuId
            HAVING chuId = '$id_' 
            AND (chuLevel >= '$tipo' OR chuuid IN(SELECT igreja FROM tabela_acesso_igreja WHERE usuario = '$id' AND status = '1' ))   
            ORDER BY
                chuId
            LIMIT 1;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
            $stmt=null;
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::read()
     */
    public function read()
    {

    try{
        $id=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
        $query="SELECT chuId,"
                ."chuuid,"
                ."chuIgreja,"
                ."chuEndereco,"
                ."chuBairro,"
                ."chuCidade,"
                ."chuEstado,"
                ."chuPais,"
                ."chuCep,"
                ."chuData,"
                ."chuTelefone,"
                ."chuEmail,"
                ."chuRegiao,"
                ."chuLevel,"
                ."chuStatus "
             ."FROM "
                ."igrejas "
             ."GROUP BY "
                ."chuId "
             ."HAVING chuStatus = '1' AND " 
                ."chuuid IN(" . "SELECT " . "igreja " . "FROM " . "tabela_acesso_igreja " . "WHERE " . "usuario = '$id')" . "OR chuLevel >= '$tipo'  AND chuStatus = '1' " . "ORDER BY " . "chuId " . "LIMIT 1001;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                    $this->setDados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * (non-PHPdoc)
     * Apagar Registro por sua id
     * Joga para a pendencia serando status
     *
     * @see \modulos\Crud::deleteByid()
     */
    public function deleteByid($id)
    {
        $stmt = $conn = new Connection();
        try {
            // $id= $_SESSION['chuId'];

            $query = "UPDATE igrejas SET chuStatus = :chuStatus WHERE chuId= :chuId;";
            $stmt = $conn->getInstance()->beginTransaction();
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuId', $id, PDO::PARAM_INT);
            $stmt->bindValue(':chuStatus', '0', PDO::PARAM_STR);
            $stmt->execute();

            // Make the changes to the database permanent
            $stmt = $conn->getInstance()->commit();
            $stmt = null;
        } catch (PDOException $e) {
            // Failed to insert the order into the database so we rollback any changes
            $conn::$instance->rollBack();
            throw $e;
        }
    }

    /**
     * (non-PHPdoc)
     * Apagar todos os registros definitivamente
     *
     * @see \modulos\Crud::deleteAll()
     */
    public function deleteAll()
    {
        try {
            $query = "DELETE FROM igrejas;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count = $stmt->rowCount();
                if ($count > 0) {
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::insert()
     */
    public function insert()
    {
        $stmt = $conn = new Connection();

        try {
            $stmt = $conn->getInstance()->beginTransaction();
            $tipo = $_SESSION['tipo'];
            $userId = $_SESSION['usuId'];
            $query = "INSERT INTO igrejas (chuId,chuuid,chuIgreja,chuEndereco,chuBairro,chuCidade,chuEstado,chuPais,chuCep,chuData,chuTelefone,chuEmail,chuRegiao,chuLevel,chuuserId,chuStatus)values(:chuId,:chuuid,:chuIgreja,:chuEndereco,:chuBairro,:chuCidade,:chuEstado,:chuPais,:chuCep,:chuData,:chuTelefone,:chuEmail,:chuRegiao,:chuLevel,:chuuserId,:chuStatus);";

            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuId', $this->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':chuuid', $this->getUid(), PDO::PARAM_STR);
            $stmt->bindValue(':chuIgreja', $this->getIgreja(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEndereco', $this->getEndereco(), PDO::PARAM_STR);
        $stmt->bindValue(':chuBairro' ,$this->getBairro(), PDO::PARAM_STR);
        $stmt->bindValue(':chuCidade', $this->getCidade(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEstado' ,$this->getEstado(), PDO::PARAM_STR);
        $stmt->bindValue(':chuPais', $this->getPais(), PDO::PARAM_STR);
        $stmt->bindValue(':chuCep' ,$this->getCep(), PDO::PARAM_STR);   
        $stmt->bindValue(':chuData' ,$this->getData(), PDO::PARAM_STR);
        $stmt->bindValue(':chuTelefone' ,$this->getTelefone(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEmail' ,$this->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':chuRegiao' ,$this->getRegiao(), PDO::PARAM_STR);
        $stmt->bindValue(':chuLevel' ,$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':chuuserId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':chuStatus' ,'1', PDO::PARAM_STR);
        $stmt->execute();
        
        
        // Get the generated `id`
        $id=$this->id;
        $userid=$_SESSION['id'];
        $chuuid=$_SESSION['uid'];
        $tipo=$_SESSION['tipo'];//tipo de usuario
        
        $query2="INSERT INTO tabela_acesso_igreja (id,usuario,igreja,level,status)values(:id,:usuario,:igreja,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query2);
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario',$userid, PDO::PARAM_STR);
        $stmt->bindValue(':igreja',$this->getId(), PDO::PARAM_STR);
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

    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::update()
     */
    public function update()
    {
        $stmt = $conn = new Connection();
        try{
            $id= $_SESSION['chuId'];
            $tipo=$_SESSION['tipo'];//tipo de usuário
            $query="UPDATE igrejas SET "
                        ."chuIgreja = :chuIgreja,"
                        ."chuEndereco = :chuEndereco,"
                        ."chuBairro = :chuBairro,"
                        ."chuCidade = :chuCidade,"
                        ."chuEstado = :chuEstado,"
                        ."chuPais = :chuPais,"
                        ."chuCep = :chuCep,"
                        ."chuData = :chuData,"
                        ."chuTelefone = :chuTelefone,"
                        ."chuEmail = :chuEmail,"
                        ."chuRegiao = :chuRegiao,"
                        ."chuLevel = :chuLevel,"
                        ."chuStatus = :chuStatus "
                        ."WHERE chuId= :chuId;";
            $stmt=$conn->getInstance()->beginTransaction(); 
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuId', $id, PDO::PARAM_INT);
            $stmt->bindValue(':chuIgreja' ,$this->getIgreja(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEndereco', $this->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(':chuBairro' ,$this->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(':chuCidade', $this->getCidade(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEstado' ,$this->getEstado(), PDO::PARAM_STR);
            $stmt->bindValue(':chuPais', $this->getPais(), PDO::PARAM_STR);
            $stmt->bindValue(':chuCep' ,$this->getCep(), PDO::PARAM_STR);
            $stmt->bindValue(':chuData' ,$this->getData(), PDO::PARAM_STR);
            $stmt->bindValue(':chuTelefone' ,$this->getTelefone(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEmail' ,$this->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':chuRegiao' ,$this->getRegiao(), PDO::PARAM_STR);
            $stmt->bindValue(':chuLevel' ,$tipo, PDO::PARAM_STR);
            $stmt->bindValue(':chuStatus' ,'1', PDO::PARAM_STR);
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

    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::lastId()
     */
    public function lastId()
    {

        try{
            $query="SELECT MAX(chuId) FROM igrejas;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $id= $raw[0];
                    $this->setLastId($id);
                }
            }
            $stmt=null;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::readById()
     */
    public function readById($id)
    {

        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::readDeleteds()
     */
    public function readDeleteds()
    {

        // TODO - Insert your code here
    }

    
    /** Inicio funcoes pastor  */
   
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorReadDeleteds()
     */
    public function pastorReadDeleteds()
    {}
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorRead()
     */
    public function pastorRead()
    {
    try{
        $id=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
        $query="SELECT chuId,"
                ."chuuid,"
                ."chuIgreja,"
                ."chuEndereco,"
                ."chuBairro,"
                ."chuCidade,"
                ."chuEstado,"
                ."chuPais,"
                ."chuCep,"
                ."chuData,"
                ."chuTelefone,"
                ."chuEmail,"
                ."chuRegiao,"
                ."chuLevel,"
                ."chuStatus "
             ."FROM "
                ."igrejas "
             ."GROUP BY chuId "
             ."HAVING chuStatus = '1' AND " 
                ."chuId IN(SELECT igreja FROM tabela_acesso_igreja "
                        ."WHERE usuario = '$id') "   
            ."ORDER BY chuId "
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
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorInsert()
     */
    public function pastorInsert()
    {
        $stmt = $conn = new Connection();

        try {
            $stmt = $conn->getInstance()->beginTransaction();
            $tipo = $_SESSION['tipo'];
            $userId = $_SESSION['usuId'];
           
            
            $query = "INSERT INTO igrejas (chuuid,chuIgreja,chuEndereco,chuBairro,chuCidade,chuEstado,chuPais,chuCep,chuData,chuTelefone,chuEmail,chuRegiao,chuLevel,chuuserId,chuStatus)values(:chuuid,:chuIgreja,:chuEndereco,:chuBairro,:chuCidade,:chuEstado,:chuPais,:chuCep,:chuData,:chuTelefone,:chuEmail,:chuRegiao,:chuLevel,:chuuserId,:chuStatus);";

            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuuid', $this->getUid(), PDO::PARAM_STR);
            $stmt->bindValue(':chuIgreja', $this->getIgreja(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEndereco', $this->getEndereco(), PDO::PARAM_STR);
        $stmt->bindValue(':chuBairro' ,$this->getBairro(), PDO::PARAM_STR);
        $stmt->bindValue(':chuCidade', $this->getCidade(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEstado' ,$this->getEstado(), PDO::PARAM_STR);
        $stmt->bindValue(':chuPais', $this->getPais(), PDO::PARAM_STR);
        $stmt->bindValue(':chuCep' ,$this->getCep(), PDO::PARAM_STR);   
        $stmt->bindValue(':chuData' ,$this->getData(), PDO::PARAM_STR);
        $stmt->bindValue(':chuTelefone' ,$this->getTelefone(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEmail' ,$this->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':chuRegiao' ,$this->getRegiao(), PDO::PARAM_STR);
        $stmt->bindValue(':chuLevel' ,$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':chuuserId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':chuStatus' ,'1', PDO::PARAM_STR);
        $stmt->execute();
        
        // Get the generated `id`
        $id=$this->id;
       // $userid=$_SESSION['id'];
       // $chuuid=$_SESSION['uid'];
        $tipo=$_SESSION['tipo'];//tipo de usuario
        
        $query2="INSERT INTO tabela_acesso_igreja (usuario,igreja,level,status)values(:usuario,:igreja,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query2);
        $stmt->bindValue(':usuario',$userId, PDO::PARAM_STR);
        $stmt->bindValue(':igreja',$this->getId(), PDO::PARAM_STR);
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
       
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorUpdate()
     */
    public function pastorUpdate()
    {
         $stmt = $conn = new Connection();
        try{
            $id= $_SESSION['chuId'];
            $tipo=$_SESSION['tipo'];//tipo de usuário
            $query="UPDATE igrejas SET "
                        ."chuIgreja = :chuIgreja,"
                        ."chuEndereco = :chuEndereco,"
                        ."chuBairro = :chuBairro,"
                        ."chuCidade = :chuCidade,"
                        ."chuEstado = :chuEstado,"
                        ."chuPais = :chuPais,"
                        ."chuCep = :chuCep,"
                        ."chuData = :chuData,"
                        ."chuTelefone = :chuTelefone,"
                        ."chuEmail = :chuEmail,"
                        ."chuRegiao = :chuRegiao,"
                        ."chuLevel = :chuLevel,"
                        ."chuStatus = :chuStatus "
                        ."WHERE chuId= :chuId;";
            $stmt=$conn->getInstance()->beginTransaction(); 
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuId', $id, PDO::PARAM_INT);
            $stmt->bindValue(':chuIgreja' ,$this->getIgreja(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEndereco', $this->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(':chuBairro' ,$this->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(':chuCidade', $this->getCidade(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEstado' ,$this->getEstado(), PDO::PARAM_STR);
            $stmt->bindValue(':chuPais', $this->getPais(), PDO::PARAM_STR);
            $stmt->bindValue(':chuCep' ,$this->getCep(), PDO::PARAM_STR);
            $stmt->bindValue(':chuData' ,$this->getData(), PDO::PARAM_STR);
            $stmt->bindValue(':chuTelefone' ,$this->getTelefone(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEmail' ,$this->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':chuRegiao' ,$this->getRegiao(), PDO::PARAM_STR);
            $stmt->bindValue(':chuLevel' ,$tipo, PDO::PARAM_STR);
            $stmt->bindValue(':chuStatus' ,'1', PDO::PARAM_STR);
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
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorReadWholeByid($id)
     */
    public function pastorReadWholeByid($id)
    {
        try{
            $usuId=$_SESSION['id'];
            $tipo=$_SESSION['tipo'];
            $query="SELECT chuId,
                chuuid,
                chuIgreja,
                chuEndereco,
                chuBairro,
                chuCidade,
                chuEstado,
                chuPais,
                chuCep,
                chuData,
                chuTelefone,
                chuEmail,
                chuRegiao,
                chuLevel,
                chuStatus
            FROM
                igrejas
            GROUP BY
                chuId
            HAVING chuId = '$id' 
            AND (chuLevel >= '$tipo' OR chuId IN(SELECT igreja FROM tabela_acesso_igreja WHERE usuario = '$usuId' AND status = '1' ))   
            ORDER BY
                chuId
            LIMIT 1;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
            $stmt=null;
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorDeleteAll()
     */
    public function pastorDeleteAll()
    {}
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorReadById($id)
     */
    public function pastorReadById($id)
    {}
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorDeleteByid($id)
     */
    public function pastorDeleteByid($id)
    {
        $stmt = $conn = new Connection();
        try {
            // $id= $_SESSION['chuId'];

            $query = "UPDATE igrejas SET chuStatus = :chuStatus WHERE chuId= :chuId;";
            $stmt = $conn->getInstance()->beginTransaction();
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuId', $id, PDO::PARAM_INT);
            $stmt->bindValue(':chuStatus', '0', PDO::PARAM_STR);
            $stmt->execute();

            // Make the changes to the database permanent
            $stmt = $conn->getInstance()->commit();
            $stmt = null;
        } catch (PDOException $e) {
            // Failed to insert the order into the database so we rollback any changes
            $conn::$instance->rollBack();
            throw $e;
        }
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::pastorDeletePendente($id)
     */
    public function pastorDeletePendente($id)
    {}
    
    
       
    
    /************ LIDER ****************/
    
     /* (non-PHPdoc)
     *
     * @see \modulos\Crud::liderReadDeleteds()
     */
    public function liderReadDeleteds()
    {}
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderRead()
     */
    public function liderRead()
    {
    try{
        $id=$_SESSION['id'];
        $tipo=$_SESSION['tipo'];
        $query="SELECT chuId,"
                ."chuuid,"
                ."chuIgreja,"
                ."chuEndereco,"
                ."chuBairro,"
                ."chuCidade,"
                ."chuEstado,"
                ."chuPais,"
                ."chuCep,"
                ."chuData,"
                ."chuTelefone,"
                ."chuEmail,"
                ."chuRegiao,"
                ."chuLevel,"
                ."chuStatus "
             ."FROM igrejas "
             ."GROUP BY chuId "
             ."HAVING chuStatus = '1' AND " 
             ."chuId IN(SELECT igreja FROM tabela_acesso_igreja WHERE usuario = '$id') "   
             ."ORDER BY chuId "
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
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderInsert()
     */
    public function liderInsert()
    {
        $stmt = $conn = new Connection();

        try {
            $stmt = $conn->getInstance()->beginTransaction();
            $tipo = $_SESSION['tipo'];
            $userId = $_SESSION['usuId'];
           
            
            $query = "INSERT INTO igrejas (chuuid,chuIgreja,chuEndereco,chuBairro,chuCidade,chuEstado,chuPais,chuCep,chuData,chuTelefone,chuEmail,chuRegiao,chuLevel,chuuserId,chuStatus)values(:chuuid,:chuIgreja,:chuEndereco,:chuBairro,:chuCidade,:chuEstado,:chuPais,:chuCep,:chuData,:chuTelefone,:chuEmail,:chuRegiao,:chuLevel,:chuuserId,:chuStatus);";

            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuuid', $this->getUid(), PDO::PARAM_STR);
            $stmt->bindValue(':chuIgreja', $this->getIgreja(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEndereco', $this->getEndereco(), PDO::PARAM_STR);
        $stmt->bindValue(':chuBairro' ,$this->getBairro(), PDO::PARAM_STR);
        $stmt->bindValue(':chuCidade', $this->getCidade(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEstado' ,$this->getEstado(), PDO::PARAM_STR);
        $stmt->bindValue(':chuPais', $this->getPais(), PDO::PARAM_STR);
        $stmt->bindValue(':chuCep' ,$this->getCep(), PDO::PARAM_STR);   
        $stmt->bindValue(':chuData' ,$this->getData(), PDO::PARAM_STR);
        $stmt->bindValue(':chuTelefone' ,$this->getTelefone(), PDO::PARAM_STR);
        $stmt->bindValue(':chuEmail' ,$this->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':chuRegiao' ,$this->getRegiao(), PDO::PARAM_STR);
        $stmt->bindValue(':chuLevel' ,$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':chuuserId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':chuStatus' ,'1', PDO::PARAM_STR);
        $stmt->execute();
        
        // Get the generated `id`
        $id=$this->id;
       // $userid=$_SESSION['id'];
       // $chuuid=$_SESSION['uid'];
        $tipo=$_SESSION['tipo'];//tipo de usuario
        
        $query2="INSERT INTO tabela_acesso_igreja (usuario,igreja,level,status)values(:usuario,:igreja,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query2);
        $stmt->bindValue(':usuario',$userId, PDO::PARAM_STR);
        $stmt->bindValue(':igreja',$this->getId(), PDO::PARAM_STR);
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
       
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderUpdate()
     */
    public function liderUpdate()
    {
         $stmt = $conn = new Connection();
        try{
            $id= $_SESSION['chuId'];
            $tipo=$_SESSION['tipo'];//tipo de usuário
            $query="UPDATE igrejas SET "
                        ."chuIgreja = :chuIgreja,"
                        ."chuEndereco = :chuEndereco,"
                        ."chuBairro = :chuBairro,"
                        ."chuCidade = :chuCidade,"
                        ."chuEstado = :chuEstado,"
                        ."chuPais = :chuPais,"
                        ."chuCep = :chuCep,"
                        ."chuData = :chuData,"
                        ."chuTelefone = :chuTelefone,"
                        ."chuEmail = :chuEmail,"
                        ."chuRegiao = :chuRegiao,"
                        ."chuLevel = :chuLevel,"
                        ."chuStatus = :chuStatus "
                        ."WHERE chuId= :chuId;";
            $stmt=$conn->getInstance()->beginTransaction(); 
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuId', $id, PDO::PARAM_INT);
            $stmt->bindValue(':chuIgreja' ,$this->getIgreja(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEndereco', $this->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(':chuBairro' ,$this->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(':chuCidade', $this->getCidade(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEstado' ,$this->getEstado(), PDO::PARAM_STR);
            $stmt->bindValue(':chuPais', $this->getPais(), PDO::PARAM_STR);
            $stmt->bindValue(':chuCep' ,$this->getCep(), PDO::PARAM_STR);
            $stmt->bindValue(':chuData' ,$this->getData(), PDO::PARAM_STR);
            $stmt->bindValue(':chuTelefone' ,$this->getTelefone(), PDO::PARAM_STR);
            $stmt->bindValue(':chuEmail' ,$this->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':chuRegiao' ,$this->getRegiao(), PDO::PARAM_STR);
            $stmt->bindValue(':chuLevel' ,$tipo, PDO::PARAM_STR);
            $stmt->bindValue(':chuStatus' ,'1', PDO::PARAM_STR);
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
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderReadWholeByid($id)
     */
    public function liderReadWholeByid($id)
    {
        try{
            $tipo=$_SESSION['tipo'];
            $query="SELECT chuId,
                chuuid,
                chuIgreja,
                chuEndereco,
                chuBairro,
                chuCidade,
                chuEstado,
                chuPais,
                chuCep,
                chuData,
                chuTelefone,
                chuEmail,
                chuRegiao,
                chuLevel,
                chuStatus
            FROM
                igrejas
            GROUP BY
                chuId
            HAVING chuId = '$id' 
            AND chuId IN(SELECT igreja FROM tabela_acesso_igreja WHERE usuario = '$id' AND status = '1' )   
            ORDER BY
                chuId
            LIMIT 1;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
            $stmt=null;
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderDeleteAll()
     */
    public function liderDeleteAll()
    {}
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderReadById($id)
     */
    public function liderReadById($id)
    {}
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderDeleteByid($id)
     */
    public function liderDeleteByid($id)
    {
        $stmt = $conn = new Connection();
        try {
            // $id= $_SESSION['chuId'];

            $query = "UPDATE igrejas SET chuStatus = :chuStatus WHERE chuId= :chuId;";
            $stmt = $conn->getInstance()->beginTransaction();
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':chuId', $id, PDO::PARAM_INT);
            $stmt->bindValue(':chuStatus', '0', PDO::PARAM_STR);
            $stmt->execute();

            // Make the changes to the database permanent
            $stmt = $conn->getInstance()->commit();
            $stmt = null;
        } catch (PDOException $e) {
            // Failed to insert the order into the database so we rollback any changes
            $conn::$instance->rollBack();
            throw $e;
        }
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see \modulos\Crud::liderDeletePendente($id)
     */
    public function liderDeletePendente($id)
    {}
    
    
    
    
    
    /**
     */
    function __destruct()
    {

        // TODO - Insert your code here
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
    public function getEndereco()
    {
        return $this->endereco;
    }
    
    /**
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
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
    public function getTelefone()
    {
        return $this->telefone;
    }
    
    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
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
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $uid=sha1($uid);
        $this->uid = $uid;
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
    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }
    /**
     * @return mixed
     */
    public function getRegiao()
    {
        return $this->regiao;
    }

    /**
     * @param mixed $regiao
     */
    public function setRegiao($regiao)
    {
        $this->regiao = $regiao;
    }
    
    
}

