<?php

try {
    switch ($_SESSION['tipo']) {
            case 1:
                $cel->ReadCelulas();
                break;
            case 2:
                $cel->coordenadorReadCelulas();
                break;
            case 3:
                $cel->pastorReadCelulas();
                break;
            case 4:
                $cel->liderReadCelulas();
                break;
            case 5:
                $cel->colaboradorReadCelulas();
                break;
            case 6:
                $cel->comumReadCelulas();
                break;
            case 7:
                echo "Sem Acesso a nada";
                break;
            Default: 
                echo "Sem acesso";
                break;
          }
        
} catch (Exception $e) {
}