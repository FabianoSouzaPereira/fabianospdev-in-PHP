<?php
require 'init.php';

?>
<div id="voltar" style="margin-top:-50px; width: 100%;">
	<a href="index.php?pag=site_view_relatorioView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
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
