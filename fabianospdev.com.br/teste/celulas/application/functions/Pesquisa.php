<?php
namespace application\functions;

use application\modulos\dao\Connection;
use Exception;
use PDO;

/**
 *
 * @author fabiano
 *
 */
class Pesquisa
{
    
    private $dados_estados;
    private $dados_cidades;
       
    /**
     */
    public function __construct(){ }  

    function __destruct(){ }
    
     
    function getEstados(){
        try{
            $query="SELECT id, uf, nome FROM tb_estados;";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados_estados($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    function getCidades($uf){
        try{
            $query="SELECT uf, nome FROM tb_cidades WHERE uf = '$uf';";
            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                while ($raw=$stmt->fetchAll(PDO::FETCH_ASSOC)){
                    $this->setDados_cidades($raw);
                }
            }
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";
            echo $e->getMessage();
            exit;
        }
    }
    
    function getPaises(){
        try{
            $query="";
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
    
    function getRede(){
        try{
            $query="";
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
     * @return mixed
     */
    public function getDados_estados()
    {
        return $this->dados_estados;
    }
    
    /**
     * @param mixed $dados_estados
     */
    public function setDados_estados($dados_estados)
    {
        $this->dados_estados = $dados_estados;
    }
    
    /**
     * @return mixed
     */
    public function getDados_cidades()
    {
        return $this->dados_cidades;
    }
    
    /**
     * @param mixed $dados_cidades
     */
    public function setDados_cidades($dados_cidades)
    {
        $this->dados_cidades = $dados_cidades;
    }
    
    
}

