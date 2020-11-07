<?php

use \modulos\Usuario;
use application\functions\Validador;

require 'init.php';
include_once 'application/modulos/Usuario.php';
include_once 'application/functions/Validador.php';
include_once 'js/functions.js';



if (isset($_POST['Cancelar'])){
    header( "Location: index.php?pag=site_view_userReadView" );
    exit(); 
}



$id=null;
$ret=null;
$usu=new Usuario();
$usu->lastId();
$idRes=$usu->getLastId();

if(is_array($idRes)){
    Foreach($idRes as $raw) {
        $id= $raw;
    }
}

if(isset($_POST['usuEmail'])){

    $usu= new Usuario();
    $usu->insert=TRUE;
    $_SESSION['usuId']= $id+=1;
    $_SESSION['usuEmail'] = $_POST['usuEmail'];
    $_SESSION['usuNome'] = $_POST['usuNome'];
    $_SESSION['usuSobreNome'] = $_POST['usuSobreNome'];
    $_SESSION['usuSenha'] = $_POST['usuSenha'];
    $_SESSION['usuData'] = $_POST['usuData'];
    $_SESSION['usuTipo'] = $_POST['usuTipo'];
    $usu->setUsuId($_SESSION['usuId']);
    $usu->setUsuuid(sha1($_SESSION['usuEmail']));
    $usu->setUsuEmail($_SESSION['usuEmail']);
    $usu->setUsuNome($_SESSION['usuNome'] );
    $usu->setUsuSobreNome($_SESSION['usuSobreNome']);
    $usu->setUsuSenha(sha1(md5($_SESSION['usuSenha'])));
    $usu->setUsuData(Validador::dataToBanco($_SESSION['usuData']));
    $usu->setUsuTipo($_SESSION['usuTipo']);

    $usu->pastorInsert();
    $usu->insert= FALSE;
    unset($_SESSION['usuId']);
    unset($_SESSION['usuEmail']);
    unset($_SESSION['usuNome']);
    unset($_SESSION['usuSobreNome']);
    unset($_SESSION['usuSenha']);
    unset($_SESSION['usuData']);
    unset($_SESSION['usuTipo']);
    $usu= NULL;
    
    header( "Location: index.php?pag=site_view_userReadView" );
    exit(); 

}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).keypress(function(e) {
    if(e.which == 13) $('#enviar').click();
	});
$(document).keypress(function(ei) {
    if(ei.which == 8) $('#limpar').click();
	});
</script>
<script>
$(function(){
    $('input[type="text"]').change(function(){
        this.value = $.trim(this.value);
    });
});
</script>
<div class="tela">
<div class="formato">
<div class="navegacao">
	<a href="index.php?pag=site_view_userReadView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
	<span><p id="aviso" >Alguns campos são propositalmente criptografados para segurança</p></span>
</div>
<div>
<form action="" method="post" accept-charset="UTF-8">
<div class="layoutPadrao panel-body">
<div class="panel-heading" style="margin-top: -15px;">
<h1>Criar novo Usuário</h1>
</div>
  <div class="form-row" style="margin-top: 2px;margin-top: 30px;">
    <div id="email" class="form-group col-md-6">
      <label for="email">Email</label>
      <input type="text" name="usuEmail" id="email" value="<?php echo @$ret[0]['usuEmail']; ?>"  class="form-control">
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="nome" class="form-group col-md-6">
      <label for="nome">Nome</label>
      <input type="text" name="usuNome" id="nome" value="<?php echo @$ret[0]['usuNome']; ?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="sobrenome" class="form-group col-md-6">
      <label for="sobrenome">Sobre Nome</label>
      <input type="text" name="usuSobreNome" id="sobrenome" value="<?php echo @$ret[0]['usuSobreNome']; ?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="senha" class="form-group col-md-6">
      <label for="senha">Senha</label>
      <input type="text" name="usuSenha" id="senha" value="<?php echo @$ret[0]['usuSenha']; ?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
      <div id="data" class="form-group col-md-2">
      <label for="data">Data</label>
      <input type="text" name="usuData" id="data" value="<?php echo date('d/m/Y'); ?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
    </div>
    <div class="form-row" style="margin-top: 20px;">
    <div id="tipo" class="form-group col-md-2">
    <label for="tipo">Tipo</label>
	<select id="tipo" name="usuTipo" class="form-control" required>
		<option value="1" <?= ($_SESSION['tipo']<='1')?'selected':'hidden="hidden"'?>>Administrador</option>
		<option value="2" <?= ($_SESSION['tipo']<='2')?'selected':'hidden="hidden"'?>>Coordenador</option>
		<option value="3" <?= ($_SESSION['tipo']<='3')?'selected':'hidden="hidden"'?>>Pastor</option>
		<option value="4" <?= ($_SESSION['tipo']<='4')?'selected':'hidden="hidden"'?>>Lider</option>
		<option value="5" <?=($tipo <= '5')?'':'hidden=hidden disabled=disabled'?>>Colaborador</option>
		<option value="6" <?=($tipo <= '6')?'':'hidden=hidden disabled=disabled'?>>Comum</option>
	</select>
    </div>
    </div>                          
    <div class="submitting">
		<input id="enviar" type="submit" class="left btn btn-success"  value="Enviar">
		<input id="limpar" type="submit" class="right btn btn-default" name="Cancelar" value="Cancelar">
	</div>
</div>
</form> 
</div>                      
</div>