<?php

/** Return text after sinal '=' , if there isn't this sinal return only 'REQUEST_URI'
 *
 * @return $url
 *
 * */
function urlnow(){
    $url1 = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '='));
    $url2 = explode("=",$url1);
    $url = $url2[1];
    
    return $url;
}





/** Return text word 'public' , if there isn't this sinal return only 'REQUEST_URI'
 *
 * @return $url
 *
 * */
function urlpublic(){
    $url1 = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], 'public/'));
    $url2 = explode("public/",$url1);
    $url = $url2[1];
    
    return $url;
}

/** Return text word 'application' , if there isn't this sinal return only 'REQUEST_URI'
 *
 * @return $url
 *
 * */
function urlapplication(){
    $url1 = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], 'application/'));
    $url2 = explode("application/",$url1);
    $url = $url2[1];
    
    return $url;
}
?>