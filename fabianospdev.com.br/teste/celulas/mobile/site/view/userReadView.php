<?php

use mobile\modulos\Usuario;

require 'init.php';
include_once '../mobile/modulos/Usuario.php';

?>
<div class="tela">
<div class="formato">
<div id="userRead" class="panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Usuários </h1>
	</div>
<div class="panel-body">	
<div>
<a href="index.php?page=site_view_userCreateView" style="background-color: green; margin:3px;" class="btn btn-primary  btn-novo"><span class="glyphicon glyphicon-plus"></span> Novo Usuário</a>
<a href="" data-toggle="modal" data-target="#modal-associaCelula" style="margin:3px;">
		<button id="btnassociaCelula" class="btn btn-primary btn-associa"><span class="glyphicon glyphicon-export"></span>  Associar Célula</button></a>
<input type="text" id="pesquisauser" class="form-control sombra-efe" style="display:inline-block;width:200px;margin:3px;"  placeholder="Pesquisa...">
</div>
<table class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
<thead>
	<tr id="first">
		<th></th>
		<th style='color: red;'>Nome</th>
		<th style='color: red;'>Editar</th>
	</tr>
</thead>
	<tbody>
	<ul id="userlist">
	<?php 
	$logtipo=null;
	$logtipo=$_SESSION['tipo'];
	$usu = new Usuario(); 
	$id=null;
    try{
        switch ($logtipo) {
                case 1: $usu->adminRead();
                        $ret = $usu->getDados();
                   break;
                case 2: $usu->coordenadorRead();
                        $ret = $usu->getDados();
                   break;
                case 3: $usu->pastorRead();
                        $ret = $usu->getDados();
                   break;
                case 4: $usu->liderRead();
                        $ret = $usu->getDados();
                   break;
                case 5: $usu->colaboradorRead();
                        $ret = $usu->getDados();
                   break;
                case 6: $usu->comumRead();
                        $ret = $usu->getDados();
                   break;
                case 7: '0';
                   break;
                default:
                    ;
                break;
            }
    $ret = $usu->getDados();
    $sec=1;
        if(is_array($ret)){
            Foreach($ret as $raw) {
                $id= $raw['usuId']; $usuario= $raw['usuuid']; $email= $raw['usuEmail']; $nome= $raw['usuNome']; 
                $sobrenome= $raw['usuSobreNome'];$senha= $raw['usuSenha']; $tentativa= $raw['usuTentativa']; 
                $bloqueado= $raw['usuBloqueado']; $data= $raw['usuData'];$tipo= $raw['usuTipo'];$acesso= $raw['usuAcesso'];
              switch ($tipo) {
                case 1: $strTipo = 'ADMINISTRADOR';                 
                   break;
                case 2: $strTipo = 'COORDENADOR';
                   break;
                case 3: $strTipo = 'PASTOR';                
                   break;
                case 4: $strTipo = 'LIDER';
                   break;
                case 5: $strTipo = 'COLABORADOR';
                   break;
                case 6: $strTipo = 'COMUM';
                   break;
                case 7: $strTipo = 'SEM ACESSO';
                   break;
                default:
                    ;
                break;
            }
            echo "<tr>"; 
            echo "<td style='text-transform:uppercase; color: black;'>", $sec++ ,"</td>";
          /*   echo "<td style='color: black;'>", $email,"</td>"; */
            echo "<td data-name='$nome' style='text-transform:uppercase; color: black;'>", $nome,"</td>";
            echo "<td data-id='$id'><a href='index.php?page=site_view_userUpdateView&id=$id' class='btn btn-primary btn-lista'><span class='glyphicon glyphicon-edit'></span></a></td>";
            echo "</tr>";
            }   
         }  
    	}catch (PDOException $error) {
    	    echo "Error ".$error->getMessage();
    	}
    	
	?>
	</ul>
	</tbody>
 </table>
 </div>
