<?php
namespace mobile\modulos;

use application\modulos\dao\Connection;
use Exception;
use PDO;
use PDOException;

include_once 'Crud.php';
include_once 'application/modulos/dao/Login.php';


/**
 *
 * @author fabiano
 *        
 */
class Usuario implements Crud
{
    public $insert=null;
    public $update=null;
    public $delete=null;
    private $usuId=NULL; 
    private $usuuid=NULL;
    private $usuEmail=NULL;
    private $usuNome=NULL;
    private $usuSobreNome=NULL;
    private $usuSenha=NULL;
    private $usuTentativa=NULL;
    private $usuBloqueado=NULL;
    private $usuData=NULL;
    private $usuTipo=NULL;
    private $usuAcesso=NULL;
    private $usuStatus=NULL;
    private $dados=null;
    private $lastId=null;
    

    
    /** Atribui usuario à pendencia para posteriormente ser apagada definitivamente.
     *
     * Atribui status 0 para o registro.
     */
    public function deletePendente($id)
    {
        $uid=$_SESSION['uid'];
        try{
            $query="UPDATE usuarios "
                   ."SET usuStatus = 0 "
                   ."GROUP BY usuId "
                   ." HAVING usuId = :usuId AND usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid ='$uid') "  
                   ."OR  usuId = :usuId AND usuTipo >= '$tipo' "   
                   ."AND usuBloqueado <> 'SIM' "               
                   ."AND usuStatus = :usuStatus "
                   ."LIMIT 1;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':usuId', $id, PDO::PARAM_INT);
            $stmt->bindValue(':usuStatus' ,'1', PDO::PARAM_STR);
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    // todo falta melhorar as permissões
    /** Pega todos os dados de um usuario especifico por meio da usuuid*/
    public function readWholeByid($id)
    { 
        try{
            
            $uid=$_SESSION['uid'];
            $tipo=$_SESSION['tipo'];
            $query= "SELECT 
                        usuId,
                        usuuid,
                        usuEmail,
                        usuNome,
                        usuSobreNome,
                        usuSenha,
                        usuTentativa,
                        usuBloqueado,
                        usuData,
                        usuTipo,
                        usuAcesso,
                        usuStatus           
                    FROM usuarios
                    GROUP BY usuId 
                    HAVING usuId = '$id' AND usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid ='$uid')   
                    OR  usuId = '$id' AND usuTipo >= '$tipo'     
                    AND usuBloqueado <> 'SIM'                
                    AND usuStatus = '1'
                    ORDER BY usuEmail
                    LIMIT 1;";
                    
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
   
    /** Pega usuarios conforme as permissoes do usuario 
    *   Seleciona todos os usuarios que o usuario chamador tem acesso */
    public function read()
    {
      try{
          if ($_SESSION['uid']){

        $uid=$_SESSION['uid'];
        $tipo=$_SESSION['tipo'];
        $query= "SELECT usuId,usuuid,usuEmail,usuNome,usuSobreNome,usuSenha,usuTentativa,usuBloqueado,usuData,usuTipo,usuAcesso,usuStatus 
                 FROM usuarios
                 GROUP BY usuuid
                 HAVING usuStatus = '1' AND usuBloqueado = 'NAO'  AND usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid ='$uid')  
                 OR usuTipo >= '$tipo' AND usuBloqueado = 'NAO' AND usuStatus = '1'
                 ORDER BY usuEmail;";
           
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
      }
      } catch (Exception $e) {
          echo "</br></br><b>Erro: Não foi possível recuperar os dados do usuário do banco de dados.</b></br> ";
          echo $e->getMessage();
          exit;
      }
    }
    
    /** Lê usuarios deletados */
    public function readDeleteds()
    {
        try{
            if ($_SESSION['uid']){
                
            $uid=$_SESSION['uid'];
            $tipo=$_SESSION['tipo'];
            $query= "SELECT usuId,usuuid,usuEmail,usuNome,usuSobreNome,usuSenha,usuTentativa,"
             ."usuBloqueado,usuData,usuTipo,usuAcesso,usuStatus "
             ."FROM usuarios "
             ."GROUP BY usuuid "
             ."HAVING usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid >='$uid' )"
             ."OR  usutipo >='$tipo' "
             ."AND usuStatus = '0' "
             ."ORDER BY usuEmail;";
                
                $stmt = $conn = new Connection();
                $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                    while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                        $this->setDados($raw);
                    }
                }
            }
        } catch (Exception $e) {
            echo "</br></br><b>Erro: Não foi possível recuperar os dados do usuário do banco de dados.</b></br> ";
            echo $e->getMessage();
            exit;
        }
        
    }
    
