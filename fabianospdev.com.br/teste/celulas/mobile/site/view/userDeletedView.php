<?php

use mobile\modulos\Usuario;

require 'init.php';
include_once '../mobile/modulos/Usuario.php';


?>

<div id="userDelete" class="panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Usuários que foram Apagados</h1>
	</div>
<div class="panel-body">	
<a href="index.php?page=site_view_userCreateView" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Novo Usuário</a>
<a href="index.php?page=site_view_userDeleteView" class="btn btn-primary"><span class="glyphicon glyphicon-minus"></span> Apagar Usuário</a>
<table class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
	<thead>
	<tr>
		<th></th>
		<th style='color: red;'>Nome</th>
		<th style='color: red;'>Sobre Nome</th>
		<th style='color: red;'>Status</th>
		<th style='color: red;'>Reativar</th>
		<th style='color: red;'>Remover</th>
	</tr>
</thead>
	<tbody>
	<?php 
	$usu = new Usuario(); 
	$id=null;
    try{

    $usu->pastorReadDeleteds();
    $ret = $usu->getDados();
    $data = array();
    $sec=1;
        if(is_array($ret)){
            Foreach($ret as $raw) {
                $id= $raw['usuId']; $usuario= $raw['usuuid']; $email= $raw['usuEmail']; $nome= $raw['usuNome']; $sobrenome= $raw['usuSobreNome'];$senha= $raw['usuSenha']; $tentativa= $raw['usuTentativa']; $bloqueado= $raw['usuBloqueado'];$data= $raw['usuData'];$tipo= $raw['usuTipo'];$acesso= $raw['usuAcesso'];
                $status=$raw['usuStatus']; $data = array("id"=>$id,"usuuid"=>$usuario); 
                echo "<tr>"; 
                echo "<td style='text-transform:uppercase; color: black;'>", $sec++ ,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $nome,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $sobrenome,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", ($status == 0)?'INATIVO':'ATIVO',"</td>";
                echo "<td><a id='ativa' href='index.php?page=site_view_userAtiva&id=$id&usuuid=$usuario' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></a></td>";
                echo "<td><a href='index.php?page=site_view_userDeleteforever&id=$id&au=delpen' class='btn btn-primary'><span class='glyphicon glyphicon-remove'></span></a></td>";
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
