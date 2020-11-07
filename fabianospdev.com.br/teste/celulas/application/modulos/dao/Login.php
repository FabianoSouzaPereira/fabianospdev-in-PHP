<?php
namespace modulos\dao;

use application\modulos\dao\Connection;
use PDO;
use PDOException;

class Login
{
    
   private $id= null;
   private $uid= null;
   private $emails= null;
   private $senha= null;
   private $nome=null;
   private $sobreNome=null;
   private $tentativas=null;
   private $bloqueado=null;
   private $data=null;
   private $tipo=null;
   private $acesso=null;
    
    function getLogin($email, $password)
    {   $stmt = $conn = new Connection();
        $select=null;
        $stmt=null;
        try{
        $sql = ("SELECT * "
                ."FROM usuarios "
                ."WHERE usuEmail = :email "
                ."AND usuSenha = :password "
                ."AND usuBloqueado = 'NÃO' "
                ."AND usuStatus = 1 ;");
            $stmt=$conn->getInstance()->beginTransaction(); 
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($sql, array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )); 
         $stmt->execute(array( ':email' => $email, ':password' => sha1(md5($password)))); 
            while ($select = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                Foreach($select as $raw) {
                $id=$raw['usuId']; $uid=$raw['usuuid']; $pemail=$raw['usuEmail'];$senha=$raw['usuSenha'];
                $nome=$raw['usuNome'];$sobreNome=$raw['usuSobreNome'];$tentativas=$raw['usuTentativa'];
                $bloqueado=$raw['usuBloqueado'];$data=$raw['usuData']; $tipo=$raw['usuTipo'];
                $acesso=$raw['usuAcesso'];
                    $this->setId($id);
                    $this->setUid($uid);
                    $this->setEmails($pemail);
                    $this->setSenha($senha);
                    $this->setNome($nome);
                    $this->setSobreNome($sobreNome);
                    $this->setTentativas($tentativas);
                    $this->setBloqueado($bloqueado);
                    $this->setData($data);
                    $this->setTipo($tipo);
                    $this->setAcesso($acesso);
                }
               
            }
            if (!isset($raw)){
            $sql1 = ("SELECT usuTentativa,usuBloqueado FROM usuarios WHERE usuEmail = :email AND usuStatus = 1;");
            $result = Connection::getInstance();
            $stmt = $result->prepare($sql1, array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )); 
            $stmt->execute(array( ':email' => $email)); 
            while ($select = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                Foreach($select as $raw) {
                $tentativas=$raw['usuTentativa'];$bloqueado=$raw['usuBloqueado'];
                    $this->setTentativas($tentativas);
                    $this->setBloqueado($bloqueado);

                }               
            }
                $sql2="UPDATE usuarios 
                    SET usuTentativa = :usuTentativa 
                    Where usuEmail = :usuEmail";
                $stmt = $conn = new Connection();
                $stmt = $conn->getInstance()->prepare($sql2);
                $stmt->bindValue(':usuEmail', $email);
                $stmt->bindValue(':usuTentativa', ($this->getTentativas()+1));
                $stmt->execute();
                
              if($this->getTentativas() >= 4 ){
                $sql2="UPDATE usuarios 
                    SET usuTentativa = :usuTentativa,
                        usuBloqueado = :usuBloqueado 
                    Where usuEmail = :usuEmail";
                $stmt = $conn = new Connection();
                $stmt = $conn->getInstance()->prepare($sql2);
                $stmt->bindValue(':usuEmail', $email);
                $stmt->bindValue(':usuTentativa', ($this->getTentativas()+1));
                $stmt->bindValue(':usuBloqueado' ,'SIM');
                
                $stmt->execute();       
            }
         }
            $stmt=$conn->getInstance()->commit(); 
            $stmt = null;
            
            if (isset($raw) && $raw > 0){
              $_SESSION['usuNome']=$this->getNome();
              $_SESSION['usuId']=$this->getId();
              $_SESSION['uid']=$this->getUid();
              $_SESSION['tipo']=$this->getTipo();
            
            }
        }catch ( PDOException $e ) {
            // Failed to insert the order into the database so we rollback any changes
            $conn::$instance->rollBack();
            throw $e;
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
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param mixed $emails
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
    }
    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $password
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
    
    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $Nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getSobreNome()
    {
        return $this->sobreNome;
    }

    /**
     * @param mixed $SobreNome
     */
    public function setSobreNome($sobreNome)
    {
        $this->sobreNome = $sobreNome;
    }

    /**
     * @return mixed
     */
    public function getTentativas()
    {
        return $this->tentativas;
    }

    /**
     * @param mixed $tentativas
     */
    public function setTentativas($tentativas)
    {
        $this->tentativas = $tentativas;
    }

    /**
     * @return mixed
     */
    public function getBloqueado()
    {
        return $this->bloqueado;
    }

    /**
     * @param mixed $bloqueado
     */
    public function setBloqueado($bloqueado)
    {
        $this->bloqueado = $bloqueado;
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
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getAcesso()
    {
        return $this->acesso;
    }

    /**
     * @param mixed $acesso
     */
    public function setAcesso($acesso)
    {
        $this->acesso = $acesso;
    }



    

    
}