    /** Apaga todos os usuarios */
    public function deleteAll()
    {
        try{
            $query="DELETE FROM usuarios;";
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
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Insere a usuario no DB */
    public function insert()
    {
        $stmt = $conn = new Connection();
        $stmt::$instance;
        try{
        $stmt::$instance->beginTransaction();
        $query="INSERT INTO usuarios(
                usuId,
                usuuid,
                usuEmail,
                usuNome,
                usuSobreNome,
                usuSenha,
                usuData,
                usuTipo               
                )
                VALUES(
                    :usuId,
                    :usuuid,
                    :usuEmail,
                    :usuNome,
                    :usuSobreNome,
                    :usuSenha,
                    :usuData,
                    :usuTipo
                    )";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        $stmt->bindValue(':usuId', $this->getUsuId(), PDO::PARAM_INT);
        $stmt->bindValue(':usuuid' ,$this->getUsuuid(), PDO::PARAM_STR);     
        $stmt->bindValue(':usuEmail', $this->getUsuEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':usuNome' ,$this->getUsuNome(), PDO::PARAM_STR);
        $stmt->bindValue(':usuSobreNome', $this->getUsuSobreNome(), PDO::PARAM_STR);
        $stmt->bindValue(':usuSenha' ,$this->getUsuSenha(), PDO::PARAM_STR);     
        $stmt->bindValue(':usuData', $this->getUsuData(), PDO::PARAM_STR);
        $stmt->bindValue(':usuTipo' ,$this->getUsuTipo(), PDO::PARAM_STR);
       
        $stmt->execute();
        
        // Get the generated `id`
        $id=$this->id;
        $uid=$_SESSION['uid'];
        $this->getUsuTipo()>= '3'?$tipo=$this->getUsuTipo():$tipo=$_SESSION['tipo'];
       
        $query2="INSERT INTO tabela_acesso_usuarios(id,usuuid,permissao,level,status) 
                 VALUES (:id,:usuuid,:permissao,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query2);
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->bindValue(':usuuid',$uid, PDO::PARAM_STR);
        $stmt->bindValue(':permissao',$this->getUsuuid(), PDO::PARAM_STR);
        $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':status', '1', PDO::PARAM_STR);
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
    
    /** Atualiza tabela de usuario na id especificada. */
    public function update()
    {
        $stmt = $conn = new Connection();
        $stmt::$instance;
        try{
            $query="UPDATE usuarios
                SET usuEmail = :usuEmail,
                    usuNome = :usuNome,
                    usuSobreNome = :usuSobreNome,
                    usuSenha = :usuSenha,
                    usuTentativa = :usuTentativa,
                    usuBloqueado = :usuBloqueado,
                    usuData = :usuData,
                    usuTipo = :usuTipo,
                    usuAcesso = :usuAcesso,
                    usuStatus = :usuStatus 
                Where usuId = :usuId;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':usuId', $this->getUsuId());
            $stmt->bindValue(':usuEmail', $this->getUsuEmail());
            $stmt->bindValue(':usuNome' ,$this->getUsuNome());
            $stmt->bindValue(':usuSobreNome', $this->getUsuSobreNome());
            $stmt->bindValue(':usuSenha' ,$this->getUsuSenha());
            $stmt->bindValue(':usuTentativa', $this->getUsuTentativa());
            $stmt->bindValue(':usuBloqueado' ,$this->getUsuBloqueado());
            $stmt->bindValue(':usuData', $this->getUsuData());
            $stmt->bindValue(':usuTipo' ,$this->getUsuTipo());
            $stmt->bindValue(':usuAcesso', $this->getUsuAcesso());
            $stmt->bindValue(':usuStatus' , $this->getUsuStatus());
            
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
    
    /** Apaga usuario definitivamente do DB */
    public function deleteByid($id)
    {
        try{
            $query="DELETE FROM usuarios WHERE usuID = $id;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }
        }catch (Exception $e) {
            echo "<div style='margin-top:100px;' class='alert-success'>Erro: Não foi possível apagar os dados do banco de dados</div>";
            echo $e->getMessage();
            exit;
        }
    }
    
    /** Pega o ultimo insert da tabela */
    public function lastId()
    {
        try{
            $query="SELECT MAX(usuId) FROM `usuarios`;";
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
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    
    public function readById($id)
    {
        try{
            $query= "Select
                        usuId,
                        usuuid,
                        usuEmail,
                        usuNome,
                        usuSobreNome,
                        usuSenha,
                        usuTentativa,
                        usuBloqueado,
                        usuData,
                        usuTipo,
                        usuAcesso,
                        usuStatus
                    FROM usuarios
                    GROUP BY
                        usuId
                    HAVING
                        usuId IN(
                        SELECT
                            usuarios
                        FROM
                            tabela_acesso_usuarios
                        WHERE
                            usuuid =  $usuuid And usuStatus = 1 )
                    ORDER BY
                        usuId
                    LIMIT 1001;";
            
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    public function pastorReadDeleteds()
    {
        try{
            if ($_SESSION['uid']){
                
                $uid=$_SESSION['uid'];
                $tipo=$_SESSION['tipo'];
                $query= "SELECT usuId,usuuid,usuEmail,usuNome,usuSobreNome,usuSenha,usuTentativa,"
                 ."usuBloqueado,usuData,usuTipo,usuAcesso,usuStatus "
                 ."FROM usuarios "
                 ."GROUP BY usuuid "
                 ."HAVING usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid >='$uid' )"
                 ."AND usuStatus = '0' "
                 ."ORDER BY usuEmail;";
                
                $stmt = $conn = new Connection();
                $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                    while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                        $this->setDados($raw);
                    }
                }
            }
        } catch (Exception $e) {
            echo "</br></br><b>Erro: Não foi possível recuperar os dados do usuário do banco de dados.</b></br> ";
            echo $e->getMessage();
            exit;
        }
        
    }

    
    public function pastorRead()
    {  //TODO fazer controle de permissões melhor/conferir aqui;
        try{
          if ($_SESSION['uid']){

        $uid=($_SESSION['uid']);
        $tipo=($_SESSION['tipo']);
        $query= "SELECT a.usuId,a.usuuid,a.usuEmail,a.usuNome,a.usuSobreNome,a.usuSenha,a.usuTentativa,"
                    ."a.usuBloqueado,a.usuData,a.usuTipo,a.usuAcesso,a.usuStatus " 
                 ."FROM usuarios as a "
                 ."GROUP BY a.usuuid "
                 ."HAVING a.usuStatus = '1' AND a.usuBloqueado = 'NAO' "
                 ."AND $id in (SELECT usuario FROM tabela_acesso_igreja where igreja='$igreja') "
                 ."AND a.usuId in ( SELECT usuario FROM tabela_acesso_igreja  where igreja ='$igreja') "
                 ."AND a.usuTipo >= '$tipo' AND a.usuStatus = '1' "
                 ."ORDER BY a.usuEmail;";
           
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
      }
      } catch (Exception $e) {
          echo "</br></br><b>Erro: Não foi possível recuperar os dados do usuário do banco de dados.</b></br> ";
          echo $e->getMessage();
          exit;
      }
    }

    
    public function pastorInsert()
    {
        $stmt = $conn = new Connection();
        $stmt::$instance;
        try{
        $stmt::$instance->beginTransaction();
        $query="INSERT INTO usuarios(
                usuuid,
                usuEmail,
                usuNome,
                usuSobreNome,
                usuSenha,
                usuData,
                usuTipo               
                )
                VALUES(
                    :usuuid,
                    :usuEmail,
                    :usuNome,
                    :usuSobreNome,
                    :usuSenha,
                    :usuData,
                    :usuTipo
                    )";
        
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        $stmt->bindValue(':usuuid' ,$this->getUsuuid(), PDO::PARAM_STR);     
        $stmt->bindValue(':usuEmail', $this->getUsuEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':usuNome' ,$this->getUsuNome(), PDO::PARAM_STR);
        $stmt->bindValue(':usuSobreNome', $this->getUsuSobreNome(), PDO::PARAM_STR);
        $stmt->bindValue(':usuSenha' ,$this->getUsuSenha(), PDO::PARAM_STR);     
        $stmt->bindValue(':usuData', $this->getUsuData(), PDO::PARAM_STR);
        $stmt->bindValue(':usuTipo' ,$this->getUsuTipo(), PDO::PARAM_STR);
       
        $stmt->execute();
        

        // Get the generated `id`
        $uid=$_SESSION['uid'];
        $tipo=$_SESSION['tipo'];
        $igreja=$_SESSION['igrejaId'];
        
        $query3="INSERT INTO tabela_acesso_usuarios(usuuid,permissao,level,status) 
                 VALUES (:usuuid,:permissao,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query3);
        $stmt->bindValue(':usuuid',$uid, PDO::PARAM_STR);
        $stmt->bindValue(':permissao',$this->getUsuuid(), PDO::PARAM_STR);
        $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':status', '1', PDO::PARAM_STR);
        $stmt->execute(); 
        
        $query4="SELECT MAX(usuId) from usuarios;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query4);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                foreach ($raw as $ret) {
                    $userid=$ret['MAX(usuId)'];
                    $this->setLastId($userid);
                }
                
            }
        }
        
       $query5="INSERT INTO tabela_acesso_igreja(usuario,igreja,level,status) 
                 VALUES (:usuario,:igreja,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query5);
        $stmt->bindValue(':usuario',$this->getLastId(), PDO::PARAM_STR);
        $stmt->bindValue(':igreja',$igreja, PDO::PARAM_STR);
        $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':status', '1', PDO::PARAM_STR);
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
        $uid = $_SESSION['uid'];
        $tipo = $_SESSION['tipo'];
        $stmt = $conn = new Connection();
        $stmt::$instance;
        try{
            $stmt::$instance->beginTransaction();
            $query="UPDATE usuarios "
                ."SET usuEmail = :usuEmail,"
                    ."usuNome = :usuNome,"
                    ."usuSobreNome = :usuSobreNome,"
                    ."usuSenha = :usuSenha,"
                    ."usuTentativa = :usuTentativa,"
                    ."usuBloqueado = :usuBloqueado,"
                    ."usuData = :usuData,"
                    ."usuTipo = :usuTipo,"
                    ."usuAcesso = :usuAcesso,"
                    ."usuStatus = :usuStatus "    
                 ."WHERE usuId = :usuId AND usuuid in (SELECT permissao FROM tabela_acesso_usuarios where usuuid ='$uid') "
                 ."LIMIT 1;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':usuId', $this->getUsuId());
            $stmt->bindValue(':usuEmail', $this->getUsuEmail());
            $stmt->bindValue(':usuNome' ,$this->getUsuNome());
            $stmt->bindValue(':usuSobreNome', $this->getUsuSobreNome());
            $stmt->bindValue(':usuSenha' ,$this->getUsuSenha());
            $stmt->bindValue(':usuTentativa', $this->getUsuTentativa());
            $stmt->bindValue(':usuBloqueado' ,$this->getUsuBloqueado());
            $stmt->bindValue(':usuData', $this->getUsuData());
            $stmt->bindValue(':usuTipo' ,$this->getUsuTipo());
            $stmt->bindValue(':usuAcesso', $this->getUsuAcesso());
            $stmt->bindValue(':usuStatus' , $this->getUsuStatus());
            
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

    
    public function pastorReadWholeByid($id)
    {
        try{
            
            $uid=$_SESSION['uid'];
            $tipo=$_SESSION['tipo'];
            $query= "SELECT 
                        usuId,
                        usuuid,
                        usuEmail,
                        usuNome,
                        usuSobreNome,
                        usuSenha,
                        usuTentativa,
                        usuBloqueado,
                        usuData,
                        usuTipo,
                        usuAcesso,
                        usuStatus           
                    FROM usuarios
                    GROUP BY usuId 
                    HAVING usuId = '$id' AND usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid ='$uid')   
                    OR  usuId = '$id' AND usuTipo >= '$tipo'                   
                    AND usuStatus = '1'
                    ORDER BY usuEmail
                    LIMIT 1;";
                    
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    public function pastorDeleteAll()
    {
        try{
            $query="DELETE FROM usuarios;";
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
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    public function pastorReadById($id)
    {
        try{
            $query= "Select
                        usuId,
                        usuuid,
                        usuEmail,
                        usuNome,
                        usuSobreNome,
                        usuSenha,
                        usuTentativa,
                        usuBloqueado,
                        usuData,
                        usuTipo,
                        usuAcesso,
                        usuStatus
                    FROM usuarios
                    GROUP BY
                        usuId
                    HAVING
                        usuId IN(
                        SELECT
                            usuarios
                        FROM
                            tabela_acesso_usuarios
                        WHERE
                            usuuid =  $usuuid And usuStatus = 1 )
                    ORDER BY
                        usuId
                    LIMIT 1;";
            
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    public function pastorDeleteByid($id)
    {
        try{
            $query="DELETE FROM usuarios WHERE usuID = $id;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }
        }catch (Exception $e) {
            echo "<div style='margin-top:100px;' class='alert-success'>Erro: Não foi possível apagar os dados do banco de dados</div>";
            echo $e->getMessage();
            exit;
        }
    }

    
    public function pastorDeletePendente($id)
    {
        try{
            $query="UPDATE usuarios
                    SET usuStatus = 0
                    Where usuId = $id";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':usuId', $this->getUsuId(), PDO::PARAM_INT);
            $stmt->bindValue(':usuStatus' ,$this->getUsuStatus(), PDO::PARAM_STR);
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    
    
    
    
    

    /*************** LIDER ***************/
    
      
    public function liderReadDeleteds()
    {
        try{
            if ($_SESSION['uid']){
                
                $uid=$_SESSION['uid'];
                $tipo=$_SESSION['tipo'];
                $query= "SELECT usuId,usuuid,usuEmail,usuNome,usuSobreNome,usuSenha,usuTentativa,"
                 ."usuBloqueado,usuData,usuTipo,usuAcesso,usuStatus "
                 ."FROM usuarios "
                 ."GROUP BY usuuid "
                 ."HAVING usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid >='$uid' )"
                 ."AND usuStatus = '0' "
                 ."ORDER BY usuEmail;";
                
                $stmt = $conn = new Connection();
                $stmt = $conn->getInstance()->prepare($query);
                if ($stmt->execute()) {
                    while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                        $this->setDados($raw);
                    }
                }
            }
        } catch (Exception $e) {
            echo "</br></br><b>Erro: Não foi possível recuperar os dados do usuário do banco de dados.</b></br> ";
            echo $e->getMessage();
            exit;
        }
        
    }

    
    public function liderRead()
    {  //TODO fazer controle de permissões melhor/conferir aqui;
        try{
          if ($_SESSION['uid']){

        $uid=($_SESSION['uid']);
        $tipo=($_SESSION['tipo']);
        $query= "SELECT usuId,usuuid,usuEmail,usuNome,usuSobreNome,usuSenha,usuTentativa,usuBloqueado,usuData,usuTipo,"
         ."usuAcesso,usuStatus " 
         ."FROM usuarios "
         ."GROUP BY usuuid "
         ."HAVING usuStatus = '1' AND usuBloqueado = 'NAO' "
         ."AND usuId in (SELECT igreja FROM tabela_acesso_igreja where usuario='$uid') "
         ."AND usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid ='$uid' AND level >= '$tipo') "
         ."ORDER BY usuEmail;";
           
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }
      }
      } catch (Exception $e) {
          echo "</br></br><b>Erro: Não foi possível recuperar os dados do usuário do banco de dados.</b></br> ";
          echo $e->getMessage();
          exit;
      }
    }

    
    public function liderInsert()
    {
        $stmt = $conn = new Connection();
        $stmt::$instance;
        try{
        $stmt::$instance->beginTransaction();
        $query="INSERT INTO usuarios(
                usuuid,
                usuEmail,
                usuNome,
                usuSobreNome,
                usuSenha,
                usuData,
                usuTipo               
                )
                VALUES(
                    :usuuid,
                    :usuEmail,
                    :usuNome,
                    :usuSobreNome,
                    :usuSenha,
                    :usuData,
                    :usuTipo
                    )";
        
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        $stmt->bindValue(':usuuid' ,$this->getUsuuid(), PDO::PARAM_STR);     
        $stmt->bindValue(':usuEmail', $this->getUsuEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':usuNome' ,$this->getUsuNome(), PDO::PARAM_STR);
        $stmt->bindValue(':usuSobreNome', $this->getUsuSobreNome(), PDO::PARAM_STR);
        $stmt->bindValue(':usuSenha' ,$this->getUsuSenha(), PDO::PARAM_STR);     
        $stmt->bindValue(':usuData', $this->getUsuData(), PDO::PARAM_STR);
        $stmt->bindValue(':usuTipo' ,$this->getUsuTipo(), PDO::PARAM_STR);
       
        $stmt->execute();
        

        // Get the generated `id`
        $uid=$_SESSION['uid'];
        $tipo=$_SESSION['tipo'];
        $igreja=$_SESSION['igrejaId'];
        
        $query3="INSERT INTO tabela_acesso_usuarios(usuuid,permissao,level,status) 
                 VALUES (:usuuid,:permissao,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query3);
        $stmt->bindValue(':usuuid',$uid, PDO::PARAM_STR);
        $stmt->bindValue(':permissao',$this->getUsuuid(), PDO::PARAM_STR);
        $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':status', '1', PDO::PARAM_STR);
        $stmt->execute(); 
        
        $query4="SELECT MAX(usuId) from usuarios;";
        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query4);
        if ($stmt->execute()) {
            while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                foreach ($raw as $ret) {
                    $userid=$ret['MAX(usuId)'];
                    $this->setLastId($userid);
                }
                
            }
        }
        
       $query5="INSERT INTO tabela_acesso_igreja(usuario,igreja,level,status) 
                 VALUES (:usuario,:igreja,:level,:status);";
        $stmt=$conn->getInstance()->prepare($query5);
        $stmt->bindValue(':usuario',$this->getLastId(), PDO::PARAM_STR);
        $stmt->bindValue(':igreja',$igreja, PDO::PARAM_STR);
        $stmt->bindValue(':level',$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':status', '1', PDO::PARAM_STR);
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
        $uid = $_SESSION['uid'];
        $tipo = $_SESSION['tipo'];
        $stmt = $conn = new Connection();
        $stmt::$instance;
        try{
            $stmt::$instance->beginTransaction();
            $query="UPDATE celulasdb.usuarios "
                ."SET usuEmail = :usuEmail,"
                    ."usuNome = :usuNome,"
                    ."usuSobreNome = :usuSobreNome,"
                    ."usuSenha = :usuSenha,"
                    ."usuTentativa = :usuTentativa,"
                    ."usuBloqueado = :usuBloqueado,"
                    ."usuData = :usuData,"
                    ."usuTipo = :usuTipo,"
                    ."usuAcesso = :usuAcesso,"
                    ."usuStatus = :usuStatus "    
                 ."WHERE usuId = :usuId AND usuuid in (SELECT permissao FROM tabela_acesso_usuarios where usuuid ='$uid') "
                 ."LIMIT 1;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':usuId', $this->getUsuId());
            $stmt->bindValue(':usuEmail', $this->getUsuEmail());
            $stmt->bindValue(':usuNome' ,$this->getUsuNome());
            $stmt->bindValue(':usuSobreNome', $this->getUsuSobreNome());
            $stmt->bindValue(':usuSenha' ,$this->getUsuSenha());
            $stmt->bindValue(':usuTentativa', $this->getUsuTentativa());
            $stmt->bindValue(':usuBloqueado' ,$this->getUsuBloqueado());
            $stmt->bindValue(':usuData', $this->getUsuData());
            $stmt->bindValue(':usuTipo' ,$this->getUsuTipo());
            $stmt->bindValue(':usuAcesso', $this->getUsuAcesso());
            $stmt->bindValue(':usuStatus' , $this->getUsuStatus());
            
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

    
    public function liderReadWholeByid($id)
    {
        try{
            
            $uid=$_SESSION['uid'];
            $tipo=$_SESSION['tipo'];
            $query= "SELECT 
                        usuId,
                        usuuid,
                        usuEmail,
                        usuNome,
                        usuSobreNome,
                        usuSenha,
                        usuTentativa,
                        usuBloqueado,
                        usuData,
                        usuTipo,
                        usuAcesso,
                        usuStatus           
                    FROM usuarios
                    GROUP BY usuId 
                    HAVING usuId = '$id' AND usuuid in ( SELECT permissao FROM tabela_acesso_usuarios  where usuuid ='$uid')   
                    OR  usuId = '$id' AND usuTipo >= '$tipo'                   
                    AND usuStatus = '1'
                    ORDER BY usuEmail
                    LIMIT 1;";
                    
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    public function liderDeleteAll()
    {
        try{
            $query="DELETE FROM usuarios;";
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
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    public function liderReadById($id)
    {
        try{
            $query= "Select
                        usuId,
                        usuuid,
                        usuEmail,
                        usuNome,
                        usuSobreNome,
                        usuSenha,
                        usuTentativa,
                        usuBloqueado,
                        usuData,
                        usuTipo,
                        usuAcesso,
                        usuStatus
                    FROM usuarios
                    GROUP BY
                        usuId
                    HAVING
                        usuId IN(
                        SELECT
                            usuarios
                        FROM
                            tabela_acesso_usuarios
                        WHERE
                            usuuid =  $usuuid And usuStatus = 1 )
                    ORDER BY
                        usuId
                    LIMIT 1;";
            
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados($raw);
                }
            }else {
                echo "Erro: Não foi possível recuperar os dados do Aluno do banco de dados";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    
    public function liderDeleteByid($id)
    {
        try{
            $query="DELETE FROM usuarios WHERE usuID = $id;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $count=$stmt->rowCount();
                if ($count > 0 ){
                    echo "<div style='margin-top:100px;' class='alert-success'><strong>Apagado registro com sucesso.</strong></div>";
                }
            }
        }catch (Exception $e) {
            echo "<div style='margin-top:100px;' class='alert-success'>Erro: Não foi possível apagar os dados do banco de dados</div>";
            echo $e->getMessage();
            exit;
        }
    }

    
    public function liderDeletePendente($id)
    {
        try{
            $query="UPDATE usuarios
                    SET usuStatus = 0
                    Where usuId = $id";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            $stmt->bindValue(':usuId', $this->getUsuId(), PDO::PARAM_INT);
            $stmt->bindValue(':usuStatus' ,$this->getUsuStatus(), PDO::PARAM_STR);
            
            return  $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
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
    public function getUsuId()
    {
        return $this->usuId;
    }
    
    /**
     * @param mixed $usuId
     */
    public function setUsuId($usuId)
    {
        $this->usuId = $usuId;
    }
    
    /**
     * @return mixed
     */
    public function getUsuuid()
    {
        return $this->usuuid;
    }
    
    /**
     * @param mixed $usuuid
     */
    public function setUsuuid($usuuid)
    {
        $this->usuuid = $usuuid;
    }
    
    /**
     * @return mixed
     */
    public function getUsuEmail()
    {
        return $this->usuEmail;
    }
    
    /**
     * @param mixed $usuEmail
     */
    public function setUsuEmail($usuEmail)
    {
        $this->usuEmail = $usuEmail;
    }
    
    /**
     * @return mixed
     */
    public function getUsuNome()
    {
        return $this->usuNome;
    }
    
    /**
     * @param mixed $usuNome
     */
    public function setUsuNome($usuNome)
    {
        $this->usuNome = $usuNome;
    }
    
    /**
     * @return mixed
     */
    public function getUsuSobreNome()
    {
        return $this->usuSobreNome;
    }
    
    /**
     * @param mixed $usuSobreNome
     */
    public function setUsuSobreNome($usuSobreNome)
    {
        $this->usuSobreNome = $usuSobreNome;
    }
    
    /**
     * @return mixed
     */
    public function getUsuSenha()
    {
        return $this->usuSenha;
    }
    
    /**
     * @param mixed $usuSenha
     */
    public function setUsuSenha($usuSenha)
    {
        $this->usuSenha = $usuSenha;
    }
    
    /**
     * @return mixed
     */
    public function getUsuTentativa()
    {
        return $this->usuTentativa;
    }
    
    /**
     * @param mixed $usuTentativa
     */
    public function setUsuTentativa($usuTentativa)
    {
        $this->usuTentativa = $usuTentativa;
    }
    
    /**
     * @return mixed
     */
    public function getUsuBloqueado()
    {
        return $this->usuBloqueado;
    }
    
    /**
     * @param mixed $usuBloqueado
     */
    public function setUsuBloqueado($usuBloqueado)
    {
        $this->usuBloqueado = $usuBloqueado;
    }
    
    /**
     * @return mixed
     */
    public function getUsuData()
    {
        return $this->usuData;
    }
    
    /**
     * @param mixed $usuData
     */
    public function setUsuData($usuData)
    {
        $this->usuData = $usuData;
    }
    
    /**
     * @return mixed
     */
    public function getUsuTipo()
    {
        return $this->usuTipo;
    }
    
    /**
     * @param mixed $usuTipo
     */
    public function setUsuTipo($usuTipo)
    {
        $this->usuTipo = $usuTipo;
    }
    
    /**
     * @return mixed
     */
    public function getUsuAcesso()
    {
        return $this->usuAcesso;
    }
    
    /**
     * @param mixed $usuAcesso
     */
    public function setUsuAcesso($usuAcesso)
    {
        $this->usuAcesso = $usuAcesso;
    }
    
    /**
     * @return mixed
     */
    public function getUsuStatus()
    {
        return $this->usuStatus;
    }
    
    /**
     * @param mixed $usuStatus
     */
    public function setUsuStatus($usuStatus)
    {
        $this->usuStatus = $usuStatus;
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



    
    
}

