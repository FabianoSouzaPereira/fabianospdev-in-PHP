<?php
namespace application\modulos\modelosRelatorios;

use application\modulos\dao\Connection;
use Exception;
use PDO;


/**
 *
 * @author fabiano
 *        
 */
class Estatisticas
{
    private $totaligrejas=null;
    private $totalcelulas=null;
    private $totalrelatorios=null;
    private $totalrelatoriosA=null;
    private $totalrelatoriosB=null;
    private $totalusuarios=null;
    
    private $totalvisitantes=null;
    private $totalconvidados=null;
    private $totalmembros=null;
    private $totalcriancas=null;
    private $totaljovens=null;
    private $totaladultos=null;
    private $totalpresentes=null;
    private $totalaceitou=null;
    private $totaltestemunho=null;   
    private $celula=null;
    private $celulaMaisVisitantes=null;
    private $celulamenosVisitantes=null;
    private $dadosMaisVisitantes=null;
    private $dadosMenosVisitantes=null;   
    private $pessoasPorReuniao=null;
    private $pessoasRelatorios=null;
    

    /**
     */
    public function __construct()
    {

      self::_countIgrejas();
      self::_countCelulas();
      self::_countRelatoriosA();
      self::_celulaMaisVisitantes();
      self::_celulamenosVisitantes();
      self::_descobremes();
      self::_pessoas_por_reuniao();
      self::_quantidadesRelatorios();
    }

    /**
     */
    function __destruct()
    {

        // TODO - Insert your code here
    }

