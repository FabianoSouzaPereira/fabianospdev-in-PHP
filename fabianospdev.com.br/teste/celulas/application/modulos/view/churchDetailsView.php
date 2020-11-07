<?php
use modulos\Igreja;
use modulos\dao\Login;
use application\functions\Validador;

require 'init.php';
include_once 'modulos/Igreja.php';


$igr = new Igreja();

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $igr->readWholeByid($id);
}

$ret=$igr->getDados();
$igr=null;
 
?>

<div style="margin-top:-50px; width: 100%;">
		<a href="index.php?pag=site_view_churchReadView" class="btn btn-primary btn-voltar">
		<span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
</div>
<form action="" method="post" accept-charset="UTF-8">
<div class="layoutPadrao panel-body">
<div class="panel-heading" style="margin-top: -20px;">
	<h1>Detalhes da Igreja   &nbsp;&nbsp;&nbsp;<b><?php echo @$ret[0]['chuIgreja']; ?></b></h1>
</div>
<div>
  <div class="form-row" style="margin-top: -10px;"> 
      <div id="id" class=""> 
       		<input type="hidden" name="celId" id="id" value="<?php echo @$ret[0]['chuId'];?>" class="" readonly>
      </div> 
      <div id="celula" class="form-group col-md-6" style="margin-top: 30px;margin-left: 0%;">
        	<label for="igreja">Igreja</label>
        	<input type="text" name="chuIgreja" id="igreja" value="<?php echo @$ret[0]['chuIgreja']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
      </div>
      <div id="endereco" class="form-group col-md-6" style="margin-top: 30px;margin-left: 0%;">
        	<label for="endereco">Endereco</label>
        	<input type="text" name="chuEndereco" id="endereco" value="<?php echo @$ret[0]['chuEndereco']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
      </div>
   </div>
   <div class="form-row">
      <div id="bairro" class="form-group col-md-6" >
        	<label for="bairro">Bairro</label>
        	<input type="text" name="chuBairro" id="bairro" value="<?php echo @$ret[0]['chuBairro'];?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
      </div>
      <div id="cidade" class="form-group col-md-6">
        	<label for="cidade">Cidade</label>
        	<input type="text" name="chuCidade" id="cidade" value="<?php echo @$ret[0]['chuCidade'];?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
      </div>
    </div> 
    <div class="form-row">
    	<div id="estado" class="form-group col-md-6" style="margin-left: 0%;">
        	<label for="estado">Estado</label>
        	<input type="text" name="chuEstado" id="estado" value="<?php echo @$ret[0]['chuEstado'];?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
        </div>
    	<div id="pais" class="form-group col-md-6">
    		<label for="pais">País</label>
    		<input type="text" name="chuPais" id="pais" value="<?php echo @$ret[0]['chuPais'];?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    	</div> 
    </div>
    <div class="form-row">
        <div id="cep" class="form-group col-md-2">
        	<label for="cep">Cep</label>
        	<input type="text" name="chuCep" id="cep" value="<?php echo @$ret[0]['chuCep'];?>" onkeyup="maiuscula(this)"  class="form-control" readonly>
        </div>
  	</div> 
   <div class="form-row" >
        <div id="data" class="form-group col-md-2">
        	<label for="data">Data da Criação</label>
        	<input type="text" name="chuData" id="data" value="<?php echo Validador::bancoToUser( @$ret[0]['chuData']); ?>" class="form-control" readonly>
        </div>
        <div id="telefone" class="form-group col-md-2">
        	<label for="telefone">Telefone</label>
        	<input type="text" name="chuTelefone" id="telefone" value="<?php echo  @$ret[0]['chuTelefone']; ?>" class="form-control" readonly>
        </div>
        <div id="regiao" class="form-group col-md-4">
                <label for="regiao">Região</label><span><?php $regiao= @$ret[0]['chuRegiao'];?></span>
            	<select id="regiao" name="chuRegiao" class="form-control" disabled readonly>
            		<option value="0"></option>
            		<option value="1" <?=($regiao == '1')?'selected':''?>>1° Região</option>
            		<option value="2" <?=($regiao == '2')?'selected':''?>>2° Região</option>
            		<option value="3" <?=($regiao == '3')?'selected':''?>>3° Região</option>
            		<option value="4" <?=($regiao == '4')?'selected':''?>>4° Região</option>
            		<option value="5" <?=($regiao == '5')?'selected':''?>>5° Região</option>
            		<option value="6" <?=($regiao == '6')?'selected':''?>>6° Região</option>
            	</select>         
    	</div>
   </div>
    <div class="form-row" >
        <div id="email" class="form-group col-md-4">
        	<label for="email">Email</label>
        	<input type="text" name="chuEmail" id="email" value="<?php echo  @$ret[0]['chuEmail'] ?>" class="form-control" readonly>
        </div>
    </div>
  </div>   
</div>
