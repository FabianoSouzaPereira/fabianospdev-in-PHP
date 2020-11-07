<?php
namespace mobile\modulos\modelosRelatorios;

use mobile\modulos\dao\Connection;

/**
 *
 * @author fabiano
 *        
 */
class EstatisticasAcesso
{
    private $conn;
    private $uri;
    private $ip;
    private $data;
    private $user_agent;

    /**
     */
    public function __construct()
    {
        $this->conn = new Connection();
        $this->uri = filter_input(INPUT_SERVER, 'REMOTE_URI', FILTER_DEFAULT);
        $this->ip = '194.153.205.26';//filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
        $cookie = filter_input(INPUT_COOKIE, md5($this->uri), FILTER_DEFAULT);
        $this->user_agent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
        
/*         if (!cookie): 
            $this-> _set_cookie();
            $this->_set_data();
        endif;  */
        
        $this->_set_data(); //isso sai quando pronto
    }
    
    private function _set_cookie(){
        setcookie(md5($this->uri),'celulas', time() + strtotime(date('Y-m-d 23:59:59')) - time());
    }
    
    /** grava no banco a data  */
    private function _set_data(){
        $geo = json_decode(file_get_contents("http://ip-api.com/json/$this->ip"));
        //data vira um array    
        $this->data['data']=  date('Y-m-d H:m:s');
        $this->data['pagina']= $this->uri;
        $this->data['ip']= $this->ip;
        $this->data['cidade']= (isset($geo->city)) ? $geo->city : 'Desconhecida';
        $this->data['regiao']= (isset($geo->regionName)) ? $geo->regionName : 'Desconhecida';
        $this->data['pais']= (isset($geo->country)) ? $geo->country : 'Desconhecida';
        
        
        var_dump($this->data);
        die();
    }
    

    private function _get_refer(){
        $referer = filter_input(filter_input('HTTP_SERVER', 'HTTP_REFERER',FILTER_VALIDATE_URL));
        $referer_host = parse_url($referer, PHP_URL_HOST);
        $host = filter_input(INPUT_SERVER, 'SERVER_NAME');
        
        if(!$referer):
            $retorno = 'Acesso direto';
        elseif ($referer_host == $host):
            $retorno = 'NAvaegação Interna';
        else:
            $retorno = $referer;
        endif;
        
        return $retorno;          
        
    }


    
}//fim da classe




