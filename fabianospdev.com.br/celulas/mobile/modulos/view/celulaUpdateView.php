<?php

use modulos\Celula;
use application\functions\Validador;

require 'init.php';
include_once 'modulos/Celula.php';
include_once '../application/functions/Validador.php';
include_once '../js/functions.js';
$id=null;
$cel=new Celula();
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
$cel->readWholebyId($id);
$ret=$cel->getDadosWhole();
$cel=null;
/* $a= @$ret[0]['celData'];
$d= Validador::bancoTodata($a);  */


if(isset($_POST['celCelula'])){
    $celup= new Celula();
    $celup->update= TRUE;
    $celId = $_SESSION['celId'] = $_POST['celId'];;
    $_SESSION['celCelula']=$_POST['celCelula'];
    $_SESSION['celRede']=$_POST['celRede'];
    $_SESSION['celLider']=$_POST['celLider'];
    $_SESSION['celViceLider']=$_POST['celViceLider'];
    $_SESSION['celSecretario']=$_POST['celSecretario'];
    $_SESSION['celAnfitriao']=$_POST['celAnfitriao'];
    $_SESSION['celColaborador']=$_POST['celColaborador'];

    $_SESSION['celData']=$_POST['celData'];
    $_SESSION['celDia']=$_POST['celDia'];
    $_SESSION['celHora']=$_POST['celHora'];
   // $_SESSION['celStatus']=$_POST['celStatus'];
    
    $celup->setId($_SESSION['celId'] );
    $celup->setCelula($_SESSION['celCelula']);
    $celup->setRede($_SESSION['celRede']);
    $celup->setLider($_SESSION['celLider']);
    $celup->setViceLider($_SESSION['celViceLider']);
    $celup->setSecretario($_SESSION['celSecretario']);
    $celup->setAnfitriao($_SESSION['celAnfitriao']);
    $celup->setColaborador($_SESSION['celColaborador']);
    $celup->setData($_SESSION['celData']);
    $celup->setDia($_SESSION['celDia']);
    $celup->setHora($_SESSION['celHora']);
  //  $celup->setStatus($_SESSION['celStatus']);
   
    $celup->updateCelulaforId($celId);
    $celup->update= FALSE;
    
    $cel=new Celula();
    $cel->readWholebyId($id);
    $ret=$cel->getDadosWhole();
    $cel=null;
    header( "Location: index.php?pag=site_view_celulasReadView" );
    exit(); 
}
?>
<script>
$(document).keypress(function(e) {
    if(e.which == 13) $('#enviar').click();
	});
$(document).keypress(function(ei) {
    if(ei.which == 8) $('#limpar').click();
	});
/* $(document).keypress(function(ei) {
    if(ei.which == 27) $('href="index.php?pagina=#').click();
	}); */
</script>
	<div style="margin-top:-50px; width: 100%;">
		<a href="index.php?pag=site_view_celulasReadView" class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
	
		<a href="" data-toggle="modal" data-target="#modal-apaga" style="float: right;">
			<span class="glyphicon glyphicon-trash btn-apaga">
				<label class="acessoSmart" style='display: none'>Apagar</label>
			</span>
		</a>
	
	</div>
<form action="" method="post" accept-charset="UTF-8">
<div id="" class="layoutPadrao panel-body" style="margin-top:10px;">
<div class="panel-heading" style="margin-top: -15px;">
	<h1>Atualizar Registro da Célula   &nbsp;&nbsp;&nbsp;<?php echo strtoupper(@$ret[0]['celCelula']); ?></h1>
