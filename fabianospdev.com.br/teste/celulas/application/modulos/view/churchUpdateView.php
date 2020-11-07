<?php
use modulos\Igreja;
use application\functions\Validador;

require 'init.php';
include_once 'modulos/Igreja.php';
include_once '../application/functions/Validador.php';
include_once '../js/functions.js';


$igr = new Igreja();

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $igr->readWholeByid($id);
}

$ret=$igr->getDados();

if (isset($_POST['chuIgreja'])){
    $igr = new Igreja();
    $igr->update=TRUE;
    $_SESSION['chuId'] = $id;
    $_SESSION['chuuid']= $_POST['chuIgreja']; //passa por sh1
    $_SESSION['chuIgreja']= $_POST['chuIgreja'];
    $_SESSION['chuEndereco']= $_POST['chuEndereco'];
    $_SESSION['chuBairro']= $_POST['chuBairro'];
    $_SESSION['chuCidade']= $_POST['chuCidade'];
    $_SESSION['chuEstado']= $_POST['chuEstado'];
    $_SESSION['chuPais']= $_POST['chuPais'];
    $_SESSION['chuCep']= $_POST['chuCep'];
    $_SESSION['chuData']= $_POST['chuData'];
    $_SESSION['chuTelefone']= $_POST['chuTelefone'];
    $_SESSION['chuEmail']= $_POST['chuEmail'];
    $_SESSION['chuRegiao']= $_POST['chuRegiao'];
    
    $igr->setId($_SESSION['chuId']);
    $igr->setUid(sha1($_SESSION['chuIgreja']));//passa por sha1
    $igr->setIgreja($_SESSION['chuIgreja']);
    $igr->setEndereco($_SESSION['chuEndereco']);
    $igr->setBairro($_SESSION['chuBairro']);
    $igr->setCidade($_SESSION['chuCidade']);
    $igr->setEstado($_SESSION['chuEstado']);
    $igr->setPais($_SESSION['chuPais']);
    $igr->setCep($_SESSION['chuCep']);
    $igr->setData($_SESSION['chuData']);
    $igr->setTelefone($_SESSION['chuTelefone']);
    $igr->setEmail($_SESSION['chuEmail']);
    $igr->setRegiao($_SESSION['chuRegiao']);
    
    $igr->update();
    
    $igr->update=FALSE;
    $igr= NULL;
    
    header( "Location: index.php?pag=modulos_view_churchReadView" );
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
		<a href="index.php?pag=site_view_churchReadView" class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
		<a href="" data-toggle="modal" data-target="#modal-apaga" style="float: right;">
			<span class="glyphicon glyphicon-trash btn-apaga">
				<label class="acessoSmart" style='display: none'>Apagar</label>
			</span>
		</a>
</div>
<form action="" method="post" accept-charset="UTF-8">
<div class="layoutPadrao panel-body">
<div class="panel-heading" style="margin-top: -20px;">
	<h1>Atualiar registro da Igreja   &nbsp;&nbsp;&nbsp;<b><?php echo @$ret[0]['chuIgreja']; ?></b></h1>
</div>
<div>
  <div class="form-row" style="margin-top: -10px;"> 
      <div id="id" class=""> 
       		<input type="hidden" name="celId" id="id" value="<?php echo @$ret[0]['chuId'];?>" class="">
      </div> 
      <div id="celula" class="form-group col-md-6" style="margin-top: 30px;margin-left: 0%;">
        	<label for="igreja">Igreja</label>
        	<input type="text" name="chuIgreja" id="igreja" value="<?php echo @$ret[0]['chuIgreja']; ?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
      <div id="endereco" class="form-group col-md-6" style="margin-top: 30px;margin-left: 0%;">
        	<label for="endereco">Endereco</label>
        	<input type="text" name="chuEndereco" id="endereco" value="<?php echo @$ret[0]['chuEndereco']; ?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
   </div>
 <div class="form-row">
      <div id="bairro" class="form-group col-md-6" >
        	<label for="bairro">Bairro</label>
        	<input type="text" name="chuBairro" id="bairro" value="<?php echo @$ret[0]['chuBairro'];?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
      <div id="cidade" class="form-group col-md-6">
        	<label for="cidade">Cidade</label>
        	<input type="text" name="chuCidade" id="cidade" value="<?php echo @$ret[0]['chuCidade'];?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
    </div> 
    <div class="form-row">
    	<div id="estado" class="form-group col-md-6" style="margin-left: 0%;">
        	<label for="estado">Estado</label>
        	<input type="text" name="chuEstado" id="estado" value="<?php echo @$ret[0]['chuEstado'];?>"  onkeyup="maiuscula(this)" class="form-control">
        </div>
    	<div id="pais" class="form-group col-md-6">
    		<label for="pais">País</label>
    		<input type="text" name="chuPais" id="pais" value="<?php echo @$ret[0]['chuPais'];?>"  onkeyup="maiuscula(this)" class="form-control">
    	</div> 
    </div>
    <div class="form-row">
        <div id="cep" class="form-group col-md-2">
        	<label for="cep">Cep</label>
        	<input type="text" name="chuCep" id="cep" value="<?php echo @$ret[0]['chuCep'];?>" onkeyup="maiuscula(this)"  class="form-control">
        </div>
  	</div> 
   <div class="form-row" >
        <div id="data" class="form-group col-md-2">
        	<label for="data">Data da Criação</label>
        	<input type="text" name="chuData" id="data" value="<?php echo Validador::bancoToUser( @$ret[0]['chuData'] );?>" class="form-control">
        </div>
        <div id="telefone" class="form-group col-md-2">
        	<label for="telefone">Telefone</label>
        	<input type="text" name="chuTelefone" id="telefone" value="<?php echo  @$ret[0]['chuTelefone']; ?>" class="form-control">
        </div>
    </div>
    <div class="form-row" >
     	<div id="email" class="form-group col-md-6">
        	<label for="email">Email</label>
        	<input type="text" name="chuEmail" id="email" value="<?php echo  @$ret[0]['chuEmail']; ?>" class="form-control">
    	</div>
        <div id="regiao" class="form-group col-md-4">
                <label for="regiao">Região</label><span><?php $regiao= @$ret[0]['chuRegiao'];?></span>
            	<select id="regiao" name="chuRegiao" class="form-control" required>
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
   	<div class="submitting" style="margin: 30px auto 50px auto ">
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
		<a href="index.php?page=site_view_churchDeleteView&id=<?php echo $id ?>&ac=delpen" 
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
