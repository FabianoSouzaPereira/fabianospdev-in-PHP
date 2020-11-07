<?php
use application\modulos\modelosRelatorios\Relatorio;

require 'init.php';
include_once 'application/modulos/modelosRelatorios/Relatorio.php';


if (isset($_POST['base'])){
    $rel = new Relatorio();
    $rel->insert= TRUE;
    $_SESSION['base']=$_POST['base'];
    $_SESSION['membros']=$_POST['membros'];
    $_SESSION['visitantes']=$_POST['visitantes'];
    $_SESSION['criancas']=$_POST['criancas'];
    $_SESSION['adultos']=$_POST['adultos'];
    $_SESSION['jovens']=$_POST['jovens'];
    $_SESSION['estudo']= isset($_POST['estudo']) == true?$estudo= $_POST['estudo']:$estudo="";
    $_SESSION['quebragelo']= isset($_POST['quebragelo'])==true? $quebragelo=$_POST['quebragelo']:$quebragelo='' ;
    $_SESSION['lanche']= isset($_POST['lanche'])==true?$lanche=$_POST['lanche'] : $lanche="";
    $_SESSION['aceitou']= isset($_POST['aceitou'])==true?$aceitou=$_POST['aceitou'] : $aceitou="";
    $_SESSION['reconcilhacao']= isset($_POST['reconcilhacao'])==true?$reconcilhacao= $_POST['reconcilhacao']: $reconcilhacao="";
    $_SESSION['testemunho']= isset($_POST['testemunho'])==true?$testemunho= $_POST['testemunho']: $testemunho="";
    
    $rel->setIgreja($_SESSION['idigreja']);
    $rel->setCelula($_SESSION['idcelula']);
    $rel->setUsuario($_SESSION['usuId']);
    $rel->setUid($_SESSION['igreja']); //passa por sha1;
    $rel->setBase($_SESSION['base']);
    $rel->setMembros($_SESSION['membros']);
    $rel->setVisitantes($_SESSION['visitantes']);
    $rel->setCriancas($_SESSION['criancas']);
    $rel->setAdultos($_SESSION['adultos']);
    $rel->setJovens($_SESSION['jovens']);
    $rel->setEstudo($_SESSION['estudo']);
    $rel->setQuebragelo($_SESSION['quebragelo']);
    $rel->setLanche($_SESSION['lanche']);
    $rel->setAceitou($_SESSION['aceitou']);
    $rel->setReconcilhacao($_SESSION['reconcilhacao']);
    $rel->setTestemunho($_SESSION['testemunho']);
    
    $rel->insert();
    $rel->inset=null;
    $rel=NULL;
    
    header( "Location: index.php?pag=site_view_relatorioView" );
    exit(); 

}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	var soma=0;
	  $(".input").keydown(function(){
		    $(".input").css("background-color", "yellow");
		  });
	  $("#base,#membros,#visitantes,#criancas,#adultos,#jovens").keyup(function(){
		  $(".input").css("background-color", "#ffbbdd");
		var valor = Number($(this).val());
			if (valor >= 0) {
  			 soma = soma + valor;
  			 console.log(soma); 
			}else{alert('Numero não pode ser negativo!');$(".input").val("");$("#soma").val("");}
			$("#soma").val(soma);
			$("#soma").css("background-color", "#00FF7F");	
        });
	});