</div>
<div>
  <div class="form-row" style="margin-top: -10px;"> 
      <div id="id" class=""> 
       		<input type="hidden" name="celId" id="id" value="<?php echo @$ret[0]['celId'];?>" class="">
      </div> 
      <div id="celula" class="form-group col-md-6" style="margin-top: 30px;margin-bottom: 0px;margin-left: 0%;">
        	<label for="celula">Célula</label>
        	<input type="text" name="celCelula" id="celula" value="<?php echo strtoupper(@$ret[0]['celCelula']); ?>" onkeyup="maiuscula(this)" class="form-control">
      </div>
      <div id="rede" class="form-group col-md-6" style="margin-top: 30px;margin-bottom: 0px;margin-left: 0%;">
        	<label for="rede">Rede</label>
        	<input type="text" name="celRede" id="rede" value="<?php echo strtoupper(@$ret[0]['celRede']); ?>" onkeyup="maiuscula(this)" class="form-control">
      </div>
      <div id="lider" class="form-group col-md-6" style="margin-top: 2px;">
        	<label for="lider">Lider</label>
        	<input type="text" name="celLider" id="lider" value="<?php echo strtoupper(@$ret[0]['celLider']);?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
  </div>  
  <div class="form-row">   
        <div id="vicelider" class="form-group col-md-6"style="margin-top: 2px;" >
        	<label for="vicelider">vice-lider</label>
        	<input type="text" name="celViceLider" id="vicelider" value="<?php echo strtoupper(@$ret[0]['celViceLider']);?>"  onkeyup="maiuscula(this)" class="form-control">
        </div>
    	<div id="secretario" class="form-group col-md-6">
        	<label for="secretario">secretário</label>
        	<input type="text" name="celSecretario" id="secretario" value="<?php echo strtoupper(@$ret[0]['celSecretario']);?>"  onkeyup="maiuscula(this)" class="form-control">
        </div>
  </div> 
  <div class="form-row" >  
    <div id="anfitriao" class="form-group col-md-6">
    	<label for="anfitriao">Anfitrião</label>
    	<input type="text" name="celAnfitriao" id="anfitriao" value="<?php echo strtoupper(@$ret[0]['celAnfitriao']);?>"  onkeyup="maiuscula(this)" class="form-control">
    </div> 
    <div id="colaborador" class="form-group col-md-6">
    	<label for="colaborador">Colaborador</label>
    	<input type="text" name="celColaborador" id="colaborador" value="<?php echo strtoupper(@$ret[0]['celColaborador']);?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
  </div> 
  <div class="form-row" >  
        <div id="dia" class="form-group col-md-3">
        	<label for="dia">Dia</label><?php $dia= @$ret[0]['celDia']; ?>;
            <select id="dia" name="celDia" class="form-control">
                <option value="SEGUNDA-FEIRA" <?=($dia == 'SEGUNDA-FEIRA')?'selected':''?>>SEGUNDA-FEIRA</option>
                <option value="TERÇA-FEIRA" <?=($dia == 'TERÇA-FEIRA')?'selected':''?>>TERÇA-FEIRA</option>
                <option value="QUARTA-FEIRA" <?=($dia == 'QUARTA-FEIRA')?'selected':''?>>QUARTA-FEIRA</option>
                <option value="QUINTA-FEIRA" <?=($dia == 'QUINTA-FEIRA')?'selected':''?>>QUINTA-FEIRA</option>
                <option value="SEXTA-FEIRA" <?=($dia == 'SEXTA-FEIRA')?'selected':''?>>SEXTA-FEIRA</option>
                <option value="SABADO" <?=($dia == 'SABADO')?'selected':''?>>SABADO</option>
                <option value="DOMINGO" <?=($dia == 'DOMINGO-FEIRA')?'selected':''?>>DOMINGO</option>
            </select> 
        </div>
        <div id="hora" class="form-group col-md-3">
        	<label for="hora">Horário</label>
        	<input type="text" name="celHora" id="hora" value="<?php echo @$ret[0]['celHora'];?>" class="form-control">
        </div>
   </div>
   <div class="form-row" >
        <div id="data" class="form-group col-md-3">
        	<label for="data">Data da Criação</label>
        	<input type="text" name="celData" id="data" value="<?php echo Validador::bancoToUser(@$ret[0]['celData']); ?>" class="form-control">
        </div>
  </div>
      <!-- <input type="hidden" name="celStatus" id="celstatus" value="<?php echo @$ret[0]['celStatus'];?>" class="form-control">  -->	
   	<div class="submitting">
		<input id="enviar" type="submit" class="left btn btn-success"  value="Enviar">
		<input id="limpar" type="submit" class="right btn btn-default" value="Limpar Campos">
	</div>
</div>

</div>
</form>
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

