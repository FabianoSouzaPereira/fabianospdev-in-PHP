<?php
/** Return text after sinal '=' , if there isn't this sinal return only 'REQUEST_URI' 
 * 
 * @return $url 
 * 
 * */
function Urlnow(){
    $url1 = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '='));
    $url = explode("=",$url1);
    $url = $url[1];

    return $url;
}

/** pick up a underline sinal from  url, and split url in three parts 
 * @param $v 
 * @return $ret 
 * 
 * */
function viewpage($v){
    $ret = "";
    if( isset($v) && $v !== "begin.php" ){
        if(strpos($v, "_")!=0){
            $vet = explode("_", $v);
            $view = $vet[0];
            $file = $vet[1];
            $v= cut_param($vet[2]);
            $action = $v[0];
            $ret = array($view,$file,$action,$v);
        }else{
            $view = "";
            $file = "";
            $action = "";
            $ret = "";
            $v = "";
        }
    }
    return $ret;
}

/** pick up '&' from vet[2]; Could've variables from url; 
 * @param $par
 * */
function cut_param($param){
    if(isset($param) && $param !== Null){
        if(strpos($param,"&") !== 0){
            $par = explode("&",$param);
        }else{ 
            $par=null;
        }
        return $par;
    }
}


?>