</div>
</div>
<!-- Modal para escolher igreja e celula -->
<div style="margin: 15% auto 20% auto;width:75%;height:70%" id="modal-associaCelula" class="modal fade modal-dialog-centered" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div id="selects" class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Para qual celula ? </h2>
         <select id="usuarios" name="usuarios" class="form-control" style="margin:10px auto 0px auto;width:80%;height:30px;font-size:10px;">
        	<option value="" >Selecione um usuário</option>
        </select>
         <select id="celulas" name="celulas" class="form-control" style="margin:10px auto 0px auto;width:80%;height:30px;font-size:10px;">
        	<option value="SELECIONE">Selecione uma célula</option>
        </select>
        <select id="" name="" class="form-control carregandoCel" style="display:none;margin:10px auto 0px auto;width:80%;height:40px;font-size:10px;">
        	<option value="">carregando...</option>
        </select>
      </div>
      <div class="modal-body" >
		<form action="" method="get" class="form-inline" style="margin:0px 0px -15px 0px;">
		<a href="index.php?pag=site_view_associausuario"
			style="background-color:red;margin: 5px auto 0px auto;width: 80px;height: 30px;font-size: 12px;" 
			class="btn btn-primary btn-lg btn-block" id="btnAssociaUsuario">Ok</a>
		<br />
		</form>
      </div>
      <div class="modal-footer">
      <p style="display: inline-block; float: left;margin-left:-15px;color:green;font-style: inherit; font-size:12px";>Filtrado conforme suas permissões de usuário</p>
        <button type="button" class="btn btn-default btn-inline" data-dismiss="modal" style="font-size:12px"><span class="glyphicon glyphicon-remove"> </span> Fechar</button>	       
      </div>
    </div>	
  </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $(document).on('click', 'tr', function(e) {
        e.preventDefault; 
        $('tbody tr').css( "background-color", "" );
        $('tbody tr').not($(this).siblings()).css( "background-color", "#40e883" );  //#d6c4ab
		var id="";   var nome="";
        id = $(this).closest('tr').find('td[data-id]').data('id');
        nome = $(this).closest('tr').find('td[data-name]').data('name');
		
        $.getJSON(
			'site/pesquisa.php',
            {
			id : id,
			nome : nome,
			ajax : 'true'        	
            },function(b){
            var options;
  	          for (var x = 0; x < b.length; x++) {
  	            options += '<option value="' +
  	              b[x].id + '">' +
  	              b[x].nome + '</option>';
  	          }

    	     $('#usuarios').html(options).show();
      	     $('.carregandoCel').hide();
         });
    });
});

</script>
<script type="text/javascript">
$(function(){
	  $('#btnassociaCelula').click(function(){
		  var igreja = $('#dados_gerais #nomeIgreja').html(); 
		  if(igreja){
	      $('#celulas').hide();
	      $('.carregandoCel').show();
	      $.getJSON(
	        'site/pesquisa.php',
	        {
	          igrejas: igreja,
	          ajax: 'true'
	        }, function(z){
	          var options = '<option value="">selecione uma celula</option>';
	          for (var a = 0; a < z.length; a++) {
	            options += '<option value="' +
	              z[a].id + '">' +
	              z[a].celula + '</option>';
	          }
    	          if(z.length < 1){
    		          options = '<option value="no">nenhuma celula encontrada</option>';
    		      }
	          $('#celulas').html(options).show();
	          $('.carregandoCel').hide();
	        });
	     }
	  });
});
</script>
<script type="text/javascript">
// Botão do modal envia id dos selects e o valor do texto para pesquisa1.
$(function(){
	$('#btnAssociaUsuario').click(function(){
		var idusuario = $('#usuarios').val(); 
		var idcelula = $('#celulas').val(); 
		var usuario = $('#usuarios').find(":selected").text(); 
		var celula = $('#celulas').find(":selected").text();
      $.getJSON(
  	        'site/view/associausuario.php',
        {
          idusuario : idusuario,
          idcelula : idcelula,
          usuario : usuario,
          celula : celula, 
          ajax : 'true'
        }, function(sucesso){
        	 window.location.replace("index.php?pag=site_view_userReadView");
        });		
	});
 });
</script>
<!-- Modal -->


<!-- Função input pesquisa -->
<script>
$(document).ready(function(){
  $("#pesquisauser").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
