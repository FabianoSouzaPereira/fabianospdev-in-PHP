<?php 

use mobile\modulos\Celula;

require 'mobile/init.php';
include_once 'mobile/modulos/Celula.php';
include_once '../functions/Validador.php';
include_once '../js/functions.js';

$id=null;
$ret=null;
$cel=new Celula();
$cel->lastId();
$idRes=$cel->getLastId();

if(is_array($idRes)){
    Foreach($idRes as $raw) {
        $id= $raw;
    }
}

if(isset($_POST['celCelula'])){
    
    $celin= new Celula();
    $celin->insert= TRUE;
    $_SESSION['celId'] = $id+=1;
    $_SESSION['celuuid'] = $_POST['celCelula']; //passa celula por sh1
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
    $_SESSION['celIgreja']=$_POST['celIgreja'];
    $_SESSION['celStatus']='1';
    
    $celin->setId($_SESSION['celId'] );
    $celin->setCelula($_SESSION['celCelula']);
    $celin->setUid(sha1($_SESSION['celuuid']));
    $celin->setRede($_SESSION['celRede']);
    $celin->setLider($_SESSION['celLider']);
    $celin->setViceLider($_SESSION['celViceLider']);
    $celin->setSecretario($_SESSION['celSecretario']);
    $celin->setAnfitriao($_SESSION['celAnfitriao']);
    $celin->setColaborador($_SESSION['celColaborador']);
    $celin->setData($_SESSION['celData']);
    $celin->setDia($_SESSION['celDia']);
    $celin->setHora($_SESSION['celHora']);
    $celin->setCeluserid($_SESSION['usuId']);
    $celin->setIgreja($_SESSION['celIgreja']);
    $celin->setStatus($_SESSION['celStatus']);
       
    $celin->insertCelula();
    
    $celin->insert= FALSE;
    $celin= NULL;

    header( "Location: index.php?pag=modulos_view_celulasReadView" );
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
<div id="voltar" style="margin-top:-50px; width: 100%;">
	<a href="index.php?pag=modulos_view_celulasReadView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
</div>
<form action="" method="post" accept-charset="UTF-8">
<div class="layoutPadrao panel-body">
<div class="panel-heading" style="margin-top: -20px;">
	<h1>Criar nova Célula</h1>
</div>
<div>
  <div class="form-row" style="margin-top: -10px;"> 
      <div id="id" class=""> 
       		<input type="hidden" name="celId" id="id" value="<?php echo @$ret[0]['celId'];?>" class="">
      </div> 
      <div id="celula" class="form-group col-md-6" style="margin-top: 30px;margin-bottom: 0px;margin-left: 0%;">
        	<label for="celula">Célula</label>
        	<input type="text" name="celCelula" id="celula" value="<?php echo @$ret[0]['celCelula']; ?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
      <div id="rede" class="form-group col-md-6" style="margin-top: 30px;margin-bottom: 0px;margin-left: 0%;">
        	<label for="rede">Rede</label>
        	<input type="text" name="celRede" id="rede" value="<?php echo @$ret[0]['celRede']; ?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
      <div id="lider" class="form-group col-md-6" style="margin-top: 2px;">
        	<label for="lider">Lider</label>
        	<input type="text" name="celLider" id="lider" value="<?php echo @$ret[0]['celLider'];?>"  onkeyup="maiuscula(this)" class="form-control">
      </div>
  </div>  
  <div class="form-row">   
        <div id="vicelider" class="form-group col-md-6"style="margin-top: 2px;" >
        	<label for="vicelider">vice-lider</label>
        	<input type="text" name="celViceLider" id="vicelider" value="<?php echo @$ret[0]['celViceLider'];?>"  onkeyup="maiuscula(this)" class="form-control">
        </div>
    	<div id="secretario" class="form-group col-md-6">
        	<label for="secretario">secretário</label>
        	<input type="text" name="celSecretario" id="secretario" value="<?php echo @$ret[0]['celSecretario'];?>"  onkeyup="maiuscula(this)" class="form-control">
        </div>
  </div> 
  <div class="form-row" >  
    <div id="anfitriao" class="form-group col-md-6">
    	<label for="anfitriao">Anfitrião</label>
    	<input type="text" name="celAnfitriao" id="anfitriao" value="<?php echo @$ret[0]['celAnfitriao'];?>"  onkeyup="maiuscula(this)" class="form-control">
    </div> 
    <div id="colaborador" class="form-group col-md-6">
    	<label for="colaborador">Colaborador</label>
    	<input type="text" name="celColaborador" id="colaborador" value="<?php echo @$ret[0]['celColaborador'];?>" onkeyup="maiuscula(this)"  class="form-control">
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
        	<input type="text" name="celData" id="data" value="<?php echo  date('d/m/Y'); ?>" class="form-control">
        </div>
        <div id="igreja" class="form-group col-md-3">
        	<label for="igreja">Igreja</label>
        	<input type="text" name="celIgreja" id="igreja" value="<?php echo  @$ret[0]['celIgreja']; ?>" class="form-control">
        </div>
  </div>
   	<div class="submitting">
		<input id="enviar" type="submit" class="left btn btn-success"  value="Enviar">
		<input id="limpar" type="submit" class="right btn btn-default" value="Limpar Campos">
	</div>
</div>
</div>
</form>