</script>
<div id="voltar" style="margin-top:-50px; width: 100%;">
<a href="index.php?pag=site_view_relatorioView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
<p style="display:inline;margin-left:100px;" id="caminho"><?php echo $_SESSION['estado']; ?></p>
<p style="display:inline;margin-left:0px;" id="caminho2"><?php echo $_SESSION['cidade']; ?></p>
<p style="display:inline;margin-left:0px;" id="caminho3"><?php echo $_SESSION['igreja']; ?></p>
<p style="display:inline;margin-left:0px;" id="caminho4"><?php echo $_SESSION['celula']; ?></p>
</div>
<div id="relatorio" class="layoutPadrao panel-body">
 <div>
 <form action="" method="post" accept-charset="UTF-8">
 <header class="panel-heading" style="margin-top: -20px;">
	<h1 style="margin-left:5%;">RELATÓRIO - CÉLULA <b>[nome]:</b></h1>
 </header>
	<div class="grupoRel">
    	<div class="form-row"  style="margin: 40px auto 0px 50px;">
    		<div class="form-group col-md-4" style="margin-left:0px;">
    			<label for="base">Número Base da célula:</label>
    			<input type="number" name="base" id="base" value="" min="0" class="input" style="width: 80px;margin-left:18px;"/>
    		</div> 
        	<div class="form-group col-md-4">
        		<label for="membros">Membros da Igreja</label>
        		<input type="number" name="membros" id="membros" value="" min="0" class="input" style="width: 80px;margin-left:18px;"/>
        	</div> 
            <div class="form-group col-md-4" style="margin-left:0px;">
        		<label for="visitantes">Número de Convidados: </label>
        		<input type="number" name="visitantes" id="visitantes" value="" min="0" class="input" style="width: 80px;margin-left:8px;"/>
        	</div>
        </div>
        <div class="form-row" style="margin: 50px auto 0px 50px;">
        	<div class="form-group col-md-4" style="margin-left:0px;">
        		<label for="criancas">Número de crianças: </label>
        		<input type="number" name="criancas" id="criancas"  value="" min="0" class="input" style="width: 80px;margin-left:40px;"/>
        	</div>
        	<div class="form-group col-md-4" style="margin-top:0px;">
            	<label for="jovens">Número de Jovens: </label>
            	<input type="number" name="jovens" id="jovens"  value="" min="0" class="input" style="width: 80px;margin-left:15px;"/>
        	</div>
        	<div class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
    			<label for="adulto">Número de Adultos: </label>
    			<input type="number" name="adultos" id="adultos" value="" min="0" class="input" style="width: 80px;margin-left:45px;"/>
    		</div>
        	<div class="form-group col-md-4" style="margin-left: 0px; margin: 30px auto 0px auto;">
        		<label for="soma">Total de Presentes: </label>
        		<input type="number" name="soma" id="soma"  value="" min="0" style="float:m; width: 100px;margin-left: 10px;"/>
        	</div>
    	</div>
	</div>
	<div id="cbEstudo" name="cbEstudo" class="form-row" value="cbEstudo" style="margin: 50px auto 0px 50px;">
	    <div class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label>Foi ministado estudo? </label><br>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="estudo" value="sim" id="cbSim">
			<label for="cbNao">Não</label>
			<input type="radio" name="estudo" value="não" id="cbnao">
		</div>
		<div>
		<div id="cbQuebragelo" name="cbQuebragelo" value="cbQuebragelo" class="form-group col-md-4">
			<label>Foi feito quebra gelo? </label><br>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="quebragelo" value="sim" id="cbSim">
			<label for="cbNao">Não</label>
			<input type="radio" name="quebragelo" value="não"  id="cbnao">
		</div>
		<div id="cbLanche" name="sbLanche" value="sbLanche" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Foi servido lanche? </label><br>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="lanche" value="sim" id="cbSim">
			<label for="cbNao">Não</label>
			<input type="radio" name="lanche" value="não"  id="cbnao">
		</div>
		
		<div id="cbAceitou" name="cbAceitou" value="cbAceitou" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Alguém aceitou Jesus? </label><br>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="aceitou" value="sim" id="cbSim">
			<label for="cbNao">Não</label>
			<input type="radio" name="aceitou" value="não"  id="cbnao">
		</div>
		
		<div id="cbReconcilhacao" name="cbReconcilhacao" value="cbReconcilhacao" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Alguém se Reconcilhacao com Cristo? </label><br>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="reconcilhacao" value="sim" id="cbSim">
			<label for="cbNao">Não</label>
			<input type="radio" name="reconcilhacao" value="não"  id="cbnao">
		</div>
	
		<div id="cbTestemunho" name="cbTestemunho" value="cbTestemunho" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Alguém contou Testemunho? </label><br>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="testemunho" value="sim" id="cbSim">
			<label for="cbNao">Não</label>
			<input type="radio" name="testemunho" value="não"  id="cbnao">
		</div>
	</div>
	<div class="submitting" style="margin: 50px auto 0px 50px;">
		<input id="enviar" type="submit" class="left btn btn-success"  value="Enviar">
		<input id="limpar" type="submit" class="right btn btn-default" value="Limpar Campos">
	</div>
 </div>
 </form>
</div>
