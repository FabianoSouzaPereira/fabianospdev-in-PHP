<?php  ob_start();
        if (! isset($_SESSION)) {
            session_start();
        }
        
 // header('location: mobile/index.php');
//  exit();

require 'Mobile-Detect-2.8.34/Mobile_Detect.php';
$detect= new Mobile_Detect;
if($detect->isMobile()){
   header('location: mobile/index.php');
   exit();
   
}else
    {

        if (! isset($_SESSION)) {
            session_start();
        }
        
        if( !(isset($_SESSION['login']) && $_SESSION['login'] == true) ){
            header('location: loginView.php');
            exit();
        } 
        
        if( ($_SESSION['tipo'] == '1') || ($_SESSION['tipo'] == '2') ){
            header('location: application/index.php');
            exit();
        } 
        
        require 'init.php';
        require_once 'application/modulos/dao/Connection.php';
        
        $fullpath="";
        $ret = array();
        
        if(strpos($_SERVER['REQUEST_URI'],"=") != 0){
            
            $url= Urlnow();
            
        }else {
           
           $url= 'celulas.fabianospdev.com.br/index.php';}
           $ret = viewpage($url);
        
        
        if((isset($ret) !== false) && $ret !== ""){
            $fullpath = $ret[0].'/'.$ret[1].'/'.$ret[2].'.php';
        }else{
            $fullpath = "begin.php";
        }
        
        include_once 'indexView.php';


    }//fim do else inicial
    
?>

