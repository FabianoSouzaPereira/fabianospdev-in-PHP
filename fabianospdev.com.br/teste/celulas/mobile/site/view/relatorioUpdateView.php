<?php
use mobile\modulos\modelosRelatorios\Relatorio;
use mobile\functions\Validador;

require 'init.php';
include_once '../mobile/modulos/modelosRelatorios/Relatorio.php';

$id=null;
$ret=null;
$r = new Relatorio();
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $r->pastorReadWholeByid($id);
    $ret=$r->getDados();
    
}

if (isset($_POST['base'])){
    $rel = new Relatorio();
    $rel->update= TRUE;
    $relid= $_POST['relAid'];
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
    $_SESSION['total']=$_POST['soma'];
    $data= $_POST['data'];
    
    $rel->setId($relid);
    $rel->setIgreja($_SESSION['idigreja']);
    $rel->setCelula($_SESSION['idcelula']);
    $rel->setUsuario($_SESSION['usuId']);
    $rel->setUid($_SESSION['celula']+date('d/m/Y h:i:s')); //passa por sha1;
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
    $rel->setTotal($_SESSION['total']);
    $rel->setData($data);
    
    $rel->pastorUpdate();
    $rel->update=null;
    $rel=NULL;
    
    header( "Location: index.php?pag=site_view_readRelatorioView" );
    exit(); 

}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	
	 
	  $(".input").keydown(function(){
		    $(".input").css("background-color", "yellow");
		  });
	  $("#base,#membros,#visitantes,#criancas,#adultos,#jovens").change(function(){
		  $(".input").css("background-color", "#ffbbdd");
		  var base=Number($("#base").val());
		  var membros=Number($("#membros").val());
		  var visitantes=Number($("#visitantes").val());
		  var criancas=Number($("#criancas").val());
		  var adultos=Number($("#adultos").val());
		  var jovens=Number($("#jovens").val());
		  var soma=0;
			if (soma == 0) {			
  			 soma = base + membros + visitantes + criancas + adultos + jovens;
  			 console.log(soma); 
			}else{alert('Numero não pode ser negativo!');$(".input").val("");$("#soma").val("");}
			$("#soma").val(soma);
			$("#soma").css("background-color", "#00FF7F");	
        });
	});
</script>
<div class="tela">
<div class="formato">
<div id="voltar" style="margin-top:0px; width: 100%;">
<a href="index.php?pag=site_view_readRelatorioView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
		<a href="" data-toggle="modal" data-target="#modal-apaga" style="float: right;">
			<span class="glyphicon glyphicon-trash btn-apaga">
				<label class="acessoSmart" style='display: none'>Apagar</label>
			</span>
		</a>
