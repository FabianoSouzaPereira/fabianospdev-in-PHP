<?php
use modulos\Usuario;

require 'init.php';
include_once 'Usuario.php';
include_once 'application/functions/Validador.php';
include_once 'js/functions.js';

$id=null;
$usu=new Usuario();
if(isset($_GET['id'])){
    $id=$_GET['id'];
}

$usu->readWholeByid($id);
$ret=$usu->getDados();
$usu=null; 

?>
<div id="voltar" style="margin-top:-50px; width: 100%;">
	<a href="index.php?pag=site_view_userReadView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
	<span><p id="aviso" >Alguns campos são propositalmente criptografados para segurança</p></span>
	<a href="" data-toggle="modal" data-target="#modal-apaga" style="float:right;">
	<span class="glyphicon glyphicon-trash btn-apaga"><label class="acessoSmart" style='display: none'>Apagar</label></span></a>
</div>
<div>
<div class="layoutPadrao panel-body">
<div class="panel-heading" style="margin-top: -15px;">
<h1>Detalhes do Usuário &nbsp;&nbsp;&nbsp;<?php echo @$ret[0]['usuNome']; ?></h1>
</div>
    <div class="form-row" style="margin-top: -20px;">
      <div id="usuId" class="form-group col-md-0" style="margin-top: 30px;margin-bottom: 0px;width: 0px; margin-left: 0%;">                           
      	<input type="hidden" name="usuId" id="usuId" value="<?php echo @$ret[0]['usuId']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>                       
      </div>
      <div id="uid" class="form-group col-md-4" style="margin-top: 0px;margin-bottom: 0px;margin-left: 0%;">
       <label>uid</label>
       <input type="text" name="usuuid" id="uid" value="<?php echo @$ret[0]['usuuid']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
      </div>
    </div>
    <div class="form-row" style="margin-top: 2px;margin-top: 30px;">
    <div id="email" class="form-group col-md-6">
      <label>Email</label>
      <input type="text" name="usuEmail" id="email" value="<?php echo @$ret[0]['usuEmail'];?>"  class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="nome" class="form-group col-md-6">
      <label>Nome</label>
      <input type="text" name="usuNome" id="nome" value="<?php echo @$ret[0]['usuNome'];?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="sobrenome" class="form-group col-md-6">
      <label>Sobre Nome</label>
      <input type="text" name="usuSobreNome" id="sobrenome" value="<?php echo @$ret[0]['usuSobreNome'];?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="senha" class="form-group col-md-6">
      <label>Senha</label>
      <input type="text" name="usuSenha" id="senha" value="<?php echo @$ret[0]['usuSenha']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="tentativa" class="form-group col-md-2">
      <label>Tentativa</label>
      <input type="text" name="usuTentativa" id="tentativa" value="<?php echo @$ret[0]['usuTentativa']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="bloqueado" class="form-group col-md-1">
      <label>Bloqueado</label>
      <input type="text" name="usuBloqueado" id="bloqueado" value="<?php echo @$ret[0]['usuBloqueado']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
      <div class="form-row" style="margin-top: 2px;">
      <div id="data" class="form-group col-md-2">
      <label>Data</label>
      <input type="text" name="usuData" id="data" value="<?php echo @$ret[0]['usuData']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="tipo" class="form-group col-md-2">
      	<label for="tipo">Tipo</label><pan><?php $tipo= @$ret[0]['usuTipo'];?></pan>
    	<select id="tipo" name="usuTipo" class="form-control" required>
			<option value="1" <?= ($_SESSION['tipo']=='1' && $tipo == '1')?'selected':'hidden="hidden"'?>>Administrador</option>
			<option value="2" <?= ($_SESSION['tipo']<='2' && $tipo == '2')?'selected':'hidden="hidden"'?>>Coordenador</option>
			<option value="3" <?= ($_SESSION['tipo']<='3' && $tipo == '3')?'selected':'hidden="hidden"'?>>Pastor</option>
			<option value="4" <?= ($_SESSION['tipo']<='4' && $tipo == '4')?'selected':'hidden="hidden"'?>>Lider</option>
    		<option value="5" <?= ($_SESSION['tipo']<='5' && $tipo == '5')?'selected':''?>>COLABORADOR</option>
    		<option value="6" <?= ($_SESSION['tipo']<='6' && $tipo == '6')?'selected':''?>>COMUM</option>
    	</select>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="acesso" class="form-group col-md-1">
      <label>Acesso</label>
      <input type="text" name="usuAcesso" id="acesso" value="<?php echo @$ret[0]['usuAcesso']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>                          
    <div class="form-row" style="margin-top: 2px;">
    <div id="status" class="form-group col-md-1">
        <label>Status</label>                    
      <input type="text" name="usuStatus" id="status" value="<?php echo @$ret[0]['usuStatus']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>                   
    </div>
    </div>
</div>                      
</div>
