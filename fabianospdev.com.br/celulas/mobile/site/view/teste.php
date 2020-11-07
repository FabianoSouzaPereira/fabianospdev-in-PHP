<?php

use mobile\modulos\Celula;

include_once 'init.php';
include_once '../mobile/modulos/Celula.php';


$id=null;
$ret=null;
$cel=new Celula();
$cel->lastId();
$id=$cel->getLastId();
    $celup= new Celula();
    $celup->setId('32');
    $celup->setCelula('teste');
    $celup->setRede('ff');
    $celup->setLider('dd');
    $celup->setViceLider('gt');
    $celup->setSecretario('gdg');
    $celup->setAnfitriao('gdfg');
    $celup->setColaborador('');
    $celup->setData('2019-02-01');
    $celup->setDia('d');
    $celup->setHora('20:00');
    $celup->setCeluserid('1');
    $celup->setStatus('1');
    
    $celup->insertCelula();

?>

oi