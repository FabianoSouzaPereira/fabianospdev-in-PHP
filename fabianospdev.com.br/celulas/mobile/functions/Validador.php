<?php
namespace mobile\functions;
use application\modulos\dao\Connection;
use PDO;
class Validador
{

    public function __construct()
    {}

    function __destruct()
    {}

    
    /**
     * Função para converter a data de usuário para data de banco de dados
     * Converte data dia/mes/ano em ano-mes-dia
     * @param $data - no formato dd/mm/aaaa
     * @return string com data no formato aaaa-mm-dd
     */
    public static function dataToBanco($data){
        
        $vetorData = explode("/", $data);
        $vetorDataInvertido = array_reverse($vetorData);
        $dataBanco = implode("-", $vetorDataInvertido);
        
        return $dataBanco;
        
    }
    
    
    /**
     * Função para converter a data de banco de dados para data de usuário
     * Converte data ano-mes-dia em dia/mes/ano
     * @param $data - no formato aaaa-mm-dd
     * @return string com data no formato dd/mm/aaaa
     */
    public static function bancoToUser($data){
        
        $vetorData = explode("-", $data);
        $vetorDataInvertido = array_reverse($vetorData);
        $dataUsuario = implode("/", $vetorDataInvertido);
        
        return $dataUsuario;
        
    }
   
}

