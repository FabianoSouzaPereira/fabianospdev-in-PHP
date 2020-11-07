<?php

use modulos\Igreja;
use application\functions\Validador;

require 'init.php';
include_once 'modulos/Igreja.php';
include_once '../application/functions/Validador.php';
include_once '../js/functions.js';



$id=null;
$ret=null;
$igr = new Igreja();
$igr->lastId();
$idRes=$igr->getLastId();

if(is_array($idRes)){
    Foreach($idRes as $raw) {
        $id= $raw;
    }
}


if (isset($_POST['chuIgreja'])){
    $igr = new Igreja();
    $igr->insert=TRUE;
    $_SESSION['chuId'] = $id+=1;
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
    $igr->setUid(sha1($_SESSION['chuIgreja']));
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
    
    $igr->insert();
    
    $igr->insert=FALSE;
    $igr= NULL;
    
    header( "Location: index.php?pag=modulos_view_churchReadView" );
    exit(); 
    
}

?>

<script   type="text/javascript">
$(document).keypress(function(e) {
    if(e.which == 13) $('#enviar').click();
	});
$(document).keypress(function(ei) {
    if(ei.which == 8) $('#limpar').click();
	});
</script>
<div id="voltar" style="margin-top:-50px; width: 100%;">
	<a href="index.php?pag=modulos_view_churchReadView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
</div>
<form action="" method="post" accept-charset="UTF-8">
<div class="layoutPadrao panel-body" style="margin-top:20px;">
<div class="panel-heading" style="margin-top: -20px;">
	<h1>Criar nova Igreja</h1>
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
        <!-- <select id="estado" name="estado" class="form-control" onchange="getcidades(value)">
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
            <option value="EX">Estrangeiro</option>
        </select> -->
        </div>
    	<div id="pais" class="form-group col-md-6">
    		<label for="pais">País</label>
    		<input type="text" name="chuPais" id="pais" value="<?php echo @$ret[0]['chuPais'];?>"  onkeyup="maiuscula(this)" class="form-control">
    	</div> 
    </div>
    <div class="form-row">
        <div id="cep" class="form-group col-md-2">
        	<label for="cep">Cep</label>
        	<input type="number" name="chuCep" id="cep" value="<?php echo @$ret[0]['chuCep'];?>" onkeyup="maiuscula(this)"  class="form-control">
        </div>
  	</div> 
   <div class="form-row" >
        <div id="data" class="form-group col-md-2">
        	<label for="data">Data da Criação</label>
        	<input type="text" name="chuData" id="data" value="<?php echo  date('d/m/Y'); ?>" class="form-control mascaraData">
        </div>
        <div id="telefone" class="form-group col-md-2">
        	<label for="telefone">Telefone</label>
        	<input type="text" name="chuTelefone" id="telefone" value="<?php echo  @$ret[0]['chuTelefone']; ?>" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" class="form-control mascaraTelefone" placeholder="Digite o telefone" >
        </div>
  </div> 
     <div class="form-row" >
     <div id="email" class="form-group col-md-6">
        	<label for="email">Email</label>
        	<input type="email" name="chuEmail" id="email" value="<?php echo  @$ret[0]['chuEmail']; ?>" class="form-control">
    </div>
    <div id="regiao" class="form-group col-md-4">
    <label>Região</label> 
	<select id="regiao" name="chuRegiao" class="form-control" required>
		<option value="0"></option>
		<option value="1">1° Região</option>
		<option value="2">2° Região</option>
		<option value="3">3° Região</option>
		<option value="4">4° Região</option>
		<option value="5">5° Região</option>
		<option value="6">6° Região</option>
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
