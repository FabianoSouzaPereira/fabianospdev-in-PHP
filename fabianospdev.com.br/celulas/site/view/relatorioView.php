<?php

require 'init.php';
include_once 'application/functions/Pesquisa.php';

?>
<div class="tela">
<div id="fundoRelatorioView">
    <div class="formato">
    <section class="grid grid-template-columns grid-template-rows">
    
        <a href="index.php?pag=site_view_readRelatorioView" >
        	<button class="item-1 relatorio">Lista de Relatórios</button>
        </a>
        <a href="" data-toggle="modal" data-target="#modal-novoRelatorio">
    		<button id="btnrelatoriocreate" class="item-2 relatorio">Criar relatório</button></a>
    	<a href="index.php?pag=site_view_estatisticasView">
    		<button  class="item-3  relatorio">Estatísticas</button>
    	</a>
    	<a href="index.php?pag=site_view_mapaView">
    		<button class="item-4  relatorio">Mapa</button>
    	</a>
    	<a href="">
    		<button  class="item-5  relatorio"></button>
    	</a>
    	<a href="">
    		<button  class="item-6  relatorio"></button>
    	</a>
    </section>
    
    </div>
   </div>
</div>   
    <!-- Modal para escolher celula -->
    <div style="margin-top: 5%;" id="modal-novoRelatorio" class="modal fade modal-dialog-centered" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div id="selects" class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2 class="modal-title">Para qual celula ? </h2>
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
    style="background-color:green;margin: 10px auto 0px auto;width: 200px;height: 60px;font-size: 25px;" class="btn btn-primary btn-lg btn-block" id="btnCriaRelatorio">
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
    style="background-color:green;margin: 10px auto 0px auto;width: 200px;height: 60px;font-size: 25px;" class="btn btn-primary btn-lg btn-block" id="btnCriaRelatorio">
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
	  $('#btnrelatoriocreate').click(function(){
		  var igreja = $('#dados_gerais #nomeIgreja').html();
		  if( igreja ){
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
  	        }, function(sucesso){
	  	        alert(sucesso);
  	        });
		
	});
 });
</script>
<!-- Modal -->