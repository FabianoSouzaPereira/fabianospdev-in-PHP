<?php

use modulos\Celula;
use modulos\dao\Login;
use application\functions\Validador;

require 'init.php';
include_once 'modulos/Celula.php';


$cel=new Celula();
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $cel->readWholebyId($id);
    $ret=$cel->getDadosWhole();
}
?>
	<div style="margin-top:-50px; width: 100%;">
		<a href="index.php?pag=site_view_celulasReadView" class="btn btn-primary btn-voltar">
			<span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>	
		<a href="" data-toggle="modal" data-target="#modal-apaga" style="float: right;">
			<span class="glyphicon glyphicon-trash btn-apaga">
				<label class="acessoSmart" style='display: none'>Apagar</label>
			</span>
		</a>
	</div>
<form action="" method="post" accept-charset="UTF-8">
<div id="" class="layoutPadrao panel-body" style="margin-top:10px;">
<div class="panel-heading" style="margin-top: -15px;">
	<h1>Detalhes da Célula   &nbsp;&nbsp;&nbsp;<?php echo strtoupper(@$ret[0]['celCelula']); ?></h1>
</div>
   <div class="form-row" style="margin-top: -10px;"> 
 <!-- <div id="id" class="" style="height: 0px;margin-top: 0dp;margin-bottom: 0px;margin-left: 0%;"> 
   		<input type="hidden" name="celId" id="id" value="<?php echo @$ret[0]['celId'];?>" class="">
    </div>-->
 
    <div id="celula" class="form-group col-md-6" style="margin-top: 30px;margin-bottom: 0px;margin-left: 0%;" readonly>
    	<label for="celula">Célula</label>
    	<input type="text" name="celCelula" id="celula" value="<?php echo strtoupper(@$ret[0]['celCelula']);?>" class="form-control" readonly>
    </div>
    <div id="rede" class="form-group col-md-6"  style="margin-top: 30px;margin-bottom: 0px;margin-left: 0%;margin-bottom:10px;">
    	<label for="rede">Rede</label>
    	<input type="text" name="celRede" id="rede" value="<?php echo strtoupper(@$ret[0]['celRede']);?>" class="form-control" readonly>
    </div>
  </div>
  <div class="form-row">   
    <div id="lider" class="form-group col-md-6">
    	<label for="lider">Lider</label>
    	<input type="text" name="celLider" id="lider" value="<?php echo strtoupper(@$ret[0]['celLider']);?>" class="form-control" readonly>
    </div>
    <div id="vicelider" class="form-group col-md-6">
    	<label for="vicelider">Vice-lider</label>
    	<input type="text" name="celViceLider" id="vicelider" value="<?php echo strtoupper(@$ret[0]['celViceLider']);?>" class="form-control" readonly>
    </div>
   </div>
   <div class="form-row">  
	<div id="secretario" class="form-group col-md-6">
    	<label for="secretario">Secretário</label>
    	<input type="text" name="celsecretario" id="secretario" value="<?php echo strtoupper(@$ret[0]['celSecretario']);?>" class="form-control" readonly>
    </div>  
   
    <div id="anfitriao" class="form-group col-md-6">
    	<label for="celanfitriao">Anfitrião</label>
    	<input type="text" name="celAnfitriao" id="anfitriao" value="<?php echo strtoupper(@$ret[0]['celAnfitriao']);?>" class="form-control" readonly>
    </div>
   </div>
   <div class="form-row" >  
    <div id="colaborador" class="form-group col-md-6">
    	<label for="colaborador">Colaborador</label>
    	<input type="text" name="celColaborado" id="colaborador" value="<?php echo strtoupper(@$ret[0]['celColaborador']);?>" class="form-control"readonly>
    </div>
    <div id="dia" class="form-group col-md-3">
    	<label for="dia">Dia</label>
    	<input type="text" name="celDia" id="dia" value="<?php echo strtoupper(@$ret[0]['celDia']);?>" class="form-control" readonly>
    </div>
   </div>
   <div class="form-row" >  
    <div id="hora" class="form-group col-md-3">
    	<label for="hora">Horário</label>
    	<input type="text" name="celHora" id="hora" value="<?php echo @$ret[0]['celHora'];?>" class="form-control" readonly>
    </div> 
    <div id="data" class="form-group col-md-3">
    	<label for="data">Data da Criação</label>
    	<input type="text" name="celData" id="data" value="<?php echo Validador::bancoToUser(@$ret[0]['celData']);?>" class="form-control" readonly>
    </div>
    <div id="igreja" class="form-group col-md-3">
    	<label for="igreja">Igreja</label>
    	<input type="text" name="chuIgreja" id="igreja" value="<?php echo @$ret[0]['chuIgreja'];?>" class="form-control" readonly>
    </div>
  </div>
   	<div class="submitting">
		<input type="hidden" class="left btn btn-success" value="Enviar" >
		<input type="hidden" class="right btn btn-default" value="Limpar Campos">
	</div>

</div>
