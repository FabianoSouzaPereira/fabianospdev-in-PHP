<?php
use mobile\modulos\Igreja;
use mobile\functions\Validador;

require 'init.php';
include_once '../mobile/modulos/Igreja.php';
include_once '../mobile/functions/Validador.php';
include_once '../js/functions.js';
?>
<div id="bgigrejas" class="tela">
<div class="formato">
<div class="panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Igrejas</h1>
	</div>
<div class="panel-body">	
<a id="btnCriaIgreja" href="index.php?page=site_view_churchCreateView" style="background-color: green;" class="btn btn-primary btn-novo"><span class="glyphicon glyphicon-plus"></span> Nova Igreja</a>
<table class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
	<thead>
	<tr>
		<th style='color: red;'>Igreja</th>
		<?php if($_SESSION['tipo']> '3'){
		  echo "<th style='color: red;width:20px !important;'>Ver</th>";
		}else{
		  echo "<th style='color: red;width:20px !important;'Editar</th>";
		}
		?>
	</tr>
</thead>
	<tbody>
	<?php 
	$igr = new Igreja();
	$logtipo=null;
	$ret=null;
	$logtipo=$_SESSION['tipo'];
	
    try{
        switch ($logtipo) {
                case 1: $igr->adminRead();
                        $ret = $igr->getDados();
                   break;
                case 2: $igr->coordenadorRead();
                        $ret = $igr->getDados();
                   break;
                case 3: $igr->pastorRead();
                        $ret = $igr->getDados();
                   break;
                case 4: $igr->liderRead();
                        $ret = $igr->getDados();
                   break;
                case 5: $igr->colaboradorRead();
                        $ret = $igr->getDados();
                   break;
                case 6: $igr->comumRead();
                        $ret = $igr->getDados();
                   break;
                case 7: '0';
                   break;
                default:
                    ;
                break;
      }

    	$data=null;
    	if($ret > 0 ){
    	    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>";
    	    echo "<script>$(function(){ $('#btnCriaIgreja').hide(); });</script>";
    	}
        $sec=1;
        if(is_array($ret)){
            $id=null; $igreja=null;
            Foreach($ret as $raw) {
                $id= $raw['chuId']; $igreja= $raw['chuIgreja']; $endereco= $raw['chuEndereco']; $bairro= $raw['chuBairro']; 
                $cidade= $raw['chuCidade'];$estado= $raw['chuEstado']; $pais= $raw['chuPais']; $cep= $raw['chuCep'];
                $data= $raw['chuData'];$telefone= $raw['chuTelefone'];$email= $raw['chuEmail']; $regiao=$raw['chuRegiao']; 
                $status=$raw['chuStatus'];       
                echo "<tr>"; 
                echo "<td style='text-transform:uppercase; color: black;'>", $igreja,"</td>";
                if($_SESSION['tipo']> '3'){
                        echo "<td><a href='index.php?page=site_view_churchDetailsView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></a></td>";
                }else{
                        echo "<td style='width:20px !important;'><a href='index.php?page=site_view_churchUpdateView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-edit'></span></a></td>";
                }
                echo "</tr>";
            }
            $_SESSION['igrejaId']=$id;  $_SESSION['igrejaNome']=$igreja;
          }   
    	}catch (PDOException $error) {
    	    echo "Error ".$error->getMessage();
    	}
    	
	?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="13" class="text-center"> <?php date('d/m/Y h:i:s'); ?></th>
		</tr>
	</tfoot>
 </table>
 </div>
 </div>
 </div>
