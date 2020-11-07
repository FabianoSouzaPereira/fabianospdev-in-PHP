<?php

use modulos\Usuario;

require 'init.php';
include_once '../application/modulos/Usuario.php';
include_once '../js/functions.js';

?>
<div id="userRead" class="panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Usuários </h1>
	</div>
<div class="panel-body">	
<a href="index.php?page=modulos_view_userCreateView" style="background-color: green;" class="btn btn-primary  btn-novo"><span class="glyphicon glyphicon-plus"></span> Novo Usuário</a>
<table class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
	<thead>
	<tr>
		<th></th>
		<th style='color: red;'>Email</th>
		<th style='color: red;'>Nome</th>
		<th style='color: red;'>Sobre Nome</th>
	 	<th style='color: red;'>Bloqueado</th>
		<th style='color: red;'>Mais</th>
		<th style='color: red;'>Editar</th>
	</tr>
</thead>
	<tbody>
	<?php 
	$usu = new Usuario(); 
	$id=null;
    try{
        if(isset($id) && $id > 0){
            $usu->readById($id);
        }else{
            $usu->read();
        }

    $ret = $usu->getDados();
    $sec=1;
        if(is_array($ret)){
            Foreach($ret as $raw) {
                $id= $raw['usuId']; $usuario= $raw['usuuid']; $email= $raw['usuEmail']; $nome= $raw['usuNome']; 
                $sobrenome= $raw['usuSobreNome'];$senha= $raw['usuSenha']; $tentativa= $raw['usuTentativa']; 
                $bloqueado= $raw['usuBloqueado']; $data= $raw['usuData'];$tipo= $raw['usuTipo'];$acesso= $raw['usuAcesso'];
            echo "<tr>"; 
            echo "<td style='text-transform:uppercase; color: black;'>", $sec++ ,"</td>";
            echo "<td style='color: black;'>", $email,"</td>";
            echo "<td style='text-transform:uppercase; color: black;'>", $nome,"</td>";
            echo "<td style='text-transform:uppercase; color: black;'>", $sobrenome,"</td>";
            echo "<td style='text-transform:uppercase; color: black;'>", $bloqueado,"</td>";
            echo "<td><a href='index.php?page=modulos_view_userDetailsView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></a></td>";
            echo "<td><a href='index.php?page=modulos_view_userUpdateView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-edit'></span></a></td>";
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
			<th colspan="13" class="text-center"><?php  date('d/m/Y h:i:s'); ?></th>
		</tr>
	</tfoot>
 </table>
 </div>
</div>