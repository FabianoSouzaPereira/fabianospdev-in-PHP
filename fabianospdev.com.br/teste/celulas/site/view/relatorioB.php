<?php
use application\modulos\modelosRelatorios\Relatorio;

require 'init.php';
Relatorio::class;

if (isset($_POST['cancelar'])){
    header( "Location: index.php?pag=site_view_readRelatorioView" );
    exit(); 
}

?>
<div class="formato">
<div id="voltar" style="margin-top:-50px; width: 100%;">
	<a href="index.php?pag=site_view_relatorioView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
		<a href="" data-toggle="modal" data-target="#modal-apaga" style="float: right;">
			<span class="glyphicon glyphicon-trash btn-apaga">
				<label class="acessoSmart" style='display: none'>Apagar</label>
			</span>
		</a>
</div>
<div id="relatorio" class="layoutMenor panel-body">
<div >

	<h1 style="margin-left:5%;">RELATÓRIO - CÉLULA <b>[nome]:</b></h1>
	<div class="form-row"  style="margin: 40px auto 0px 150px;">
		<div class="form-group col-md-4" style="margin-left:50px;">
			<label>N° Base da célula:</label>
			<input type="text" name="base" id="base" style="width: 80px;margin-left:18px;">
		</div> 
    	<div class="form-group col-md-4">
    		<label>Testemunho:</label>
    		<input type="number" name="testemunho" id="testemunho" style="width: 80px;margin-left:38px;">
    	</div>
    </div>
    <div class="form-row" style="margin: 40px auto 0px 150px;">
    	<div class="form-group col-md-4" style="margin-top: 10px;margin-left:50px;">
			<label>Nº de Adultos: </label>
			<input type="number" name="adultos" id="adultos" style="width: 80px;margin-left:30px;">
		</div>
    	<div class="form-group col-md-4" style="margin-top:10px;">
        	<label>Nº de Jovens: </label>
        	<input type="number" name="jovens" id="jovens" style="width: 80px;margin-left:35px;">
    	</div>
    	<div class="form-group col-md-4" style="margin-left:50px;">
    		<label>Nº de crianças: </label>
    		<input type="number" name="criancas" id="criancas"  style="width: 80px;margin-left:25px;">
    	</div>
    	<div class="form-group col-md-4" style="margin-left:0px;">
    		<label>Nº de Visitantes: </label>
    		<input type="number" name="visitantes" id="visitante" style="width: 80px;margin-left:8px;">
    	</div>
    	<div class="form-group col-md-4" style="margin-left: 200px; margin-top: 30px;">
    		<label>Total de Presentes: </label>
    		<input type="number" name="total" id="soma" style="width: 100px;margin-left:20px;" >
    		<input id="cancelar" type="submit" name="cancelar" class="right btn btn-default" value="Cancelar"
    	</div>
	</div>
	</div>
</div>
</div>
<script>(function(){
	if ($('#adultos').lenght > -1 and 
			$('#jovens').lenght > -1 and
				$('#criancas').lenght > -1 and 
					$('#visitantes').lenght >-1){
                		var adulto = $('#adultos').val();
                		var jovens = $('#jovens').val();
                		var crianca	= $('#criancas').val(); 
                		var visitante = $('#visitantes').val();
                		var soma = adulto + jovens + crianca + visitante;
                		$('#soma').val(soma);
		
				} 	
			}
			
</script>

<!-- Modal para apagar Registro -->
<div style="margin-top: 10%;" id="modal-apaga" class="modal fade modal-dialog-centered" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Deseja Apaga Registro ? </h2>
      </div>
      <div class="modal-body" >
		<form action="" method="get" class="form-inline">
		<a href="index.php?page=site_view_celulaDeleteView&id=<?php echo $id ?>&ac=delpen" 
style="background-color:red;margin: 30px auto 0px auto;width: 200px;height: 60px;font-size: 25px;" class="btn btn-primary btn-lg btn-block">
 Apagar célula</a>

			<br />
		</form>
      </div>
      <div class="modal-footer">
      <p style="display: inline-block; float: left;color:green;font-style: inherit;">Esse registro ainda poderá ser recuperado</p>
        <button type="button" class="btn btn-default btn-inline" data-dismiss="modal"><span class="glyphicon glyphicon-remove"> </span> Fechar</button>	       
      </div>
    </div>	
  </div>
</div>
<!-- Modal -->