    /** Conta quantidade total de igrejas que o usuario tem acesso em todo os períodos; */
     private function _countIgrejas()
     {
        try{

        $query="SELECT COUNT(chuId) , chuStatus FROM `igrejas` "
                ."GROUP BY chuId " 
                ."HAVING chuStatus = '1' AND " 
                ."chuid IN(SELECT igreja FROM tabela_acesso_igreja WHERE usuario = '2') "
                ."AND chuStatus = '1' "
                ."ORDER BY chuId "
                ."LIMIT 1001;";

            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $answer=null;$r=null;
                while ($raw = $stmt->fetchAll(PDO::FETCH_ASSOC)) {                  
                    Foreach($raw as $answer) {
                        $this->setTotaligrejas($answer['COUNT(chuId)']!=null?$answer['COUNT(chuId)']:0); 
                    }
                }
            }
        } catch (Exception $e) {
            echo "Erro: Sem registros no banco, ou não foi possível acessa-los.</br>";            echo $e->getMessage();

            exit();
        } 
     }
     
     /** Conta quantidade total de células em todo os períodos; */
     private function _countCelulas()
     {
       try{

        $query="SELECT COUNT(celId) FROM `celulas` WHERE celStatus = '1';";

            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $answer=null;
                while ($raw = $stmt->fetchAll(PDO::FETCH_ASSOC)) {                   
                    Foreach($raw as $answer) {
                        $this->setTotalcelulas($answer['COUNT(celId)']!=null?$answer['COUNT(celId)']:0);       
                    }
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }  
     }
     
     /** Conta quantidade total de relatórios do tipo A em todo os períodos; 
      *  E retorna também número total de vizitantes;
      */
     private function _countRelatoriosA()
     {
       try{

        $query="SELECT COUNT(relAid),SUM(relVisitantes) FROM `relatoriosa` WHERE relStatus = '1';";

            $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $answer=null;
                while ($raw = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                    Foreach($raw as $answer) {
                    $this->setTotalrelatoriosA($answer['COUNT(relAid)']!=null?$answer['COUNT(relAid)']:0);
                    $this->setTotalVisitantes($answer['SUM(relVisitantes)']!=null?$answer['SUM(relVisitantes)']:0);
                    }
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }   
     }
     
     /** Pega número MÁXIMO de visitantes da VIEW relatoriosum 
      *  que faz select na TABLE relatoriosa e TABLE celulas nos ultimos
      *  30 dias; 
      */
     private function _celulaMaisVisitantes()
     {
      
      try{
      $query="select * "
            ."from `relatoriosum` as t "
            ."where visitantes = (SELECT MAX(visitantes) FROM `relatoriosum`);";
      $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $visitantes=array();
                $ret=null;
                  
                while ($raw = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                    Foreach($raw as $answer) {
                    $this->setDadosMaisVisitantes($raw);
                  }
              }               
          }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }      
     }
     
     /** Pega número MÍNIMO de visitantes da VIEW relatoriosum 
      *  que faz select na TABLE relatoriosa e TABLE celulas nos ultimos
      *  30 dias; 
      */
     private function _celulaMenosVisitantes()
     {
      
      try{
      $query="select * "
            ."from `relatoriosum` as t "
            ."where visitantes = (SELECT MIN(visitantes) FROM `relatoriosum`);";
      $stmt = $conn = new Connection();
            $stmt = $conn->getInstance()->prepare($query);
            if ($stmt->execute()) {
                $answer=null;
            while ($raw = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                Foreach($raw as $answer) {
                $this->setDadosMenosVisitantes($raw);
                }
               }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }      
     }

     
     function _descobremes(){
            $mes=  date('m');
            if($mes){
                switch ($mes){
                     case '01':'janeiro';
                    break;
                    case '02':'fevereiro';
                    break;
                    case '03':'março';
                    break;
                    case '04':'abril';
                    break;
                    case '05':'maio';
                    break;
                    case '06':'junho';
                    break;
                    case '07':'julho';
                    break;
                    case '08':'agosto';
                    break;
                    case '09':'setembro';
                    break;
                    case '10':'outubro';
                    break;
                    case '11':'novembro';
                    break;
                    case '12':'dezembro';
                    break;                  
                }                
            }
        }

        
        
        
    //INICIO GRAFICOS
    
    /** Select do nome das celulas e Total de presentes;  */
    public function _pessoas_por_reuniao(){
    $id=$_SESSION['id'];
    try{
        $query="select c.celId,c.celStatus, c.celCelula as celula,SUM(r.relVisitantes) as totalVisitantes,r.relData, SUM(r.relTotal)  as totalpessoas ,r.relStatus "
                ."from `relatoriosa` as r  "
                ."INNER JOIN `celulas` as c "
                ."ON r.relCelula = c.celId "
                ."GROUP BY c.celId "
                ."HAVING r.relData BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() "
                ."AND c.celStatus = '1' AND r.relStatus = '1' "
                ."AND c.celId IN(SELECT celulas FROM tabelasacessos WHERE status = '1' AND usuario = '$id') " 
                ."ORDER BY celId "
                ."LIMIT 1001;";

        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        $dados=null;
        if ($stmt->execute()) {
            $answer=null;//$i=0;
           $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);                  
         //   Foreach($raw as $answer) :                         //Sintaxe Alternativa para estruturas de controle;
         //      $dados[$answer['celula']] = $answer['total'];  //armazenando na var dados celula como                                                                  
        //    endforeach;                                       //índice e total como o valor;
            }
            
          return $raw; 
           
        } catch (Exception $e) {
           echo $e->getMessage();
           exit();
        }  
    }
    

   //FINAL GRAFICOS 
        
        
       /** Select da tabela relatorios */
    public function _quantidadesRelatorios(){
    $id=$_SESSION['id'];
    try{
        $query="SELECT c.celId,c.celStatus, c.celCelula as celula, r.relData as data ,r.relStatus,"
                ."SUM(r.relMembros) as TotalMembros," 
                ."SUM(r.relBase) as TotalBase," 
                ."SUM(r.relAdultos) as TotalAdultos," 
                ."SUM(r.relVisitantes) as TotalVisitantes, " 
                ."SUM(r.relJovens) as TotalJovens "
                ."from `relatoriosa` as r  "
                ."INNER JOIN `celulas` as c "
                ."ON r.relCelula = c.celId "
                ."GROUP BY c.celId "
                ."HAVING r.relData BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() "
                ."AND c.celStatus = '1' AND r.relStatus = '1' "
                ."AND c.celId IN(SELECT celulas FROM tabelasacessos WHERE status = '1' AND usuario = '$id') "
                ."ORDER BY celId "
                ."LIMIT 1001;";

        $stmt = $conn = new Connection();
        $stmt = $conn->getInstance()->prepare($query);
        if ($stmt->execute()) {
           $answer=null;
           $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);  
           
            Foreach($raw as $answer) :   
            $this->setPessoasRelatorios($raw);                                  
            endforeach; 
            
           }          
        } catch (Exception $e) {
           echo $e->getMessage();
           exit();
        }  
    }
     
        
        
    /**
     * @return mixed
     */
    public function getTotaligrejas()
    {
        return $this->totaligrejas;
    }

    /**
     * @param mixed $totaligrejas
     */
    public function setTotaligrejas($totaligrejas)
    {
        $this->totaligrejas = $totaligrejas;
    }

    /**
     * @return mixed
     */
    public function getTotalcelulas()
    {
        return $this->totalcelulas;
    }

    /**
     * @param mixed $totalcelulas
     */
    public function setTotalcelulas($totalcelulas)
    {
        $this->totalcelulas = $totalcelulas;
    }

    /**
     * @return mixed
     */
    public function getTotalrelatorios()
    {
        return $this->totalrelatorios;
    }

    /**
     * @param mixed $totalrelatorios
     */
    public function setTotalrelatorios($totalrelatorios)
    {
        $this->totalrelatorios = $totalrelatorios;
    }

    /**
     * @return mixed
     */
    public function getTotalrelatoriosA()
    {
        return $this->totalrelatoriosA;
    }

    /**
     * @param mixed $relatoriosA
     */
    public function setTotalrelatoriosA($totalrelatoriosA)
    {
        $this->totalrelatoriosA = $totalrelatoriosA;
    }

    /**
     * @return mixed
     */
    public function getTotalrelatoriosB()
    {
        return $this->totalrelatoriosB;
    }

    /**
     * @param mixed $relatoriosB
     */
    public function setTotalrelatoriosB($totalrelatoriosB)
    {
        $this->totalrelatoriosB = $totalrelatoriosB;
    }

    /**
     * @return mixed
     */
    public function getTotalusuarios()
    {
        return $this->totalusuarios;
    }

    /**
     * @param mixed $totalusuarios
     */
    public function setTotalusuarios($totalusuarios)
    {
        $this->totalusuarios = $totalusuarios;
    }

    /**
     * @return mixed
     */
    public function getTotalvisitantes()
    {
        return $this->totalvisitantes;
    }

    /**
     * @param mixed $totalvisitantes
     */
    public function setTotalvisitantes($totalvisitantes)
    {
        $this->totalvisitantes = $totalvisitantes;
    }

    /**
     * @return mixed
     */
    public function getTotalconvidados()
    {
        return $this->totalconvidados;
    }

    /**
     * @param mixed $totalconvidados
     */
    public function setTotalconvidados($totalconvidados)
    {
        $this->totalconvidados = $totalconvidados;
    }

    /**
     * @return mixed
     */
    public function getTotalmembros()
    {
        return $this->totalmembros;
    }

    /**
     * @param mixed $totalmembros
     */
    public function setTotalmembros($totalmembros)
    {
        $this->totalmembros = $totalmembros;
    }

    /**
     * @return mixed
     */
    public function getTotalcriancas()
    {
        return $this->totalcriancas;
    }

    /**
     * @param mixed $totalcriancas
     */
    public function setTotalcriancas($totalcriancas)
    {
        $this->totalcriancas = $totalcriancas;
    }

    /**
     * @return mixed
     */
    public function getTotaljovens()
    {
        return $this->totaljovens;
    }

    /**
     * @param mixed $totaljovens
     */
    public function setTotaljovens($totaljovens)
    {
        $this->totaljovens = $totaljovens;
    }

    /**
     * @return mixed
     */
    public function getTotaladultos()
    {
        return $this->totaladultos;
    }

    /**
     * @param mixed $totaladultos
     */
    public function setTotaladultos($totaladultos)
    {
        $this->totaladultos = $totaladultos;
    }

    /**
     * @return mixed
     */
    public function getTotalpresentes()
    {
        return $this->totalpresentes;
    }

    /**
     * @param mixed $totalpresentes
     */
    public function setTotalpresentes($totalpresentes)
    {
        $this->totalpresentes = $totalpresentes;
    }

    /**
     * @return mixed
     */
    public function getTotalaceitou()
    {
        return $this->totalaceitou;
    }

    /**
     * @param mixed $totalaceitou
     */
    public function setTotalaceitou($totalaceitou)
    {
        $this->totalaceitou = $totalaceitou;
    }

    /**
     * @return mixed
     */
    public function getTotaltestemunho()
    {
        return $this->totaltestemunho;
    }

    /**
     * @param mixed $totaltestemunho
     */
    public function setTotaltestemunho($totaltestemunho)
    {
        $this->totaltestemunho = $totaltestemunho;
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
    public function getCelulaMaisVisitantes()
    {
        return $this->celulaMaisVisitantes;
    }

    /**
     * @param mixed $celulaMaisVisitantes
     */
    public function setCelulaMaisVisitantes($celulaMaisVisitantes)
    {
        $this->celulaMaisVisitantes = $celulaMaisVisitantes;
    }
    /**
     * @return mixed
     */
    public function getCelulamenosVisitantes()
    {
        return $this->celulamenosVisitantes;
    }

    /**
     * @param mixed $celulamenosVisitantes
     */
    public function setCelulamenosVisitantes($celulamenosVisitantes)
    {
        $this->celulamenosVisitantes = $celulamenosVisitantes;
    }
    /**
     * @return mixed
     */
    public function getDadosMaisVisitantes()
    {
        return $this->dadosMaisVisitantes;
    }

    /**
     * @param mixed $dadosMaisVisitantes
     */
    public function setDadosMaisVisitantes($dadosMaisVisitantes)
    {
        $this->dadosMaisVisitantes = $dadosMaisVisitantes;
    }

    /**
     * @return mixed
     */
    public function getDadosMenosVisitantes()
    {
        return $this->dadosMenosVisitantes;
    }

    /**
     * @param mixed $dadosMenosVisitantes
     */
    public function setDadosMenosVisitantes($dadosMenosVisitantes)
    {
        $this->dadosMenosVisitantes = $dadosMenosVisitantes;
    }
    /**
     * @return mixed
     */
    public function getPessoasPorReuniao()
    {
        return $this->pessoasPorReuniao;
    }

    /**
     * @param mixed $pessoasPorReuniao
     */
    public function setPessoasPorReuniao($pessoasPorReuniao)
    {
        $this->pessoasPorReuniao = $pessoasPorReuniao;
    }
    /**
     * @return mixed
     */
    public function getPessoasRelatorios()
    {
        return $this->pessoasRelatorios;
    }

    /**
     * @param mixed $pessoasRelatorios
     */
    public function setPessoasRelatorios($pessoasRelatorios)
    {
        $this->pessoasRelatorios = $pessoasRelatorios;
    }






     

}//fim classe


   
