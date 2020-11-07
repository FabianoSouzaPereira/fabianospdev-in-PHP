<?php

use application\functions\Validador;
use application\modulos\modelosRelatorios\Relatorio;


require 'init.php';
include_once 'application/modulos/Igreja.php';
include_once 'application/functions/Validador.php';
include_once 'application/modulos/modelosRelatorios/Relatorio.php';
include_once 'js/functions.js';
?>
<div class="tela">
   <div style="margin-top:-55px;margin-bottom:8px; width: 100%;">
    		<a href="index.php?pag=site_view_relatorioView" class="btn btn-primary btn-voltar">
    		<span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
   </div>
   <div class="formato panel panel-warning">
    	<div class="panel-heading">
    		<h1>Lista de Relatórios</h1>
    	</div>
      <div class="panel-body">	
        	<a href="" data-toggle="modal" data-target="#modal-novoRelatorio"><button id="novorelatorio" style="background-color: green"; class="btn btn-primary btn-novo"><span class="glyphicon glyphicon-plus"></span> Novo relatório</button></a>
            <input type="text" id="pesquisarel" class="form-control  sombra-efe" style="display:inline-block;width:200px;"  placeholder="Pesquisa...">
        <table class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
        	<thead>
        	<tr>
        		<th></th>
        		
        		<th style='color: red;'>Célula</th>
        		<th style='color: red;'>Data</th>
        
        		<th style='color: red;'>Ver</th>
        		<th style='color: red;'>Editar</th>
        	</tr>
        </thead>
        	<tbody>
        	<?php 
        	$rel = new Relatorio(); 
        	$id=null;
            try{
                if(isset($id) && $id > 0){
                    $rel->pastorReadById($id);
                }else{
                    $rel->pastorRead();
                }
        
                $ret = $rel->getDados();
            	$data=null;
                $sec=1;
                if(is_array($ret)){
                    Foreach($ret as $raw) {
                        $id= $raw['relAid']; $uid= $raw['relUid']; $base= $raw['relBase']; $membros= $raw['relMembros']; 
                        $visitantes= $raw['relVisitantes'];$criancas= $raw['relCriancas']; $adultos= $raw['relAdultos']; 
                        $jovens= $raw['relJovens']; $estudo= $raw['relEstudo'];$quebragelo= $raw['relQuebragelo'];
                        $lanche= $raw['relLanche']; $aceitou=$raw['relAceitou']; $reconcilhacao=$raw['relReconcilhacao']; 
                        $testemunho=$raw['relTestemunho']; $igreja=$raw['relIgreja']; $usuario=$raw['relUsuario']; 
                        $status=$raw['relStatus']; $celula= $raw['celCelula'];  $data=$raw['relData'];
                        echo "<tr>"; 
                        echo "<td style='text-transform:uppercase; color: black;width:80px;'>", $sec++ ,"</td>";
                     /*    echo "<td style='text-transform:uppercase; color: black;'>", $igreja,"</td>"; */
                        echo "<td style='text-transform:uppercase; color: black;'>", $celula,"</td>";
                        echo "<td style='text-transform:uppercase; color: black;width:100px;'>", Validador::bancoToUser( $data),"</td>";
        /*                 echo "<td style='text-transform:uppercase; color: black;'>", $estado,"</td>";
                        echo "<td style='text-transform:uppercase; color: black;'>", $cidade,"</td>"; */
                        echo "<td style='width:100px;'><a href='index.php?page=site_view_relatorioDetailsView&id=$id&c=$celula' class='btn btn-primary btn-lista'><span class='glyphicon glyphicon-plus'></span></a></td>";
                        echo "<td style='width:100px;'><a href='index.php?page=site_view_relatorioUpdateView&id=$id&c=$celula' class='btn btn-primary btn-lista'><span class='glyphicon glyphicon-edit'></span></a></td>";
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
   </div>
</div>
<!-- Modal para escolher igreja e celula -->
<div style="margin-top: 5%;" id="modal-novoRelatorio" class="modal fade modal-dialog-centered" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div id="selects" class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Para qual celula ? </h2>
        <select id="igrejas" name="igrejas" class="form-control" style="margin:20px auto 0px auto;width:400px;height:45px;font-size:14px;">
        	<option value="<?php echo $_SESSION['igrejaId']?>" selected><?php echo $_SESSION['igrejaNome']?></option>
        </select>
         <select id="celulas" name="celulas" class="form-control" style="margin:20px auto 0px auto;width:400px;height:45px;font-size:14px;">
        	<option value="SELECIONE">Selecione uma célula</option>
        </select>
        <select id="" name="" class="form-control carregandoCel" style="display:none;margin:20px auto 0px auto;width:400px;height:45px;font-size:14px;">
        	<option value="">carregando...</option>
        </select>
      </div>
      <div class="modal-body" >
		<form action="" method="get" class="form-inline">
		<a href="index.php?pag=site_view_relatorioA"
style="background-color:green;margin: 10px auto 0px auto;width: 200px;height: 60px;font-size: 20px;padding-top: 20px;" class="btn btn-primary btn-lg btn-block btn-novo" id="btnCriaRelatorio">
 Criar Relatório</a>
		<br />
		</form>
      </div>
      <div class="modal-footer">
      <p style="display: inline-block; float: left;color:green;font-style: inherit;">Filtrado conforme suas permissões de usuário</p>
        <button type="button" class="btn btn-default btn-inline" data-dismiss="modal"><span class="glyphicon glyphicon-remove"> </span> Fechar</button>	       
      </div>
    </div>	
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	  $('#novorelatorio').click(function(){
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
//Botão do modal envia id dos selects e o valor do texto para pesquisa1.
$(function(){
	$('#btnCriaRelatorio').click(function(){
		var idestado = $('#estados').val();  
		var idcidade = $('#cidades').val();
		var idigreja = $('#igrejas').val(); 
		var idcelula = $('#celulas').val();
		var estado = $('#estados').find(":selected").text();  
		var cidade = $('#cidades').find(":selected").text(); 
		var igreja = $('#igrejas').find(":selected").text(); 
		var celula = $('#celulas').find(":selected").text(); 
      $.getJSON(
  	        'site/pesquisa1.php',
  	        {
  	          idestado:idestado,
  	          idcidade:idcidade,
  	          idigreja:idigreja,
  	          idcelula:idcelula,
  	          estado: estado,
  	          cidade: cidade,
  	          igreja: igreja,
  	          celula: celula, 
  	          ajax: 'true'
  	        }, function(){
	  	        alert('sucesso');
  	        });
		
	});
 });
</script>
<!-- Modal -->

<script>
$(document).ready(function(){
  $("#pesquisarel").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>