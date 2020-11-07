<?php
use modulos\Usuario;
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
$usu= new Usuario();
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
$usu->pastorReadWholeByid($id);
$ret=$usu->getDados();
$usu=null;

if(isset($_POST['usuEmail'])){
    
    $usu= new Usuario();
    $usu->update=TRUE;
    $_SESSION['usuId'] = $id;
    $_SESSION['usuEmail'] = $_POST['usuEmail'];
    $_SESSION['usuNome'] = $_POST['usuNome'];
    $_SESSION['usuSobreNome'] = $_POST['usuSobreNome'];
    $_SESSION['usuSenha'] = $_POST['usuSenha'];
    $_SESSION['usuTentativa'] = $_POST['usuTentativa'];
    $_SESSION['usuBloqueado'] =$_POST['usuBloqueado'];    
    $_SESSION['usuData'] = $_POST['usuData'];
    $_SESSION['usuTipo'] = $_POST['usuTipo'];
    $_SESSION['usuStatus'] = $_POST['usuStatus'];
    $usu->setUsuId($_SESSION['usuId']);
    $usu->setUsuEmail($_SESSION['usuEmail']);
    $usu->setUsuNome($_SESSION['usuNome']);
    $usu->setUsuSobreNome($_SESSION['usuSobreNome']);
    $usu->setUsuSenha($_SESSION['usuSenha']);
    $usu->setUsuTentativa($_SESSION['usuTentativa'] );
    $usu->setUsuBloqueado($_SESSION['usuBloqueado']);
    $usu->setUsuData(Validador::dataToBanco($_SESSION['usuData']));
    $usu->setUsuTipo($_SESSION['usuTipo']);
    $usu->setUsuStatus($_SESSION['usuStatus']);
    
    $usu->pastorUpdate();
    $usu->update= FALSE;
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
	<a href="" data-toggle="modal" data-target="#modal-apaga" style="display:inline-block;float:right;">
	<span class="glyphicon glyphicon-trash btn-apaga"><label class="acessoSmart" style="display: none">Apagar</label></span></a>
</div>
<div>
<form action="" method="post" accept-charset="UTF-8">
<div class="layoutPadrao panel-body">
<div class="panel-heading" style="margin-top: -15px;">
<h1>Atualizar Usuário  &nbsp;&nbsp;&nbsp;<?php echo @$ret[0]['usuNome']; ?></h1>
</div>
    <div class="form-row" style="margin-top: -20px;">
      <div id="usuId" class="form-group col-md-0" style="margin-top: 30px;margin-bottom: 0px;width: 0px; margin-left: 0%;">                               
      	<input type="hidden" name="usuId" id="usuId" value="<?php echo @$ret[0]['usuId']; ?>"  onkeyup="maiuscula(this)" class="form-control">                       
      </div>
      <div id="uid" class="form-group col-md-4" style="margin-top: 0px;margin-bottom: 0px;margin-left: 0%;">
       <label for="uid">uid</label>
       <input type="text" name="usuuid" id="uid" value="<?php echo @$ret[0]['usuuid']; ?>"  onkeyup="maiuscula(this)" class="form-control" disabled="disabled">
      </div>
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
      <input type="text" name="usuNome" id="nome" value="<?php echo @$ret[0]['usuNome'];?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="sobrenome" class="form-group col-md-6">
      <label for="sobrenome">Sobre Nome</label>
      <input type="text" name="usuSobreNome" id="sobrenome" value="<?php echo @$ret[0]['usuSobreNome'];?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="senha" class="form-group col-md-5">
      <label for="senha">Senha</label>
      <input type="text" name="usuSenha" id="senha" value="<?php echo @$ret[0]['usuSenha']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="tentativa" class="form-group col-md-1">
      <label for="tentativa">Tentativa</label>
      <input type="text" name="usuTentativa" id="tentativa" value="<?php echo @$ret[0]['usuTentativa']; ?>"  onkeyup="maiuscula(this)" class="form-control" readonly>
    </div>
    </div>
    <div class="form-row" style="margin-top: 2px;">
    <div id="bloqueado" class="form-group col-md-2">
      <label for="bloqueado">Bloqueado</label>

       <?php $status=@$ret[0]['usuBloqueado']; ?>
       <select id="bloqueado" name="usuBloqueado" class="form-control" required>
       		<option value="NÃO" <?=($status == 'NÃO')?'selected':''?>>NÃO</option> 
    		<option value="SIM" <?=($status == 'SIM')?'selected':''?>>SIM</option>  		 		
      </select>
    </div>
    </div>
      <div class="form-row" style="margin-top: 2px;">
      <div id="data" class="form-group col-md-2">
      <label for="data">Data</label>
      <input type="text" name="usuData" id="data" value="<?php echo Validador::bancoToUser(@$ret[0]['usuData']); ?>"  onkeyup="maiuscula(this)" class="form-control">
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
      <input type="text" name="usuAcesso" id="acesso" value="<?php echo @$ret[0]['usuAcesso']; ?>"  onkeyup="maiuscula(this)" class="form-control">
    </div>
    </div>                          
    <div class="form-row" style="margin-top: 2px;">
    <div id="status" class="form-group col-md-2">
        <label for="status">Status</label>                                    
       <?php $status=@$ret[0]['usuStatus']; ?>
       <select id="status" name="usuStatus" class="form-control" required>
    		<option value="1" <?=($status == '1')?'selected':''?>>ATIVO</option>
    		<option value="0" <?=($status == '0')?'selected':''?>>INATIVO</option>  		
      </select>
    </div>
    </div>
    <div class="submitting">
		<input id="enviar" type="submit" class="left btn btn-success"  value="Enviar">
		<input id="limpar" type="submit" class="right btn btn-default"  name="Cancelar"value="Cancelar">
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
		<a href="index.php?page=site_view_userDeleteView&id=<?php echo $id ?>&au=delpen" 
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