</div>
<div id="relatorio" class="layoutPadrao panel-body">
 <div>
 <form action="" method="post" accept-charset="UTF-8">
 <header class="panel-heading" style="margin-top: -20px;">
	<h1 style="margin-left:0%;">RELATÓRIO - CÉLULA :&nbsp; <b><?php echo @$ret[0]['celCelula'] ?></b></h1>
 	<h6>Data: <?php echo Validador::bancoToUser(@$ret[0]['relData']); ?></h6>
 </header>
	<div class="grupoRel">
    	<div class="form-row"  style="margin: 40px auto 0px 10px;">
    	<input type="hidden" name="relAid" id="id" value="<?php echo @$ret[0]['relAid'];?>"/>
    		<div class="form-group col-md-4" style="margin-left:0px;">
    			<label for="base">Número Base da célula:</label>
    			<input type="number" name="base" id="base" value="<?php echo @$ret[0]['relBase'];?>" min="0" class="input" style="margin: 0px auto 0px 10px;width:50px;"/>
    		</div> 
        	<div class="form-group col-md-4">
        		<label for="membros">Membros da Igreja</label>
        		<input type="number" name="membros" id="membros" value="<?php echo @$ret[0]['relMembros'];?>" min="0" class="input" style="margin: 0px auto 0px 50px;width:50px;"/>
        	</div> 
            <div class="form-group col-md-4" >
        		<label for="visitantes">Número de Convidados: </label>
        		<input type="number" name="visitantes" id="visitantes" value="<?php echo @$ret[0]['relVisitantes'];?>" min="0" class="input" style="margin: 0px auto 0px 10px;width:50px;"/>
        	</div>
        </div>
        <div class="form-row" style="margin: 0px auto 0px 10px;">
        	<div class="form-group col-md-4" style="margin-left:0px;">
        		<label for="criancas">Número de crianças: </label>
        		<input type="number" name="criancas" id="criancas"  value="<?php echo @$ret[0]['relCriancas'];?>" min="0" class="input" style="margin: 0px auto 0px 10px;width:50px;"/>
        	</div>
        	<div class="form-group col-md-4" style="margin-top:0px;">
            	<label for="jovens">Número de Jovens: </label>
            	<input type="number" name="jovens" id="jovens"  value="<?php echo @$ret[0]['relJovens'];?>" min="0" class="input" style="margin: 0px auto 0px 25px;width:50px;"/>
        	</div>
        	<div class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
    			<label for="adulto">Número de Adultos: </label>
    			<input type="number" name="adultos" id="adultos" value="<?php echo @$ret[0]['relAdultos'];?>" min="0" class="input"style="margin: 0px auto 0px 20px;width:50px;"/>
    		</div>
        	<div class="form-group col-md-4" style="margin-left: 0px; margin: 0px auto 0px auto;">
        		<label for="soma">Total de Presentes: </label>
        		<input type="number" name="soma" id="soma"  value="<?php echo @$ret[0]['relTotal'];?>" min="0" style="margin: 0px auto 0px 25px;width:50px;"/>
        	</div>
        	<div class="form-group col-md-4" style="margin: 20px auto 10px auto;">
        		<label for="data">Data: </label>
        		<input type="text" name="data" id="data"  value="<?php echo Validador::bancoToUser(@$ret[0]['relData']);?>" style="margin: 0px auto 0px 20px;width:100px;"/>
        	</div>
    	</div>
	</div>
	<div id="cbEstudo" name="cbEstudo" class="form-row" value="cbEstudo" style="margin: 50px auto 0px 50px;">
	    <div class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label>Foi ministado estudo? </label><br><?php $estudo= @$ret[0]['relEstudo']; ?>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="estudo" value="SIM" id="cbSim" <?=($estudo == 'SIM')?'checked':''?>>
			<label for="cbNao">Não</label>
			<input type="radio" name="estudo" value="NÃO" id="cbnao" <?=($estudo == 'NÃO')?'checked':''?>>
		</div>
		<div>
		<div id="cbQuebragelo" name="cbQuebragelo" value="cbQuebragelo" class="form-group col-md-4">
			<label>Foi feito quebra gelo? </label><br><?php $quebragelo= @$ret[0]['relQuebragelo']; ?>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="quebragelo" value="SIM" id="cbSim" <?=($quebragelo == 'SIM')?'checked':''?>>
			<label for="cbNao">Não</label>
			<input type="radio" name="quebragelo" value="NÃO"  id="cbnao" <?=($quebragelo == 'NÃO')?'checked':''?>>
		</div>
		<div id="cbLanche" name="sbLanche" value="sbLanche" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Foi servido lanche? </label><br><?php $lanche= @$ret[0]['relLanche']; ?>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="lanche" value="SIM" id="cbSim" <?=($lanche == 'SIM')?'checked':''?>>
			<label for="cbNao">Não</label>
			<input type="radio" name="lanche" value="NÃO"  id="cbnao" <?=($lanche == 'NÃO')?'checked':''?>>
		</div>
		
		<div id="cbAceitou" name="cbAceitou" value="cbAceitou" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Alguém aceitou Jesus? </label><br><?php $aceitou= @$ret[0]['relAceitou']; ?>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="aceitou" value="SIM" id="cbSim" <?=($aceitou == 'SIM')?'checked':''?>>
			<label for="cbNao">Não</label>
			<input type="radio" name="aceitou" value="NÃO"  id="cbnao" <?=($aceitou == 'NÃO')?'checked':''?>>
		</div>
		
		<div id="cbReconcilhacao" name="cbReconcilhacao" value="cbReconcilhacao" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Alguém se Reconcilhacao com Cristo? </label><br><?php $reconcilhacao= @$ret[0]['relReconcilhacao']; ?>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="reconcilhacao" value="SIM" id="cbSim" <?=($reconcilhacao == 'SIM')?'checked':''?>>
			<label for="cbNao">Não</label>
			<input type="radio" name="reconcilhacao" value="NÃO"  id="cbnao" <?=($reconcilhacao == 'NÃO')?'checked':''?>>
		</div>
	
		<div id="cbTestemunho" name="cbTestemunho" value="cbTestemunho" class="form-group col-md-4" style="margin-top: 0px;margin-left:0px;">
			<label for="cbNao">Alguém contou Testemunho? </label><br><?php $testemunho= @$ret[0]['relTestemunho']; ?>
			<label for="cbSim" style="margin-left:30px;">Sim</label>
			<input type="radio" name="testemunho" value="SIM" id="cbSim" <?=($testemunho == 'SIM')?'checked':''?>>
			<label for="cbNao">Não</label>
			<input type="radio" name="testemunho" value="NÃO"  id="cbnao" <?=($testemunho == 'NÃO')?'checked':''?>>
		</div>
	</div>
	<div class="submitting" style="margin: 50px 15px 0px -30px;">
		<input id="enviar" type="submit" name="submit" class="left btn btn-success"  value="Enviar" style="width:80px;">
		<input id="Cancelar" type="submit" name="cancelar" class="right btn btn-default" value="Cancelar"  style="width:80px;">
	</div>
 </div>
 </form>
</div>
</div>
</div>

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
		<a href="index.php?page=site_view_relatorioDeleteView&id=<?php echo $id ?>&ar=delpen" 
style="background-color:red;margin: 30px auto 0px auto;width: 210px;height: 60px;font-size: 25px;" class="btn btn-primary btn-lg btn-block">
 Apagar relatório </a>

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