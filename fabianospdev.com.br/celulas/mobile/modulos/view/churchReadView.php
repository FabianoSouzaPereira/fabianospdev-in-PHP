<?php
use modulos\Igreja;

require 'init.php';
include_once '../application/modulos/Igreja.php';
include_once '../js/functions.js';

?>

<div class="panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Igrejas</h1>
	</div>
<div class="panel-body">	
<a href="index.php?page=modulos_view_churchCreateView" style="background-color: green;" class="btn btn-primary btn-novo"><span class="glyphicon glyphicon-plus"></span> Nova Igreja</a>
<table class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
	<thead>
	<tr>
		<th></th>
		<th style='color: red;'>Igreja</th>
		<th style='color: red;'>Região</th>
		<th style='color: red;'>Cidade</th>
		<th style='color: red;'>Telefone</th>
		<th style='color: red;'>Email</th>
		<th style='color: red;'>Mais</th>
		<th style='color: red;'>Editar</th>
	</tr>
</thead>
	<tbody>
	<?php 
	$igr = new Igreja(); 
	$id=null;
    try{
        if(isset($id) && $id > 0){
            $igr->readById($id);
        }else{
            $igr->read();
        }

        $ret = $igr->getDados();
    	$data=null;
        $sec=1;
        if(is_array($ret)){
            Foreach($ret as $raw) {
                $id= $raw['chuId']; $igreja= $raw['chuIgreja']; $endereco= $raw['chuEndereco']; $bairro= $raw['chuBairro']; 
                $cidade= $raw['chuCidade'];$estado= $raw['chuEstado']; $pais= $raw['chuPais']; $cep= $raw['chuCep'];
                $data= $raw['chuData'];$telefone= $raw['chuTelefone'];$email= $raw['chuEmail']; $regiao=$raw['chuRegiao']; 
                $status=$raw['chuStatus'];       
                echo "<tr>"; 
                echo "<td style='text-transform:uppercase; color: black;'>", $sec++ ,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $igreja,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $regiao,"° REGIÃO</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $cidade,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $telefone,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $email,"</td>";
                echo "<td><a href='index.php?page=site_view_churchDetailsView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></a></td>";
                echo "<td><a href='index.php?page=site_view_churchUpdateView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-edit'></span></a></td>";
                echo "</tr>";
            }
     
          }   
    	}catch (PDOException $error) {
    	    echo "Error ".$error->getMessage();
    	}
    	
	?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="13" class="text-center"> <?php echo date('d/m/Y h:i:s'); ?></th>
		</tr>
	</tfoot>
 </table>
 </div>
 
