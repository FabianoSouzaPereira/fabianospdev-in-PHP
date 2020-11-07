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
            		<option value="1" <?=($regiao == '1')?'selected':''?>>1ª Região</option>
            		<option value="2" <?=($regiao == '2')?'selected':''?>>2ª Região</option>
            		<option value="3" <?=($regiao == '3')?'selected':''?>>3ª Região</option>
            		<option value="4" <?=($regiao == '4')?'selected':''?>>4ª Região</option>
            		<option value="5" <?=($regiao == '5')?'selected':''?>>5ª Região</option>
            		<option value="6" <?=($regiao == '6')?'selected':''?>>6ª Região</option>
        			<option value="7" <?=($regiao == '7')?'selected':''?>>7ª Região</option>
        			<option value="8" <?=($regiao == '8')?'selected':''?>>8ª Região</option>
        			<option value="9" <?=($regiao == '9')?'selected':''?>>9ª Região</option>
        			<option value="10" <?=($regiao == '10')?'selected':''?>>10ª Região</option>
        			<option value="11" <?=($regiao == '11')?'selected':''?>>11ª Região</option>
        			<option value="12" <?=($regiao == '12')?'selected':''?>>12ª Região</option>
        			<option value="13" <?=($regiao == '13')?'selected':''?>>13ª Região</option>
        			<option value="14" <?=($regiao == '14')?'selected':''?>>14ª Região</option>
        			<option value="15" <?=($regiao == '15')?'selected':''?>>15ª Região</option>
        			<option value="16" <?=($regiao == '16')?'selected':''?>>16ª Região</option>
        			<option value="17" <?=($regiao == '17')?'selected':''?>>17ª Região</option>
        			<option value="18" <?=($regiao == '18')?'selected':''?>>18ª Região</option>
        			<option value="19" <?=($regiao == '19')?'selected':''?>>19ª Região</option>
        			<option value="20" <?=($regiao == '20')?'selected':''?>>20ª Região</option>
        			<option value="21" <?=($regiao == '21')?'selected':''?>>21ª Região</option>
        			<option value="22" <?=($regiao == '22')?'selected':''?>>22ª Região</option>
        			<option value="23" <?=($regiao == '23')?'selected':''?>>23ª Região</option>
        			<option value="24" <?=($regiao == '24')?'selected':''?>>24ª Região</option>
        			<option value="25" <?=($regiao == '25')?'selected':''?>>25ª Região</option>
        			<option value="26" <?=($regiao == '26')?'selected':''?>>26ª Região</option>
        			<option value="27" <?=($regiao == '27')?'selected':''?>>27ª Região</option>
        			<option value="28" <?=($regiao == '28')?'selected':''?>>28ª Região</option>
        			<option value="29" <?=($regiao == '29')?'selected':''?>>29ª Região</option>
        			<option value="30" <?=($regiao == '30')?'selected':''?>>30ª Região</option>
        			<option value="31" <?=($regiao == '31')?'selected':''?>>31ª Região</option>
        			<option value="32" <?=($regiao == '32')?'selected':''?>>32ª Região</option>
        			<option value="33" <?=($regiao == '33')?'selected':''?>>33ª Região</option>
        			<option value="34" <?=($regiao == '34')?'selected':''?>>34ª Região</option>
        			<option value="35" <?=($regiao == '35')?'selected':''?>>35ª Região</option>
        			<option value="36" <?=($regiao == '36')?'selected':''?>>36ª Região</option>
        			<option value="37" <?=($regiao == '37')?'selected':''?>>37ª Região</option>
        			<option value="38" <?=($regiao == '38')?'selected':''?>>38ª Região</option>
        			<option value="39" <?=($regiao == '39')?'selected':''?>>39ª Região</option>
        			<option value="40" <?=($regiao == '40')?'selected':''?>>40ª Região</option>
        			<option value="41" <?=($regiao == '41')?'selected':''?>>41ª Região</option>
        			<option value="42" <?=($regiao == '42')?'selected':''?>>42ª Região</option>
        			<option value="43" <?=($regiao == '43')?'selected':''?>>43ª Região</option>
        			<option value="44" <?=($regiao == '44')?'selected':''?>>44ª Região</option>
        			<option value="45" <?=($regiao == '45')?'selected':''?>>45ª Região</option>
        			<option value="46" <?=($regiao == '46')?'selected':''?>>46ª Região</option>
        			<option value="47" <?=($regiao == '47')?'selected':''?>>47ª Região</option>
        			<option value="48" <?=($regiao == '48')?'selected':''?>>48ª Região</option>
        			<option value="49" <?=($regiao == '49')?'selected':''?>>49ª Região</option>
        			<option value="50" <?=($regiao == '50')?'selected':''?>>50ª Região</option>
        			<option value="51" <?=($regiao == '51')?'selected':''?>>51ª Região</option>
        			<option value="52" <?=($regiao == '52')?'selected':''?>>52ª Região</option>
        			<option value="53" <?=($regiao == '53')?'selected':''?>>53ª Região</option>
        			<option value="54" <?=($regiao == '54')?'selected':''?>>54ª Região</option>
        			<option value="55" <?=($regiao == '55')?'selected':''?>>55ª Região</option>
        			<option value="56" <?=($regiao == '56')?'selected':''?>>56ª Região</option>
        			<option value="57" <?=($regiao == '57')?'selected':''?>>57ª Região</option>
        			<option value="58" <?=($regiao == '58')?'selected':''?>>58ª Região</option>
        			<option value="59" <?=($regiao == '59')?'selected':''?>>59ª Região</option>
        			<option value="60" <?=($regiao == '60')?'selected':''?>>60ª Região</option>
        			<option value="61" <?=($regiao == '61')?'selected':''?>>61ª Região</option>
        			<option value="62" <?=($regiao == '62')?'selected':''?>>62ª Região</option>
        			<option value="63" <?=($regiao == '63')?'selected':''?>>63ª Região</option>
        			<option value="64" <?=($regiao == '64')?'selected':''?>>64ª Região</option>
        			<option value="65" <?=($regiao == '65')?'selected':''?>>65ª Região</option>
                    <option value="	66	"	<?=($regiao == '66')?'selected':'' ?>	>	66	ª Região</option>
                    <option value="	67	"	<?=($regiao == '67')?'selected':'' ?>	>	67	ª Região</option>
                    <option value="	68	"	<?=($regiao == '68')?'selected':'' ?>	>	68	ª Região</option>
                    <option value="	69	"	<?=($regiao == '69')?'selected':'' ?>	>	69	ª Região</option>
                    <option value="	70	"	<?=($regiao == '70')?'selected':'' ?>	>	70	ª Região</option>
                    <option value="	71	"	<?=($regiao == '71')?'selected':'' ?>	>	71	ª Região</option>
                    <option value="	72	"	<?=($regiao == '72')?'selected':'' ?>	>	72	ª Região</option>
                    <option value="	73	"	<?=($regiao == '73')?'selected':'' ?>	>	73	ª Região</option>
                    <option value="	74	"	<?=($regiao == '74')?'selected':'' ?>	>	74	ª Região</option>
                    <option value="	75	"	<?=($regiao == '75')?'selected':'' ?>	>	75	ª Região</option>
                    <option value="	76	"	<?=($regiao == '76')?'selected':'' ?>	>	76	ª Região</option>
                    <option value="	77	"	<?=($regiao == '77')?'selected':'' ?>	>	77	ª Região</option>
                    <option value="	78	"	<?=($regiao == '78')?'selected':'' ?>	>	78	ª Região</option>
                    <option value="	79	"	<?=($regiao == '79')?'selected':'' ?>	>	79	ª Região</option>
                    <option value="	80	"	<?=($regiao == '80')?'selected':'' ?>	>	80	ª Região</option>
                    <option value="	81	"	<?=($regiao == '81')?'selected':'' ?>	>	81	ª Região</option>
                    <option value="	82	"	<?=($regiao == '82')?'selected':'' ?>	>	82	ª Região</option>
                    <option value="	83	"	<?=($regiao == '83')?'selected':'' ?>	>	83	ª Região</option>
                    <option value="	84	"	<?=($regiao == '84')?'selected':'' ?>	>	84	ª Região</option>
                    <option value="	85	"	<?=($regiao == '85')?'selected':'' ?>	>	85	ª Região</option>
                    <option value="	86	"	<?=($regiao == '86')?'selected':'' ?>	>	86	ª Região</option>
                    <option value="	87	"	<?=($regiao == '87')?'selected':'' ?>	>	87	ª Região</option>
                    <option value="	88	"	<?=($regiao == '88')?'selected':'' ?>	>	88	ª Região</option>
                    <option value="	89	"	<?=($regiao == '89')?'selected':'' ?>	>	89	ª Região</option>
                    <option value="	90	"	<?=($regiao == '90')?'selected':'' ?>	>	90	ª Região</option>
                    <option value="	91	"	<?=($regiao == '91')?'selected':'' ?>	>	91	ª Região</option>
                    <option value="	92	"	<?=($regiao == '92')?'selected':'' ?>	>	92	ª Região</option>
                    <option value="	93	"	<?=($regiao == '93')?'selected':'' ?>	>	93	ª Região</option>
                    <option value="	94	"	<?=($regiao == '94')?'selected':'' ?>	>	94	ª Região</option>
                    <option value="	95	"	<?=($regiao == '95')?'selected':'' ?>	>	95	ª Região</option>
                    <option value="	96	"	<?=($regiao == '96')?'selected':'' ?>	>	96	ª Região</option>
                    <option value="	97	"	<?=($regiao == '97')?'selected':'' ?>	>	97	ª Região</option>
                    <option value="	98	"	<?=($regiao == '98')?'selected':'' ?>	>	98	ª Região</option>
                    <option value="	99	"	<?=($regiao == '99')?'selected':'' ?>	>	99	ª Região</option>
                    <option value="	100	"	<?=($regiao == '100')?'selected':'' ?>	>	100	ª Região</option>
                    <option value="	101	"	<?=($regiao == '101')?'selected':'' ?>	>	101	ª Região</option>
                    <option value="	102	"	<?=($regiao == '102')?'selected':'' ?>	>	102	ª Região</option>
                    <option value="	103	"	<?=($regiao == '103')?'selected':'' ?>	>	103	ª Região</option>
                    <option value="	104	"	<?=($regiao == '104')?'selected':'' ?>	>	104	ª Região</option>
                    <option value="	105	"	<?=($regiao == '105')?'selected':'' ?>	>	105	ª Região</option>
                    <option value="	106	"	<?=($regiao == '106')?'selected':'' ?>	>	106	ª Região</option>
                    <option value="	107	"	<?=($regiao == '107')?'selected':'' ?>	>	107	ª Região</option>
                    <option value="	108	"	<?=($regiao == '108')?'selected':'' ?>	>	108	ª Região</option>
                    <option value="	109	"	<?=($regiao == '109')?'selected':'' ?>	>	109	ª Região</option>
                    <option value="	110	"	<?=($regiao == '110')?'selected':'' ?>	>	110	ª Região</option>
                    <option value="	111	"	<?=($regiao == '111')?'selected':'' ?>	>	111	ª Região</option>
                    <option value="	112	"	<?=($regiao == '112')?'selected':'' ?>	>	112	ª Região</option>
                    <option value="	113	"	<?=($regiao == '113')?'selected':'' ?>	>	113	ª Região</option>
                    <option value="	114	"	<?=($regiao == '114')?'selected':'' ?>	>	114	ª Região</option>
                    <option value="	115	"	<?=($regiao == '115')?'selected':'' ?>	>	115	ª Região</option>
                    <option value="	116	"	<?=($regiao == '116')?'selected':'' ?>	>	116	ª Região</option>
                    <option value="	117	"	<?=($regiao == '117')?'selected':'' ?>	>	117	ª Região</option>
                    <option value="	118	"	<?=($regiao == '118')?'selected':'' ?>	>	118	ª Região</option>
                    <option value="	119	"	<?=($regiao == '119')?'selected':'' ?>	>	119	ª Região</option>
                    <option value="	120	"	<?=($regiao == '120')?'selected':'' ?>	>	120	ª Região</option>
                    <option value="	121	"	<?=($regiao == '121')?'selected':'' ?>	>	121	ª Região</option>
                    <option value="	122	"	<?=($regiao == '122')?'selected':'' ?>	>	122	ª Região</option>
                    <option value="	123	"	<?=($regiao == '123')?'selected':'' ?>	>	123	ª Região</option>
                    <option value="	124	"	<?=($regiao == '124')?'selected':'' ?>	>	124	ª Região</option>
                    <option value="	125	"	<?=($regiao == '125')?'selected':'' ?>	>	125	ª Região</option>
                    <option value="	126	"	<?=($regiao == '126')?'selected':'' ?>	>	126	ª Região</option>
                    <option value="	127	"	<?=($regiao == '127')?'selected':'' ?>	>	127	ª Região</option>
                    <option value="	128	"	<?=($regiao == '128')?'selected':'' ?>	>	128	ª Região</option>
                    <option value="	129	"	<?=($regiao == '129')?'selected':'' ?>	>	129	ª Região</option>
                    <option value="	130	"	<?=($regiao == '130')?'selected':'' ?>	>	130	ª Região</option>
                    <option value="	131	"	<?=($regiao == '131')?'selected':'' ?>	>	131	ª Região</option>
                    <option value="	132	"	<?=($regiao == '132')?'selected':'' ?>	>	132	ª Região</option>
                    <option value="	133	"	<?=($regiao == '133')?'selected':'' ?>	>	133	ª Região</option>
                    <option value="	134	"	<?=($regiao == '134')?'selected':'' ?>	>	134	ª Região</option>
                    <option value="	135	"	<?=($regiao == '135')?'selected':'' ?>	>	135	ª Região</option>
                    <option value="	136	"	<?=($regiao == '136')?'selected':'' ?>	>	136	ª Região</option>
                    <option value="	137	"	<?=($regiao == '137')?'selected':'' ?>	>	137	ª Região</option>
                    <option value="	138	"	<?=($regiao == '138')?'selected':'' ?>	>	138	ª Região</option>
                    <option value="	139	"	<?=($regiao == '139')?'selected':'' ?>	>	139	ª Região</option>
                    <option value="	140	"	<?=($regiao == '140')?'selected':'' ?>	>	140	ª Região</option>
                    <option value="	141	"	<?=($regiao == '141')?'selected':'' ?>	>	141	ª Região</option>
                    <option value="	142	"	<?=($regiao == '142')?'selected':'' ?>	>	142	ª Região</option>
                    <option value="	143	"	<?=($regiao == '143')?'selected':'' ?>	>	143	ª Região</option>
                    <option value="	144	"	<?=($regiao == '144')?'selected':'' ?>	>	144	ª Região</option>
                    <option value="	145	"	<?=($regiao == '145')?'selected':'' ?>	>	145	ª Região</option>
                    <option value="	146	"	<?=($regiao == '146')?'selected':'' ?>	>	146	ª Região</option>
                    <option value="	147	"	<?=($regiao == '147')?'selected':'' ?>	>	147	ª Região</option>
                    <option value="	148	"	<?=($regiao == '148')?'selected':'' ?>	>	148	ª Região</option>
                    <option value="	149	"	<?=($regiao == '149')?'selected':'' ?>	>	149	ª Região</option>
                    <option value="	150	"	<?=($regiao == '150')?'selected':'' ?>	>	150	ª Região</option>
                    <option value="	151	"	<?=($regiao == '151')?'selected':'' ?>	>	151	ª Região</option>
                    <option value="	152	"	<?=($regiao == '152')?'selected':'' ?>	>	152	ª Região</option>
                    <option value="	153	"	<?=($regiao == '153')?'selected':'' ?>	>	153	ª Região</option>
                    <option value="	154	"	<?=($regiao == '154')?'selected':'' ?>	>	154	ª Região</option>
                    <option value="	155	"	<?=($regiao == '155')?'selected':'' ?>	>	155	ª Região</option>
                    <option value="	156	"	<?=($regiao == '156')?'selected':'' ?>	>	156	ª Região</option>
                    <option value="	157	"	<?=($regiao == '157')?'selected':'' ?>	>	157	ª Região</option>
                    <option value="	158	"	<?=($regiao == '158')?'selected':'' ?>	>	158	ª Região</option>
                    <option value="	159	"	<?=($regiao == '159')?'selected':'' ?>	>	159	ª Região</option>
                    <option value="	160	"	<?=($regiao == '160')?'selected':'' ?>	>	160	ª Região</option>
                    <option value="	161	"	<?=($regiao == '161')?'selected':'' ?>	>	161	ª Região</option>
                    <option value="	162	"	<?=($regiao == '162')?'selected':'' ?>	>	162	ª Região</option>
                    <option value="	163	"	<?=($regiao == '163')?'selected':'' ?>	>	163	ª Região</option>
                    <option value="	164	"	<?=($regiao == '164')?'selected':'' ?>	>	164	ª Região</option>
                    <option value="	165	"	<?=($regiao == '165')?'selected':'' ?>	>	165	ª Região</option>
                    <option value="	166	"	<?=($regiao == '166')?'selected':'' ?>	>	166	ª Região</option>
                    <option value="	167	"	<?=($regiao == '167')?'selected':'' ?>	>	167	ª Região</option>
                    <option value="	168	"	<?=($regiao == '168')?'selected':'' ?>	>	168	ª Região</option>
                    <option value="	169	"	<?=($regiao == '169')?'selected':'' ?>	>	169	ª Região</option>
                    <option value="	170	"	<?=($regiao == '170')?'selected':'' ?>	>	170	ª Região</option>
                    <option value="	171	"	<?=($regiao == '171')?'selected':'' ?>	>	171	ª Região</option>
                    <option value="	172	"	<?=($regiao == '172')?'selected':'' ?>	>	172	ª Região</option>
                    <option value="	173	"	<?=($regiao == '173')?'selected':'' ?>	>	173	ª Região</option>
                    <option value="	174	"	<?=($regiao == '174')?'selected':'' ?>	>	174	ª Região</option>
                    <option value="	175	"	<?=($regiao == '175')?'selected':'' ?>	>	175	ª Região</option>
                    <option value="	176	"	<?=($regiao == '176')?'selected':'' ?>	>	176	ª Região</option>
                    <option value="	177	"	<?=($regiao == '177')?'selected':'' ?>	>	177	ª Região</option>
                    <option value="	178	"	<?=($regiao == '178')?'selected':'' ?>	>	178	ª Região</option>
                    <option value="	179	"	<?=($regiao == '179')?'selected':'' ?>	>	179	ª Região</option>
                    <option value="	180	"	<?=($regiao == '180')?'selected':'' ?>	>	180	ª Região</option>
                    <option value="	181	"	<?=($regiao == '181')?'selected':'' ?>	>	181	ª Região</option>
                    <option value="	182	"	<?=($regiao == '182')?'selected':'' ?>	>	182	ª Região</option>
                    <option value="	183	"	<?=($regiao == '183')?'selected':'' ?>	>	183	ª Região</option>
                    <option value="	184	"	<?=($regiao == '184')?'selected':'' ?>	>	184	ª Região</option>
                    <option value="	185	"	<?=($regiao == '185')?'selected':'' ?>	>	185	ª Região</option>
                    <option value="	186	"	<?=($regiao == '186')?'selected':'' ?>	>	186	ª Região</option>
                    <option value="	187	"	<?=($regiao == '187')?'selected':'' ?>	>	187	ª Região</option>
                    <option value="	188	"	<?=($regiao == '188')?'selected':'' ?>	>	188	ª Região</option>
                    <option value="	189	"	<?=($regiao == '189')?'selected':'' ?>	>	189	ª Região</option>
                    <option value="	190	"	<?=($regiao == '190')?'selected':'' ?>	>	190	ª Região</option>
                    <option value="	191	"	<?=($regiao == '191')?'selected':'' ?>	>	191	ª Região</option>
                    <option value="	192	"	<?=($regiao == '192')?'selected':'' ?>	>	192	ª Região</option>
                    <option value="	193	"	<?=($regiao == '193')?'selected':'' ?>	>	193	ª Região</option>
                    <option value="	194	"	<?=($regiao == '194')?'selected':'' ?>	>	194	ª Região</option>
                    <option value="	195	"	<?=($regiao == '195')?'selected':'' ?>	>	195	ª Região</option>
                    <option value="	196	"	<?=($regiao == '196')?'selected':'' ?>	>	196	ª Região</option>
                    <option value="	197	"	<?=($regiao == '197')?'selected':'' ?>	>	197	ª Região</option>
                    <option value="	198	"	<?=($regiao == '198')?'selected':'' ?>	>	198	ª Região</option>
                    <option value="	199	"	<?=($regiao == '199')?'selected':'' ?>	>	199	ª Região</option>
                    <option value="	200	"	<?=($regiao == '200')?'selected':'' ?>	>	200	ª Região</option>
                    <option value="	201	"	<?=($regiao == '201')?'selected':'' ?>	>	201	ª Região</option>
                    <option value="	202	"	<?=($regiao == '202')?'selected':'' ?>	>	202	ª Região</option>
                    <option value="	203	"	<?=($regiao == '203')?'selected':'' ?>	>	203	ª Região</option>
                    <option value="	204	"	<?=($regiao == '204')?'selected':'' ?>	>	204	ª Região</option>
                    <option value="	205	"	<?=($regiao == '205')?'selected':'' ?>	>	205	ª Região</option>
                    <option value="	206	"	<?=($regiao == '206')?'selected':'' ?>	>	206	ª Região</option>
                    <option value="	207	"	<?=($regiao == '207')?'selected':'' ?>	>	207	ª Região</option>
                    <option value="	208	"	<?=($regiao == '208')?'selected':'' ?>	>	208	ª Região</option>
                    <option value="	209	"	<?=($regiao == '209')?'selected':'' ?>	>	209	ª Região</option>
                    <option value="	210	"	<?=($regiao == '210')?'selected':'' ?>	>	210	ª Região</option>
                    <option value="	211	"	<?=($regiao == '211')?'selected':'' ?>	>	211	ª Região</option>
                    <option value="	212	"	<?=($regiao == '212')?'selected':'' ?>	>	212	ª Região</option>
                    <option value="	213	"	<?=($regiao == '213')?'selected':'' ?>	>	213	ª Região</option>
                    <option value="	214	"	<?=($regiao == '214')?'selected':'' ?>	>	214	ª Região</option>
                    <option value="	215	"	<?=($regiao == '215')?'selected':'' ?>	>	215	ª Região</option>
                    <option value="	216	"	<?=($regiao == '216')?'selected':'' ?>	>	216	ª Região</option>
                    <option value="	217	"	<?=($regiao == '217')?'selected':'' ?>	>	217	ª Região</option>
                    <option value="	218	"	<?=($regiao == '218')?'selected':'' ?>	>	218	ª Região</option>
                    <option value="	219	"	<?=($regiao == '219')?'selected':'' ?>	>	219	ª Região</option>
                    <option value="	220	"	<?=($regiao == '220')?'selected':'' ?>	>	220	ª Região</option>
                    <option value="	221	"	<?=($regiao == '221')?'selected':'' ?>	>	221	ª Região</option>
                    <option value="	222	"	<?=($regiao == '222')?'selected':'' ?>	>	222	ª Região</option>
                    <option value="	223	"	<?=($regiao == '223')?'selected':'' ?>	>	223	ª Região</option>
                    <option value="	224	"	<?=($regiao == '224')?'selected':'' ?>	>	224	ª Região</option>
                    <option value="	225	"	<?=($regiao == '225')?'selected':'' ?>	>	225	ª Região</option>
                    <option value="	226	"	<?=($regiao == '226')?'selected':'' ?>	>	226	ª Região</option>
                    <option value="	227	"	<?=($regiao == '227')?'selected':'' ?>	>	227	ª Região</option>
                    <option value="	228	"	<?=($regiao == '228')?'selected':'' ?>	>	228	ª Região</option>
                    <option value="	229	"	<?=($regiao == '229')?'selected':'' ?>	>	229	ª Região</option>
                    <option value="	230	"	<?=($regiao == '230')?'selected':'' ?>	>	230	ª Região</option>
                    <option value="	231	"	<?=($regiao == '231')?'selected':'' ?>	>	231	ª Região</option>
                    <option value="	232	"	<?=($regiao == '232')?'selected':'' ?>	>	232	ª Região</option>
                    <option value="	233	"	<?=($regiao == '233')?'selected':'' ?>	>	233	ª Região</option>
                    <option value="	234	"	<?=($regiao == '234')?'selected':'' ?>	>	234	ª Região</option>
                    <option value="	235	"	<?=($regiao == '235')?'selected':'' ?>	>	235	ª Região</option>
                    <option value="	236	"	<?=($regiao == '236')?'selected':'' ?>	>	236	ª Região</option>
                    <option value="	237	"	<?=($regiao == '237')?'selected':'' ?>	>	237	ª Região</option>
                    <option value="	238	"	<?=($regiao == '238')?'selected':'' ?>	>	238	ª Região</option>
                    <option value="	239	"	<?=($regiao == '239')?'selected':'' ?>	>	239	ª Região</option>
                    <option value="	240	"	<?=($regiao == '240')?'selected':'' ?>	>	240	ª Região</option>
                    <option value="	241	"	<?=($regiao == '241')?'selected':'' ?>	>	241	ª Região</option>
                    <option value="	242	"	<?=($regiao == '242')?'selected':'' ?>	>	242	ª Região</option>
                    <option value="	243	"	<?=($regiao == '243')?'selected':'' ?>	>	243	ª Região</option>
                    <option value="	244	"	<?=($regiao == '244')?'selected':'' ?>	>	244	ª Região</option>
                    <option value="	245	"	<?=($regiao == '245')?'selected':'' ?>	>	245	ª Região</option>
                    <option value="	246	"	<?=($regiao == '246')?'selected':'' ?>	>	246	ª Região</option>
                    <option value="	247	"	<?=($regiao == '247')?'selected':'' ?>	>	247	ª Região</option>
                    <option value="	248	"	<?=($regiao == '248')?'selected':'' ?>	>	248	ª Região</option>
                    <option value="	249	"	<?=($regiao == '249')?'selected':'' ?>	>	249	ª Região</option>
                    <option value="	250	"	<?=($regiao == '250')?'selected':'' ?>	>	250	ª Região</option>
                    <option value="	251	"	<?=($regiao == '251')?'selected':'' ?>	>	251	ª Região</option>
                    <option value="	252	"	<?=($regiao == '252')?'selected':'' ?>	>	252	ª Região</option>
                    <option value="	253	"	<?=($regiao == '253')?'selected':'' ?>	>	253	ª Região</option>
                    <option value="	254	"	<?=($regiao == '254')?'selected':'' ?>	>	254	ª Região</option>
                    <option value="	255	"	<?=($regiao == '255')?'selected':'' ?>	>	255	ª Região</option>
                    <option value="	256	"	<?=($regiao == '256')?'selected':'' ?>	>	256	ª Região</option>
                    <option value="	257	"	<?=($regiao == '257')?'selected':'' ?>	>	257	ª Região</option>
                    <option value="	258	"	<?=($regiao == '258')?'selected':'' ?>	>	258	ª Região</option>
                    <option value="	259	"	<?=($regiao == '259')?'selected':'' ?>	>	259	ª Região</option>
                    <option value="	260	"	<?=($regiao == '260')?'selected':'' ?>	>	260	ª Região</option>
                    <option value="	261	"	<?=($regiao == '261')?'selected':'' ?>	>	261	ª Região</option>
                    <option value="	262	"	<?=($regiao == '262')?'selected':'' ?>	>	262	ª Região</option>
                    <option value="	263	"	<?=($regiao == '263')?'selected':'' ?>	>	263	ª Região</option>
                    <option value="	264	"	<?=($regiao == '264')?'selected':'' ?>	>	264	ª Região</option>
                    <option value="	265	"	<?=($regiao == '265')?'selected':'' ?>	>	265	ª Região</option>
                    <option value="	266	"	<?=($regiao == '266')?'selected':'' ?>	>	266	ª Região</option>
                    <option value="	267	"	<?=($regiao == '267')?'selected':'' ?>	>	267	ª Região</option>
                    <option value="	268	"	<?=($regiao == '268')?'selected':'' ?>	>	268	ª Região</option>
                    <option value="	269	"	<?=($regiao == '269')?'selected':'' ?>	>	269	ª Região</option>
                    <option value="	270	"	<?=($regiao == '270')?'selected':'' ?>	>	270	ª Região</option>
                    <option value="	271	"	<?=($regiao == '271')?'selected':'' ?>	>	271	ª Região</option>
                    <option value="	272	"	<?=($regiao == '272')?'selected':'' ?>	>	272	ª Região</option>
                    <option value="	273	"	<?=($regiao == '273')?'selected':'' ?>	>	273	ª Região</option>
                    <option value="	274	"	<?=($regiao == '274')?'selected':'' ?>	>	274	ª Região</option>
                    <option value="	275	"	<?=($regiao == '275')?'selected':'' ?>	>	275	ª Região</option>
                    <option value="	276	"	<?=($regiao == '276')?'selected':'' ?>	>	276	ª Região</option>
                    <option value="	277	"	<?=($regiao == '277')?'selected':'' ?>	>	277	ª Região</option>
                    <option value="	278	"	<?=($regiao == '278')?'selected':'' ?>	>	278	ª Região</option>
                    <option value="	279	"	<?=($regiao == '279')?'selected':'' ?>	>	279	ª Região</option>
                    <option value="	280	"	<?=($regiao == '280')?'selected':'' ?>	>	280	ª Região</option>
                    <option value="	281	"	<?=($regiao == '281')?'selected':'' ?>	>	281	ª Região</option>
                    <option value="	282	"	<?=($regiao == '282')?'selected':'' ?>	>	282	ª Região</option>
                    <option value="	283	"	<?=($regiao == '283')?'selected':'' ?>	>	283	ª Região</option>
                    <option value="	284	"	<?=($regiao == '284')?'selected':'' ?>	>	284	ª Região</option>
                    <option value="	285	"	<?=($regiao == '285')?'selected':'' ?>	>	285	ª Região</option>
                    <option value="	286	"	<?=($regiao == '286')?'selected':'' ?>	>	286	ª Região</option>
                    <option value="	287	"	<?=($regiao == '287')?'selected':'' ?>	>	287	ª Região</option>
                    <option value="	288	"	<?=($regiao == '288')?'selected':'' ?>	>	288	ª Região</option>
                    <option value="	289	"	<?=($regiao == '289')?'selected':'' ?>	>	289	ª Região</option>
                    <option value="	290	"	<?=($regiao == '290')?'selected':'' ?>	>	290	ª Região</option>
                    <option value="	291	"	<?=($regiao == '291')?'selected':'' ?>	>	291	ª Região</option>
                    <option value="	292	"	<?=($regiao == '292')?'selected':'' ?>	>	292	ª Região</option>
                    <option value="	293	"	<?=($regiao == '293')?'selected':'' ?>	>	293	ª Região</option>
                    <option value="	294	"	<?=($regiao == '294')?'selected':'' ?>	>	294	ª Região</option>
                    <option value="	295	"	<?=($regiao == '295')?'selected':'' ?>	>	295	ª Região</option>
                    <option value="	296	"	<?=($regiao == '296')?'selected':'' ?>	>	296	ª Região</option>
                    <option value="	297	"	<?=($regiao == '297')?'selected':'' ?>	>	297	ª Região</option>
                    <option value="	298	"	<?=($regiao == '298')?'selected':'' ?>	>	298	ª Região</option>
                    <option value="	299	"	<?=($regiao == '299')?'selected':'' ?>	>	299	ª Região</option>
                    <option value="	300	"	<?=($regiao == '300')?'selected':'' ?>	>	300	ª Região</option>
                    <option value="	301	"	<?=($regiao == '301')?'selected':'' ?>	>	301	ª Região</option>
                    <option value="	302	"	<?=($regiao == '302')?'selected':'' ?>	>	302	ª Região</option>
                    <option value="	303	"	<?=($regiao == '303')?'selected':'' ?>	>	303	ª Região</option>
                    <option value="	304	"	<?=($regiao == '304')?'selected':'' ?>	>	304	ª Região</option>
                    <option value="	305	"	<?=($regiao == '305')?'selected':'' ?>	>	305	ª Região</option>
                    <option value="	306	"	<?=($regiao == '306')?'selected':'' ?>	>	306	ª Região</option>
                    <option value="	307	"	<?=($regiao == '307')?'selected':'' ?>	>	307	ª Região</option>
                    <option value="	308	"	<?=($regiao == '308')?'selected':'' ?>	>	308	ª Região</option>
                    <option value="	309	"	<?=($regiao == '309')?'selected':'' ?>	>	309	ª Região</option>
                    <option value="	310	"	<?=($regiao == '310')?'selected':'' ?>	>	310	ª Região</option>
                    <option value="	311	"	<?=($regiao == '311')?'selected':'' ?>	>	311	ª Região</option>
                    <option value="	312	"	<?=($regiao == '312')?'selected':'' ?>	>	312	ª Região</option>
                    <option value="	313	"	<?=($regiao == '313')?'selected':'' ?>	>	313	ª Região</option>
                    <option value="	314	"	<?=($regiao == '314')?'selected':'' ?>	>	314	ª Região</option>
                    <option value="	315	"	<?=($regiao == '315')?'selected':'' ?>	>	315	ª Região</option>
                    <option value="	316	"	<?=($regiao == '316')?'selected':'' ?>	>	316	ª Região</option>
                    <option value="	317	"	<?=($regiao == '317')?'selected':'' ?>	>	317	ª Região</option>
                    <option value="	318	"	<?=($regiao == '318')?'selected':'' ?>	>	318	ª Região</option>
                    <option value="	319	"	<?=($regiao == '319')?'selected':'' ?>	>	319	ª Região</option>
                    <option value="	320	"	<?=($regiao == '320')?'selected':'' ?>	>	320	ª Região</option>
                    <option value="	321	"	<?=($regiao == '321')?'selected':'' ?>	>	321	ª Região</option>
                    <option value="	322	"	<?=($regiao == '322')?'selected':'' ?>	>	322	ª Região</option>
                    <option value="	323	"	<?=($regiao == '323')?'selected':'' ?>	>	323	ª Região</option>
                    <option value="	324	"	<?=($regiao == '324')?'selected':'' ?>	>	324	ª Região</option>
                    <option value="	325	"	<?=($regiao == '325')?'selected':'' ?>	>	325	ª Região</option>
                    <option value="	326	"	<?=($regiao == '326')?'selected':'' ?>	>	326	ª Região</option>
                    <option value="	327	"	<?=($regiao == '327')?'selected':'' ?>	>	327	ª Região</option>
                    <option value="	328	"	<?=($regiao == '328')?'selected':'' ?>	>	328	ª Região</option>
                    <option value="	329	"	<?=($regiao == '329')?'selected':'' ?>	>	329	ª Região</option>
                    <option value="	330	"	<?=($regiao == '330')?'selected':'' ?>	>	330	ª Região</option>
                    <option value="	331	"	<?=($regiao == '331')?'selected':'' ?>	>	331	ª Região</option>
                    <option value="	332	"	<?=($regiao == '332')?'selected':'' ?>	>	332	ª Região</option>
                    <option value="	333	"	<?=($regiao == '333')?'selected':'' ?>	>	333	ª Região</option>
                    <option value="	334	"	<?=($regiao == '334')?'selected':'' ?>	>	334	ª Região</option>
                    <option value="	335	"	<?=($regiao == '335')?'selected':'' ?>	>	335	ª Região</option>
                    <option value="	336	"	<?=($regiao == '336')?'selected':'' ?>	>	336	ª Região</option>
                    <option value="	337	"	<?=($regiao == '337')?'selected':'' ?>	>	337	ª Região</option>
                    <option value="	338	"	<?=($regiao == '338')?'selected':'' ?>	>	338	ª Região</option>
                    <option value="	339	"	<?=($regiao == '339')?'selected':'' ?>	>	339	ª Região</option>
                    <option value="	340	"	<?=($regiao == '340')?'selected':'' ?>	>	340	ª Região</option>
                    <option value="	341	"	<?=($regiao == '341')?'selected':'' ?>	>	341	ª Região</option>
                    <option value="	342	"	<?=($regiao == '342')?'selected':'' ?>	>	342	ª Região</option>
                    <option value="	343	"	<?=($regiao == '343')?'selected':'' ?>	>	343	ª Região</option>
                    <option value="	344	"	<?=($regiao == '344')?'selected':'' ?>	>	344	ª Região</option>
                    <option value="	345	"	<?=($regiao == '345')?'selected':'' ?>	>	345	ª Região</option>
                    <option value="	346	"	<?=($regiao == '346')?'selected':'' ?>	>	346	ª Região</option>
                    <option value="	347	"	<?=($regiao == '347')?'selected':'' ?>	>	347	ª Região</option>
                    <option value="	348	"	<?=($regiao == '348')?'selected':'' ?>	>	348	ª Região</option>
                    <option value="	349	"	<?=($regiao == '349')?'selected':'' ?>	>	349	ª Região</option>
                    <option value="	350	"	<?=($regiao == '350')?'selected':'' ?>	>	350	ª Região</option>
                    <option value="	351	"	<?=($regiao == '351')?'selected':'' ?>	>	351	ª Região</option>
                    <option value="	352	"	<?=($regiao == '352')?'selected':'' ?>	>	352	ª Região</option>
                    <option value="	353	"	<?=($regiao == '353')?'selected':'' ?>	>	353	ª Região</option>
                    <option value="	354	"	<?=($regiao == '354')?'selected':'' ?>	>	354	ª Região</option>
                    <option value="	355	"	<?=($regiao == '355')?'selected':'' ?>	>	355	ª Região</option>
                    <option value="	356	"	<?=($regiao == '356')?'selected':'' ?>	>	356	ª Região</option>
                    <option value="	357	"	<?=($regiao == '357')?'selected':'' ?>	>	357	ª Região</option>
                    <option value="	358	"	<?=($regiao == '358')?'selected':'' ?>	>	358	ª Região</option>
                    <option value="	359	"	<?=($regiao == '359')?'selected':'' ?>	>	359	ª Região</option>
                    <option value="	360	"	<?=($regiao == '360')?'selected':'' ?>	>	360	ª Região</option>
                    <option value="	361	"	<?=($regiao == '361')?'selected':'' ?>	>	361	ª Região</option>
                    <option value="	362	"	<?=($regiao == '362')?'selected':'' ?>	>	362	ª Região</option>
                    <option value="	363	"	<?=($regiao == '363')?'selected':'' ?>	>	363	ª Região</option>
                    <option value="	364	"	<?=($regiao == '364')?'selected':'' ?>	>	364	ª Região</option>
                    <option value="	365	"	<?=($regiao == '365')?'selected':'' ?>	>	365	ª Região</option>
                    <option value="	366	"	<?=($regiao == '366')?'selected':'' ?>	>	366	ª Região</option>
                    <option value="	367	"	<?=($regiao == '367')?'selected':'' ?>	>	367	ª Região</option>
                    <option value="	368	"	<?=($regiao == '368')?'selected':'' ?>	>	368	ª Região</option>
                    <option value="	369	"	<?=($regiao == '369')?'selected':'' ?>	>	369	ª Região</option>
                    <option value="	370	"	<?=($regiao == '370')?'selected':'' ?>	>	370	ª Região</option>
                    <option value="	371	"	<?=($regiao == '371')?'selected':'' ?>	>	371	ª Região</option>
                    <option value="	372	"	<?=($regiao == '372')?'selected':'' ?>	>	372	ª Região</option>
                    <option value="	373	"	<?=($regiao == '373')?'selected':'' ?>	>	373	ª Região</option>
                    <option value="	374	"	<?=($regiao == '374')?'selected':'' ?>	>	374	ª Região</option>
                    <option value="	375	"	<?=($regiao == '375')?'selected':'' ?>	>	375	ª Região</option>
                    <option value="	376	"	<?=($regiao == '376')?'selected':'' ?>	>	376	ª Região</option>
                    <option value="	377	"	<?=($regiao == '377')?'selected':'' ?>	>	377	ª Região</option>
                    <option value="	378	"	<?=($regiao == '378')?'selected':'' ?>	>	378	ª Região</option>
                    <option value="	379	"	<?=($regiao == '379')?'selected':'' ?>	>	379	ª Região</option>
                    <option value="	380	"	<?=($regiao == '380')?'selected':'' ?>	>	380	ª Região</option>
                    <option value="	381	"	<?=($regiao == '381')?'selected':'' ?>	>	381	ª Região</option>
                    <option value="	382	"	<?=($regiao == '382')?'selected':'' ?>	>	382	ª Região</option>
                    <option value="	383	"	<?=($regiao == '383')?'selected':'' ?>	>	383	ª Região</option>
                    <option value="	384	"	<?=($regiao == '384')?'selected':'' ?>	>	384	ª Região</option>
                    <option value="	385	"	<?=($regiao == '385')?'selected':'' ?>	>	385	ª Região</option>
                    <option value="	386	"	<?=($regiao == '386')?'selected':'' ?>	>	386	ª Região</option>
                    <option value="	387	"	<?=($regiao == '387')?'selected':'' ?>	>	387	ª Região</option>
                    <option value="	388	"	<?=($regiao == '388')?'selected':'' ?>	>	388	ª Região</option>
                    <option value="	389	"	<?=($regiao == '389')?'selected':'' ?>	>	389	ª Região</option>
                    <option value="	390	"	<?=($regiao == '390')?'selected':'' ?>	>	390	ª Região</option>
                    <option value="	391	"	<?=($regiao == '391')?'selected':'' ?>	>	391	ª Região</option>
                    <option value="	392	"	<?=($regiao == '392')?'selected':'' ?>	>	392	ª Região</option>
                    <option value="	393	"	<?=($regiao == '393')?'selected':'' ?>	>	393	ª Região</option>
                    <option value="	394	"	<?=($regiao == '394')?'selected':'' ?>	>	394	ª Região</option>
                    <option value="	395	"	<?=($regiao == '395')?'selected':'' ?>	>	395	ª Região</option>
                    <option value="	396	"	<?=($regiao == '396')?'selected':'' ?>	>	396	ª Região</option>
                    <option value="	397	"	<?=($regiao == '397')?'selected':'' ?>	>	397	ª Região</option>
                    <option value="	398	"	<?=($regiao == '398')?'selected':'' ?>	>	398	ª Região</option>
                    <option value="	399	"	<?=($regiao == '399')?'selected':'' ?>	>	399	ª Região</option>
                    <option value="	400	"	<?=($regiao == '400')?'selected':'' ?>	>	400	ª Região</option>
                    <option value="	401	"	<?=($regiao == '401')?'selected':'' ?>	>	401	ª Região</option>
                    <option value="	402	"	<?=($regiao == '402')?'selected':'' ?>	>	402	ª Região</option>
                    <option value="	403	"	<?=($regiao == '403')?'selected':'' ?>	>	403	ª Região</option>
                    <option value="	404	"	<?=($regiao == '404')?'selected':'' ?>	>	404	ª Região</option>
                    <option value="	405	"	<?=($regiao == '405')?'selected':'' ?>	>	405	ª Região</option>
                    <option value="	406	"	<?=($regiao == '406')?'selected':'' ?>	>	406	ª Região</option>
                    <option value="	407	"	<?=($regiao == '407')?'selected':'' ?>	>	407	ª Região</option>
                    <option value="	408	"	<?=($regiao == '408')?'selected':'' ?>	>	408	ª Região</option>
                    <option value="	409	"	<?=($regiao == '409')?'selected':'' ?>	>	409	ª Região</option>
                    <option value="	410	"	<?=($regiao == '410')?'selected':'' ?>	>	410	ª Região</option>
                    <option value="	411	"	<?=($regiao == '411')?'selected':'' ?>	>	411	ª Região</option>
                    <option value="	412	"	<?=($regiao == '412')?'selected':'' ?>	>	412	ª Região</option>
                    <option value="	413	"	<?=($regiao == '413')?'selected':'' ?>	>	413	ª Região</option>
                    <option value="	414	"	<?=($regiao == '414')?'selected':'' ?>	>	414	ª Região</option>
                    <option value="	415	"	<?=($regiao == '415')?'selected':'' ?>	>	415	ª Região</option>
                    <option value="	416	"	<?=($regiao == '416')?'selected':'' ?>	>	416	ª Região</option>
                    <option value="	417	"	<?=($regiao == '417')?'selected':'' ?>	>	417	ª Região</option>
                    <option value="	418	"	<?=($regiao == '418')?'selected':'' ?>	>	418	ª Região</option>
                    <option value="	419	"	<?=($regiao == '419')?'selected':'' ?>	>	419	ª Região</option>
                    <option value="	420	"	<?=($regiao == '420')?'selected':'' ?>	>	420	ª Região</option>
                    <option value="	421	"	<?=($regiao == '421')?'selected':'' ?>	>	421	ª Região</option>
                    <option value="	422	"	<?=($regiao == '422')?'selected':'' ?>	>	422	ª Região</option>
                    <option value="	423	"	<?=($regiao == '423')?'selected':'' ?>	>	423	ª Região</option>
                    <option value="	424	"	<?=($regiao == '424')?'selected':'' ?>	>	424	ª Região</option>
                    <option value="	425	"	<?=($regiao == '425')?'selected':'' ?>	>	425	ª Região</option>
                    <option value="	426	"	<?=($regiao == '526')?'selected':'' ?>	>	426	ª Região</option>
                    <option value="	427	"	<?=($regiao == '427')?'selected':'' ?>	>	427	ª Região</option>
                    <option value="	428	"	<?=($regiao == '428')?'selected':'' ?>	>	428	ª Região</option>
                    <option value="	429	"	<?=($regiao == '429')?'selected':'' ?>	>	429	ª Região</option>
                    <option value="	430	"	<?=($regiao == '430')?'selected':'' ?>	>	430	ª Região</option>
                    <option value="	431	"	<?=($regiao == '431')?'selected':'' ?>	>	431	ª Região</option>
                    <option value="	432	"	<?=($regiao == '432')?'selected':'' ?>	>	432	ª Região</option>
                    <option value="	433	"	<?=($regiao == '433')?'selected':'' ?>	>	433	ª Região</option>
                    <option value="	434	"	<?=($regiao == '434')?'selected':'' ?>	>	434	ª Região</option>
                    <option value="	435	"	<?=($regiao == '435')?'selected':'' ?>	>	435	ª Região</option>
                    <option value="	436	"	<?=($regiao == '436')?'selected':'' ?>	>	436	ª Região</option>
                    <option value="	437	"	<?=($regiao == '437')?'selected':'' ?>	>	437	ª Região</option>
                    <option value="	438	"	<?=($regiao == '438')?'selected':'' ?>	>	438	ª Região</option>
                    <option value="	439	"	<?=($regiao == '439')?'selected':'' ?>	>	439	ª Região</option>
                    <option value="	440	"	<?=($regiao == '440')?'selected':'' ?>	>	440	ª Região</option>
                    <option value="	441	"	<?=($regiao == '441')?'selected':'' ?>	>	441	ª Região</option>
                    <option value="	442	"	<?=($regiao == '442')?'selected':'' ?>	>	442	ª Região</option>
                    <option value="	443	"	<?=($regiao == '443')?'selected':'' ?>	>	443	ª Região</option>
                    <option value="	444	"	<?=($regiao == '444')?'selected':'' ?>	>	444	ª Região</option>
                    <option value="	445	"	<?=($regiao == '445')?'selected':'' ?>	>	445	ª Região</option>
                    <option value="	446	"	<?=($regiao == '446')?'selected':'' ?>	>	446	ª Região</option>
                    <option value="	447	"	<?=($regiao == '447')?'selected':'' ?>	>	447	ª Região</option>
                    <option value="	448	"	<?=($regiao == '448')?'selected':'' ?>	>	448	ª Região</option>
                    <option value="	449	"	<?=($regiao == '449')?'selected':'' ?>	>	449	ª Região</option>
                    <option value="	450	"	<?=($regiao == '450')?'selected':'' ?>	>	450	ª Região</option>
                    <option value="	451	"	<?=($regiao == '451')?'selected':'' ?>	>	451	ª Região</option>
                    <option value="	452	"	<?=($regiao == '452')?'selected':'' ?>	>	452	ª Região</option>
                    <option value="	453	"	<?=($regiao == '453')?'selected':'' ?>	>	453	ª Região</option>
                    <option value="	454	"	<?=($regiao == '454')?'selected':'' ?>	>	454	ª Região</option>
                    <option value="	455	"	<?=($regiao == '455')?'selected':'' ?>	>	455	ª Região</option>
                    <option value="	456	"	<?=($regiao == '456')?'selected':'' ?>	>	456	ª Região</option>
                    <option value="	457	"	<?=($regiao == '457')?'selected':'' ?>	>	457	ª Região</option>
                    <option value="	458	"	<?=($regiao == '458')?'selected':'' ?>	>	458	ª Região</option>
                    <option value="	459	"	<?=($regiao == '459')?'selected':'' ?>	>	459	ª Região</option>
                    <option value="	460	"	<?=($regiao == '460')?'selected':'' ?>	>	460	ª Região</option>
                    <option value="	461	"	<?=($regiao == '461')?'selected':'' ?>	>	461	ª Região</option>
                    <option value="	462	"	<?=($regiao == '462')?'selected':'' ?>	>	462	ª Região</option>
                    <option value="	463	"	<?=($regiao == '463')?'selected':'' ?>	>	463	ª Região</option>
                    <option value="	464	"	<?=($regiao == '464')?'selected':'' ?>	>	464	ª Região</option>
                    <option value="	465	"	<?=($regiao == '465')?'selected':'' ?>	>	465	ª Região</option>
                    <option value="	466	"	<?=($regiao == '466')?'selected':'' ?>	>	466	ª Região</option>
                    <option value="	467	"	<?=($regiao == '467')?'selected':'' ?>	>	467	ª Região</option>
                    <option value="	468	"	<?=($regiao == '468')?'selected':'' ?>	>	468	ª Região</option>
                    <option value="	469	"	<?=($regiao == '469')?'selected':'' ?>	>	469	ª Região</option>
                    <option value="	470	"	<?=($regiao == '470')?'selected':'' ?>	>	470	ª Região</option>
                    <option value="	471	"	<?=($regiao == '471')?'selected':'' ?>	>	471	ª Região</option>
                    <option value="	472	"	<?=($regiao == '472')?'selected':'' ?>	>	472	ª Região</option>
                    <option value="	473	"	<?=($regiao == '473')?'selected':'' ?>	>	473	ª Região</option>
                    <option value="	474	"	<?=($regiao == '474')?'selected':'' ?>	>	474	ª Região</option>
                    <option value="	475	"	<?=($regiao == '475')?'selected':'' ?>	>	475	ª Região</option>
                    <option value="	476	"	<?=($regiao == '476')?'selected':'' ?>	>	476	ª Região</option>
                    <option value="	477	"	<?=($regiao == '477')?'selected':'' ?>	>	477	ª Região</option>
                    <option value="	478	"	<?=($regiao == '478')?'selected':'' ?>	>	478	ª Região</option>
                    <option value="	479	"	<?=($regiao == '479')?'selected':'' ?>	>	479	ª Região</option>
                    <option value="	480	"	<?=($regiao == '480')?'selected':'' ?>	>	480	ª Região</option>
                    <option value="	481	"	<?=($regiao == '481')?'selected':'' ?>	>	481	ª Região</option>
                    <option value="	482	"	<?=($regiao == '482')?'selected':'' ?>	>	482	ª Região</option>
                    <option value="	483	"	<?=($regiao == '483')?'selected':'' ?>	>	483	ª Região</option>
                    <option value="	484	"	<?=($regiao == '484')?'selected':'' ?>	>	484	ª Região</option>
                    <option value="	485	"	<?=($regiao == '485')?'selected':'' ?>	>	485	ª Região</option>
                    <option value="	486	"	<?=($regiao == '486')?'selected':'' ?>	>	486	ª Região</option>
                    <option value="	487	"	<?=($regiao == '487')?'selected':'' ?>	>	487	ª Região</option>
                    <option value="	488	"	<?=($regiao == '488')?'selected':'' ?>	>	488	ª Região</option>
                    <option value="	489	"	<?=($regiao == '489')?'selected':'' ?>	>	489	ª Região</option>
                    <option value="	490	"	<?=($regiao == '490')?'selected':'' ?>	>	490	ª Região</option>
                    <option value="	491	"	<?=($regiao == '491')?'selected':'' ?>	>	491	ª Região</option>
                    <option value="	492	"	<?=($regiao == '492')?'selected':'' ?>	>	492	ª Região</option>
                    <option value="	493	"	<?=($regiao == '493')?'selected':'' ?>	>	493	ª Região</option>
                    <option value="	494	"	<?=($regiao == '494')?'selected':'' ?>	>	494	ª Região</option>
                    <option value="	495	"	<?=($regiao == '495')?'selected':'' ?>	>	495	ª Região</option>
                    <option value="	496	"	<?=($regiao == '496')?'selected':'' ?>	>	496	ª Região</option>
                    <option value="	497	"	<?=($regiao == '497')?'selected':'' ?>	>	497	ª Região</option>
                    <option value="	498	"	<?=($regiao == '498')?'selected':'' ?>	>	498	ª Região</option>
                    <option value="	499	"	<?=($regiao == '499')?'selected':'' ?>	>	499	ª Região</option>
                    <option value="	500	"	<?=($regiao == '500')?'selected':'' ?>	>	500	ª Região</option>
                    <option value="	501	"	<?=($regiao == '501')?'selected':'' ?>	>	501	ª Região</option>
                    <option value="	502	"	<?=($regiao == '502')?'selected':'' ?>	>	502	ª Região</option>
                    <option value="	503	"	<?=($regiao == '503')?'selected':'' ?>	>	503	ª Região	</option>
                    <option value="	504	"	<?=($regiao == '504')?'selected':'' ?>	>	504	ª Região	</option>
                    <option value="	505	"	<?=($regiao == '505')?'selected':'' ?>	>	505	ª Região	</option>
                    <option value="	506	"	<?=($regiao == '506')?'selected':'' ?>	>	506	ª Região	</option>
                    <option value="	507	"	<?=($regiao == '507')?'selected':'' ?>	>	507	ª Região	</option>
                    <option value="	508	"	<?=($regiao == '508')?'selected':'' ?>	>	508	ª Região	</option>
                    <option value="	509	"	<?=($regiao == '509')?'selected':'' ?>	>	509	ª Região	</option>
                    <option value="	510	"	<?=($regiao == '510')?'selected':'' ?>	>	510	ª Região	</option>
                    <option value="	511	"	<?=($regiao == '511')?'selected':'' ?>	>	511	ª Região	</option>
                    <option value="	512	"	<?=($regiao == '512')?'selected':'' ?>	>	512	ª Região	</option>
                    <option value="	513	"	<?=($regiao == '513')?'selected':'' ?>	>	513	ª Região	</option>
                    <option value="	514	"	<?=($regiao == '514')?'selected':'' ?>	>	514	ª Região	</option>
                    <option value="	515	"	<?=($regiao == '515')?'selected':'' ?>	>	515	ª Região	</option>
                    <option value="	516	"	<?=($regiao == '516')?'selected':'' ?>	>	516	ª Região	</option>
                    <option value="	517	"	<?=($regiao == '517')?'selected':'' ?>	>	517	ª Região	</option>
                    <option value="	518	"	<?=($regiao == '518')?'selected':'' ?>	>	518	ª Região	</option>
                    <option value="	519	"	<?=($regiao == '519')?'selected':'' ?>	>	519	ª Região	</option>
                    <option value="	520	"	<?=($regiao == '520')?'selected':'' ?>	>	520	ª Região	</option>
                    <option value="	521	"	<?=($regiao == '521')?'selected':'' ?>	>	521	ª Região	</option>
                    <option value="	522	"	<?=($regiao == '522')?'selected':'' ?>	>	522	ª Região	</option>
                    <option value="	523	"	<?=($regiao == '523')?'selected':'' ?>	>	523	ª Região	</option>
                    <option value="	524	"	<?=($regiao == '524')?'selected':'' ?>	>	524	ª Região	</option>
                    <option value="	525	"	<?=($regiao == '525')?'selected':'' ?>	>	525	ª Região	</option>
                    <option value="	526	"	<?=($regiao == '526')?'selected':'' ?>	>	526	ª Região	</option>
                    <option value="	527	"	<?=($regiao == '527')?'selected':'' ?>	>	527	ª Região	</option>
                    <option value="	528	"	<?=($regiao == '528')?'selected':'' ?>	>	528	ª Região	</option>
                    <option value="	529	"	<?=($regiao == '529')?'selected':'' ?>	>	529	ª Região	</option>
                    <option value="	530	"	<?=($regiao == '530')?'selected':'' ?>	>	530	ª Região	</option>
                    <option value="	531	"	<?=($regiao == '531')?'selected':'' ?>	>	531	ª Região	</option>
                    <option value="	532	"	<?=($regiao == '532')?'selected':'' ?>	>	532	ª Região	</option>
                    <option value="	533	"	<?=($regiao == '533')?'selected':'' ?>	>	533	ª Região	</option>
                    <option value="	534	"	<?=($regiao == '534')?'selected':'' ?>	>	534	ª Região	</option>
                    <option value="	535	"	<?=($regiao == '535')?'selected':'' ?>	>	535	ª Região	</option>
                    <option value="	536	"	<?=($regiao == '536')?'selected':'' ?>	>	536	ª Região	</option>
                    <option value="	537	"	<?=($regiao == '537')?'selected':'' ?>	>	537	ª Região	</option>
                    <option value="	538	"	<?=($regiao == '538')?'selected':'' ?>	>	538	ª Região	</option>
                    <option value="	539	"	<?=($regiao == '539')?'selected':'' ?>	>	539	ª Região	</option>
                    <option value="	540	"	<?=($regiao == '540')?'selected':'' ?>	>	540	ª Região	</option>
                    <option value="	541	"	<?=($regiao == '541')?'selected':'' ?>	>	541	ª Região	</option>
                    <option value="	542	"	<?=($regiao == '542')?'selected':'' ?>	>	542	ª Região	</option>
                    <option value="	543	"	<?=($regiao == '543')?'selected':'' ?>	>	543	ª Região	</option>
                    <option value="	544	"	<?=($regiao == '544')?'selected':'' ?>	>	544	ª Região	</option>
                    <option value="	545	"	<?=($regiao == '545')?'selected':'' ?>	>	545	ª Região	</option>
                    <option value="	546	"	<?=($regiao == '546')?'selected':'' ?>	>	546	ª Região	</option>
                    <option value="	547	"	<?=($regiao == '547')?'selected':'' ?>	>	547	ª Região	</option>
                    <option value="	548	"	<?=($regiao == '548')?'selected':'' ?>	>	548	ª Região	</option>
                    <option value="	549	"	<?=($regiao == '549')?'selected':'' ?>	>	549	ª Região	</option>
                    <option value="	550	"	<?=($regiao == '550')?'selected':'' ?>	>	550	ª Região	</option>
                    <option value="	551	"	<?=($regiao == '551')?'selected':'' ?>	>	551	ª Região	</option>
                    <option value="	552	"	<?=($regiao == '552')?'selected':'' ?>	>	552	ª Região	</option>
                    <option value="	553	"	<?=($regiao == '553')?'selected':'' ?>	>	553	ª Região	</option>
                    <option value="	554	"	<?=($regiao == '554')?'selected':'' ?>	>	554	ª Região	</option>
                    <option value="	555	"	<?=($regiao == '555')?'selected':'' ?>	>	555	ª Região	</option>
                    <option value="	556	"	<?=($regiao == '556')?'selected':'' ?>	>	556	ª Região	</option>
                    <option value="	557	"	<?=($regiao == '557')?'selected':'' ?>	>	557	ª Região	</option>
                    <option value="	558	"	<?=($regiao == '558')?'selected':'' ?>	>	558	ª Região	</option>
                    <option value="	559	"	<?=($regiao == '559')?'selected':'' ?>	>	559	ª Região	</option>
                    <option value="	560	"	<?=($regiao == '560')?'selected':'' ?>	>	560	ª Região	</option>
                    <option value="	561	"	<?=($regiao == '561')?'selected':'' ?>	>	561	ª Região	</option>
                    <option value="	562	"	<?=($regiao == '562')?'selected':'' ?>	>	562	ª Região	</option>
                    <option value="	563	"	<?=($regiao == '563')?'selected':'' ?>	>	563	ª Região	</option>
                    <option value="	564	"	<?=($regiao == '564')?'selected':'' ?>	>	564	ª Região	</option>
                    <option value="	565	"	<?=($regiao == '565')?'selected':'' ?>	>	565	ª Região	</option>
                    <option value="	566	"	<?=($regiao == '566')?'selected':'' ?>	>	566	ª Região	</option>
                    <option value="	567	"	<?=($regiao == '567')?'selected':'' ?>	>	567	ª Região	</option>
                    <option value="	568	"	<?=($regiao == '568')?'selected':'' ?>	>	568	ª Região	</option>
                    <option value="	569	"	<?=($regiao == '569')?'selected':'' ?>	>	569	ª Região	</option>
                    <option value="	570	"	<?=($regiao == '570')?'selected':'' ?>	>	570	ª Região	</option>
                    <option value="	571	"	<?=($regiao == '571')?'selected':'' ?>	>	571	ª Região	</option>
                    <option value="	572	"	<?=($regiao == '572')?'selected':'' ?>	>	572	ª Região	</option>
                    <option value="	573	"	<?=($regiao == '573')?'selected':'' ?>	>	573	ª Região	</option>
                    <option value="	574	"	<?=($regiao == '574')?'selected':'' ?>	>	574	ª Região	</option>
                    <option value="	575	"	<?=($regiao == '575')?'selected':'' ?>	>	575	ª Região	</option>
                    <option value="	576	"	<?=($regiao == '576')?'selected':'' ?>	>	576	ª Região	</option>
                    <option value="	577	"	<?=($regiao == '577')?'selected':'' ?>	>	577	ª Região	</option>
                    <option value="	578	"	<?=($regiao == '578')?'selected':'' ?>	>	578	ª Região	</option>
                    <option value="	579	"	<?=($regiao == '579')?'selected':'' ?>	>	579	ª Região	</option>
                    <option value="	580	"	<?=($regiao == '580')?'selected':'' ?>	>	580	ª Região	</option>
                    <option value="	581	"	<?=($regiao == '581')?'selected':'' ?>	>	581	ª Região	</option>
                    <option value="	582	"	<?=($regiao == '582')?'selected':'' ?>	>	582	ª Região	</option>
                    <option value="	583	"	<?=($regiao == '583')?'selected':'' ?>	>	583	ª Região	</option>
                    <option value="	584	"	<?=($regiao == '584')?'selected':'' ?>	>	584	ª Região	</option>
                    <option value="	585	"	<?=($regiao == '585')?'selected':'' ?>	>	585	ª Região	</option>
                    <option value="	586	"	<?=($regiao == '586')?'selected':'' ?>	>	586	ª Região	</option>
                    <option value="	587	"	<?=($regiao == '587')?'selected':'' ?>	>	587	ª Região	</option>
                    <option value="	588	"	<?=($regiao == '588')?'selected':'' ?>	>	588	ª Região	</option>
                    <option value="	589	"	<?=($regiao == '589')?'selected':'' ?>	>	589	ª Região	</option>
                    <option value="	590	"	<?=($regiao == '590')?'selected':'' ?>	>	590	ª Região	</option>
                    <option value="	591	"	<?=($regiao == '591')?'selected':'' ?>	>	591	ª Região	</option>
                    <option value="	592	"	<?=($regiao == '592')?'selected':'' ?>	>	592	ª Região	</option>
                    <option value="	593	"	<?=($regiao == '593')?'selected':'' ?>	>	593	ª Região	</option>
                    <option value="	594	"	<?=($regiao == '594')?'selected':'' ?>	>	594	ª Região	</option>
                    <option value="	595	"	<?=($regiao == '595')?'selected':'' ?>	>	595	ª Região	</option>
                    <option value="	596	"	<?=($regiao == '596')?'selected':'' ?>	>	596	ª Região	</option>
                    <option value="	597	"	<?=($regiao == '597')?'selected':'' ?>	>	597	ª Região	</option>
                    <option value="	598	"	<?=($regiao == '598')?'selected':'' ?>	>	598	ª Região	</option>
                    <option value="	599	"	<?=($regiao == '599')?'selected':'' ?>	>	599	ª Região	</option>
                    <option value="	600	"	<?=($regiao == '600')?'selected':'' ?>	>	600	ª Região	</option>
                    <option value="	601	"	<?=($regiao == '601')?'selected':'' ?>	>	601	ª Região	</option>
                    <option value="	602	"	<?=($regiao == '602')?'selected':'' ?>	>	602	ª Região	</option>
                    <option value="	603	"	<?=($regiao == '603')?'selected':'' ?>	>	603	ª Região	</option>
                    <option value="	604	"	<?=($regiao == '604')?'selected':'' ?>	>	604	ª Região	</option>
                    <option value="	605	"	<?=($regiao == '605')?'selected':'' ?>	>	605	ª Região	</option>
                    <option value="	606	"	<?=($regiao == '606')?'selected':'' ?>	>	606	ª Região	</option>
                    <option value="	607	"	<?=($regiao == '607')?'selected':'' ?>	>	607	ª Região	</option>
                    <option value="	608	"	<?=($regiao == '608')?'selected':'' ?>	>	608	ª Região	</option>
                    <option value="	609	"	<?=($regiao == '609')?'selected':'' ?>	>	609	ª Região	</option>
                    <option value="	610	"	<?=($regiao == '610')?'selected':'' ?>	>	610	ª Região	</option>
                    <option value="	611	"	<?=($regiao == '611')?'selected':'' ?>	>	611	ª Região	</option>
                    <option value="	612	"	<?=($regiao == '612')?'selected':'' ?>	>	612	ª Região	</option>
                    <option value="	613	"	<?=($regiao == '613')?'selected':'' ?>	>	613	ª Região	</option>
                    <option value="	614	"	<?=($regiao == '614')?'selected':'' ?>	>	614	ª Região	</option>
                    <option value="	615	"	<?=($regiao == '615')?'selected':'' ?>	>	615	ª Região	</option>
                    <option value="	616	"	<?=($regiao == '616')?'selected':'' ?>	>	616	ª Região	</option>
                    <option value="	617	"	<?=($regiao == '617')?'selected':'' ?>	>	617	ª Região	</option>
                    <option value="	618	"	<?=($regiao == '618')?'selected':'' ?>	>	618	ª Região	</option>
                    <option value="	619	"	<?=($regiao == '619')?'selected':'' ?>	>	619	ª Região	</option>
                    <option value="	620	"	<?=($regiao == '620')?'selected':'' ?>	>	620	ª Região	</option>
                    <option value="	621	"	<?=($regiao == '621')?'selected':'' ?>	>	621	ª Região	</option>
                    <option value="	622	"	<?=($regiao == '622')?'selected':'' ?>	>	622	ª Região	</option>
                    <option value="	623	"	<?=($regiao == '623')?'selected':'' ?>	>	623	ª Região	</option>
                    <option value="	624	"	<?=($regiao == '624')?'selected':'' ?>	>	624	ª Região	</option>
                    <option value="	625	"	<?=($regiao == '625')?'selected':'' ?>	>	625	ª Região	</option>
                    <option value="	626	"	<?=($regiao == '626')?'selected':'' ?>	>	626	ª Região	</option>
                    <option value="	627	"	<?=($regiao == '627')?'selected':'' ?>	>	627	ª Região	</option>
                    <option value="	628	"	<?=($regiao == '628')?'selected':'' ?>	>	628	ª Região	</option>
                    <option value="	629	"	<?=($regiao == '629')?'selected':'' ?>	>	629	ª Região	</option>
                    <option value="	630	"	<?=($regiao == '630')?'selected':'' ?>	>	630	ª Região	</option>
                    <option value="	631	"	<?=($regiao == '631')?'selected':'' ?>	>	631	ª Região	</option>
                    <option value="	632	"	<?=($regiao == '632')?'selected':'' ?>	>	632	ª Região	</option>
                    <option value="	633	"	<?=($regiao == '633')?'selected':'' ?>	>	633	ª Região	</option>
                    <option value="	634	"	<?=($regiao == '634')?'selected':'' ?>	>	634	ª Região	</option>
                    <option value="	635	"	<?=($regiao == '635')?'selected':'' ?>	>	635	ª Região	</option>
                    <option value="	636	"	<?=($regiao == '636')?'selected':'' ?>	>	636	ª Região	</option>
                    <option value="	637	"	<?=($regiao == '637')?'selected':'' ?>	>	637	ª Região	</option>
                    <option value="	638	"	<?=($regiao == '638')?'selected':'' ?>	>	638	ª Região	</option>
                    <option value="	639	"	<?=($regiao == '639')?'selected':'' ?>	>	639	ª Região	</option>
                    <option value="	640	"	<?=($regiao == '640')?'selected':'' ?>	>	640	ª Região	</option>
                    <option value="	641	"	<?=($regiao == '641')?'selected':'' ?>	>	641	ª Região	</option>
                    <option value="	642	"	<?=($regiao == '642')?'selected':'' ?>	>	642	ª Região	</option>
                    <option value="	643	"	<?=($regiao == '643')?'selected':'' ?>	>	643	ª Região	</option>
                    <option value="	644	"	<?=($regiao == '644')?'selected':'' ?>	>	644	ª Região	</option>
                    <option value="	645	"	<?=($regiao == '645')?'selected':'' ?>	>	645	ª Região	</option>
                    <option value="	646	"	<?=($regiao == '646')?'selected':'' ?>	>	646	ª Região	</option>
                    <option value="	647	"	<?=($regiao == '647')?'selected':'' ?>	>	647	ª Região	</option>
                    <option value="	648	"	<?=($regiao == '648')?'selected':'' ?>	>	648	ª Região	</option>
                    <option value="	649	"	<?=($regiao == '649')?'selected':'' ?>	>	649	ª Região	</option>
                    <option value="	650	"	<?=($regiao == '650')?'selected':'' ?>	>	650	ª Região	</option>
                    <option value="	651	"	<?=($regiao == '651')?'selected':'' ?>	>	651	ª Região	</option>
                    <option value="	652	"	<?=($regiao == '652')?'selected':'' ?>	>	652	ª Região	</option>
                    <option value="	653	"	<?=($regiao == '653')?'selected':'' ?>	>	653	ª Região	</option>
                    <option value="	654	"	<?=($regiao == '654')?'selected':'' ?>	>	654	ª Região	</option>
                    <option value="	655	"	<?=($regiao == '655')?'selected':'' ?>	>	655	ª Região	</option>
                    <option value="	656	"	<?=($regiao == '656')?'selected':'' ?>	>	656	ª Região	</option>
                    <option value="	657	"	<?=($regiao == '657')?'selected':'' ?>	>	657	ª Região	</option>
                    <option value="	658	"	<?=($regiao == '658')?'selected':'' ?>	>	658	ª Região	</option>
                    <option value="	659	"	<?=($regiao == '659')?'selected':'' ?>	>	659	ª Região	</option>
                    <option value="	660	"	<?=($regiao == '660')?'selected':'' ?>	>	660	ª Região	</option>
                    <option value="	661	"	<?=($regiao == '661')?'selected':'' ?>	>	661	ª Região	</option>
                    <option value="	662	"	<?=($regiao == '662')?'selected':'' ?>	>	662	ª Região	</option>
                    <option value="	663	"	<?=($regiao == '663')?'selected':'' ?>	>	663	ª Região	</option>
                    <option value="	664	"	<?=($regiao == '664')?'selected':'' ?>	>	664	ª Região	</option>
                    <option value="	665	"	<?=($regiao == '665')?'selected':'' ?>	>	665	ª Região	</option>
                    <option value="	666	"	<?=($regiao == '666')?'selected':'' ?>	>	666	ª Região	</option>
                    <option value="	667	"	<?=($regiao == '667')?'selected':'' ?>	>	667	ª Região	</option>
                    <option value="	668	"	<?=($regiao == '668')?'selected':'' ?>	>	668	ª Região	</option>
                    <option value="	669	"	<?=($regiao == '669')?'selected':'' ?>	>	669	ª Região	</option>
                    <option value="	670	"	<?=($regiao == '670')?'selected':'' ?>	>	670	ª Região	</option>
                    <option value="	671	"	<?=($regiao == '671')?'selected':'' ?>	>	671	ª Região	</option>
                    <option value="	672	"	<?=($regiao == '672')?'selected':'' ?>	>	672	ª Região	</option>
                    <option value="	673	"	<?=($regiao == '673')?'selected':'' ?>	>	673	ª Região	</option>
                    <option value="	674	"	<?=($regiao == '674')?'selected':'' ?>	>	674	ª Região	</option>
                    <option value="	675	"	<?=($regiao == '675')?'selected':'' ?>	>	675	ª Região	</option>
                    <option value="	676	"	<?=($regiao == '676')?'selected':'' ?>	>	676	ª Região	</option>
                    <option value="	677	"	<?=($regiao == '677')?'selected':'' ?>	>	677	ª Região	</option>
                    <option value="	678	"	<?=($regiao == '678')?'selected':'' ?>	>	678	ª Região	</option>
                    <option value="	679	"	<?=($regiao == '679')?'selected':'' ?>	>	679	ª Região	</option>
                    <option value="	680	"	<?=($regiao == '680')?'selected':'' ?>	>	680	ª Região	</option>
                    <option value="	681	"	<?=($regiao == '681')?'selected':'' ?>	>	681	ª Região	</option>
                    <option value="	682	"	<?=($regiao == '682')?'selected':'' ?>	>	682	ª Região	</option>
                    <option value="	683	"	<?=($regiao == '683')?'selected':'' ?>	>	683	ª Região	</option>
                    <option value="	684	"	<?=($regiao == '684')?'selected':'' ?>	>	684	ª Região	</option>
                    <option value="	685	"	<?=($regiao == '685')?'selected':'' ?>	>	685	ª Região	</option>
                    <option value="	686	"	<?=($regiao == '686')?'selected':'' ?>	>	686	ª Região	</option>
                    <option value="	687	"	<?=($regiao == '687')?'selected':'' ?>	>	687	ª Região	</option>
                    <option value="	688	"	<?=($regiao == '688')?'selected':'' ?>	>	688	ª Região	</option>
                    <option value="	689	"	<?=($regiao == '689')?'selected':'' ?>	>	689	ª Região	</option>
                    <option value="	690	"	<?=($regiao == '690')?'selected':'' ?>	>	690	ª Região	</option>
                    <option value="	691	"	<?=($regiao == '691')?'selected':'' ?>	>	691	ª Região	</option>
                    <option value="	692	"	<?=($regiao == '692')?'selected':'' ?>	>	692	ª Região	</option>
                    <option value="	693	"	<?=($regiao == '693')?'selected':'' ?>	>	693	ª Região	</option>
                    <option value="	694	"	<?=($regiao == '694')?'selected':'' ?>	>	694	ª Região	</option>
                    <option value="	695	"	<?=($regiao == '695')?'selected':'' ?>	>	695	ª Região	</option>
                    <option value="	696	"	<?=($regiao == '696')?'selected':'' ?>	>	696	ª Região	</option>
                    <option value="	697	"	<?=($regiao == '697')?'selected':'' ?>	>	697	ª Região	</option>
                    <option value="	698	"	<?=($regiao == '698')?'selected':'' ?>	>	698	ª Região	</option>
                    <option value="	699	"	<?=($regiao == '699')?'selected':'' ?>	>	699	ª Região	</option>
                    <option value="	700	"	<?=($regiao == '700')?'selected':'' ?>	>	700	ª Região	</option>
                    <option value="	701	"	<?=($regiao == '701')?'selected':'' ?>	>	701	ª Região	</option>
                    <option value="	702	"	<?=($regiao == '702')?'selected':'' ?>	>	702	ª Região	</option>
                    <option value="	703	"	<?=($regiao == '703')?'selected':'' ?>	>	703	ª Região	</option>
                    <option value="	704	"	<?=($regiao == '704')?'selected':'' ?>	>	704	ª Região	</option>
                    <option value="	705	"	<?=($regiao == '705')?'selected':'' ?>	>	705	ª Região	</option>
                    <option value="	706	"	<?=($regiao == '706')?'selected':'' ?>	>	706	ª Região	</option>
                    <option value="	707	"	<?=($regiao == '707')?'selected':'' ?>	>	707	ª Região	</option>
                    <option value="	708	"	<?=($regiao == '708')?'selected':'' ?>	>	708	ª Região	</option>
                    <option value="	709	"	<?=($regiao == '709')?'selected':'' ?>	>	709	ª Região	</option>
                    <option value="	710	"	<?=($regiao == '710')?'selected':'' ?>	>	710	ª Região	</option>
                    <option value="	711	"	<?=($regiao == '711')?'selected':'' ?>	>	711	ª Região	</option>
                    <option value="	712	"	<?=($regiao == '712')?'selected':'' ?>	>	712	ª Região	</option>
                    <option value="	713	"	<?=($regiao == '713')?'selected':'' ?>	>	713	ª Região	</option>
                    <option value="	714	"	<?=($regiao == '714')?'selected':'' ?>	>	714	ª Região	</option>
                    <option value="	715	"	<?=($regiao == '715')?'selected':'' ?>	>	715	ª Região	</option>
                    <option value="	716	"	<?=($regiao == '716')?'selected':'' ?>	>	716	ª Região	</option>
                    <option value="	717	"	<?=($regiao == '717')?'selected':'' ?>	>	717	ª Região	</option>
                    <option value="	718	"	<?=($regiao == '718')?'selected':'' ?>	>	718	ª Região	</option>
                    <option value="	719	"	<?=($regiao == '719')?'selected':'' ?>	>	719	ª Região	</option>
                    <option value="	720	"	<?=($regiao == '720')?'selected':'' ?>	>	720	ª Região	</option>
                    <option value="	721	"	<?=($regiao == '721')?'selected':'' ?>	>	721	ª Região	</option>
                    <option value="	722	"	<?=($regiao == '722')?'selected':'' ?>	>	722	ª Região	</option>
                    <option value="	723	"	<?=($regiao == '723')?'selected':'' ?>	>	723	ª Região	</option>
                    <option value="	724	"	<?=($regiao == '724')?'selected':'' ?>	>	724	ª Região	</option>
                    <option value="	725	"	<?=($regiao == '725')?'selected':'' ?>	>	725	ª Região	</option>
                    <option value="	726	"	<?=($regiao == '726')?'selected':'' ?>	>	726	ª Região	</option>
                    <option value="	727	"	<?=($regiao == '727')?'selected':'' ?>	>	727	ª Região	</option>
                    <option value="	728	"	<?=($regiao == '728')?'selected':'' ?>	>	728	ª Região	</option>
                    <option value="	729	"	<?=($regiao == '729')?'selected':'' ?>	>	729	ª Região	</option>
                    <option value="	730	"	<?=($regiao == '730')?'selected':'' ?>	>	730	ª Região	</option>
                    <option value="	731	"	<?=($regiao == '731')?'selected':'' ?>	>	731	ª Região	</option>
                    <option value="	732	"	<?=($regiao == '732')?'selected':'' ?>	>	732	ª Região	</option>
                    <option value="	733	"	<?=($regiao == '733')?'selected':'' ?>	>	733	ª Região	</option>
                    <option value="	734	"	<?=($regiao == '734')?'selected':'' ?>	>	734	ª Região	</option>
                    <option value="	735	"	<?=($regiao == '735')?'selected':'' ?>	>	735	ª Região	</option>
                    <option value="	736	"	<?=($regiao == '736')?'selected':'' ?>	>	736	ª Região	</option>
                    <option value="	737	"	<?=($regiao == '737')?'selected':'' ?>	>	737	ª Região	</option>
                    <option value="	738	"	<?=($regiao == '738')?'selected':'' ?>	>	738	ª Região	</option>
                    <option value="	739	"	<?=($regiao == '739')?'selected':'' ?>	>	739	ª Região	</option>
                    <option value="	740	"	<?=($regiao == '740')?'selected':'' ?>	>	740	ª Região	</option>
                    <option value="	741	"	<?=($regiao == '741')?'selected':'' ?>	>	741	ª Região	</option>
                    <option value="	742	"	<?=($regiao == '742')?'selected':'' ?>	>	742	ª Região	</option>
                    <option value="	743	"	<?=($regiao == '743')?'selected':'' ?>	>	743	ª Região	</option>
                    <option value="	744	"	<?=($regiao == '744')?'selected':'' ?>	>	744	ª Região	</option>
                    <option value="	745	"	<?=($regiao == '745')?'selected':'' ?>	>	745	ª Região	</option>
                    <option value="	746	"	<?=($regiao == '746')?'selected':'' ?>	>	746	ª Região	</option>
                    <option value="	747	"	<?=($regiao == '747')?'selected':'' ?>	>	747	ª Região	</option>
                    <option value="	748	"	<?=($regiao == '748')?'selected':'' ?>	>	748	ª Região	</option>
                    <option value="	749	"	<?=($regiao == '749')?'selected':'' ?>	>	749	ª Região	</option>
                    <option value="	750	"	<?=($regiao == '750')?'selected':'' ?>	>	750	ª Região	</option>
                    <option value="	751	"	<?=($regiao == '751')?'selected':'' ?>	>	751	ª Região	</option>
                    <option value="	752	"	<?=($regiao == '752')?'selected':'' ?>	>	752	ª Região	</option>
                    <option value="	753	"	<?=($regiao == '753')?'selected':'' ?>	>	753	ª Região	</option>
                    <option value="	754	"	<?=($regiao == '754')?'selected':'' ?>	>	754	ª Região	</option>
                    <option value="	755	"	<?=($regiao == '755')?'selected':'' ?>	>	755	ª Região	</option>
                    <option value="	756	"	<?=($regiao == '756')?'selected':'' ?>	>	756	ª Região	</option>
                    <option value="	757	"	<?=($regiao == '757')?'selected':'' ?>	>	757	ª Região	</option>
                    <option value="	758	"	<?=($regiao == '758')?'selected':'' ?>	>	758	ª Região	</option>
                    <option value="	759	"	<?=($regiao == '759')?'selected':'' ?>	>	759	ª Região	</option>
                    <option value="	760	"	<?=($regiao == '760')?'selected':'' ?>	>	760	ª Região	</option>
                    <option value="	761	"	<?=($regiao == '761')?'selected':'' ?>	>	761	ª Região	</option>
                    <option value="	762	"	<?=($regiao == '762')?'selected':'' ?>	>	762	ª Região	</option>
                    <option value="	763	"	<?=($regiao == '763')?'selected':'' ?>	>	763	ª Região	</option>
                    <option value="	764	"	<?=($regiao == '764')?'selected':'' ?>	>	764	ª Região	</option>
                    <option value="	765	"	<?=($regiao == '765')?'selected':'' ?>	>	765	ª Região	</option>
                    <option value="	766	"	<?=($regiao == '766')?'selected':'' ?>	>	766	ª Região	</option>
                    <option value="	767	"	<?=($regiao == '767')?'selected':'' ?>	>	767	ª Região	</option>
                    <option value="	768	"	<?=($regiao == '768')?'selected':'' ?>	>	768	ª Região	</option>
                    <option value="	769	"	<?=($regiao == '769')?'selected':'' ?>	>	769	ª Região	</option>
                    <option value="	770	"	<?=($regiao == '770')?'selected':'' ?>	>	770	ª Região	</option>
                    <option value="	771	"	<?=($regiao == '771')?'selected':'' ?>	>	771	ª Região	</option>
                    <option value="	772	"	<?=($regiao == '772')?'selected':'' ?>	>	772	ª Região	</option>
                    <option value="	773	"	<?=($regiao == '773')?'selected':'' ?>	>	773	ª Região	</option>
                    <option value="	774	"	<?=($regiao == '774')?'selected':'' ?>	>	774	ª Região	</option>
                    <option value="	775	"	<?=($regiao == '775')?'selected':'' ?>	>	775	ª Região	</option>
                    <option value="	776	"	<?=($regiao == '776')?'selected':'' ?>	>	776	ª Região	</option>
                    <option value="	777	"	<?=($regiao == '777')?'selected':'' ?>	>	777	ª Região	</option>
                    <option value="	778	"	<?=($regiao == '778')?'selected':'' ?>	>	778	ª Região	</option>
                    <option value="	779	"	<?=($regiao == '779')?'selected':'' ?>	>	779	ª Região	</option>
                    <option value="	780	"	<?=($regiao == '780')?'selected':'' ?>	>	780	ª Região	</option>
                    <option value="	781	"	<?=($regiao == '781')?'selected':'' ?>	>	781	ª Região	</option>
                    <option value="	782	"	<?=($regiao == '782')?'selected':'' ?>	>	782	ª Região	</option>
                    <option value="	783	"	<?=($regiao == '783')?'selected':'' ?>	>	783	ª Região	</option>
                    <option value="	784	"	<?=($regiao == '784')?'selected':'' ?>	>	784	ª Região	</option>
                    <option value="	785	"	<?=($regiao == '785')?'selected':'' ?>	>	785	ª Região	</option>
                    <option value="	786	"	<?=($regiao == '786')?'selected':'' ?>	>	786	ª Região	</option>
                    <option value="	787	"	<?=($regiao == '787')?'selected':'' ?>	>	787	ª Região	</option>
                    <option value="	788	"	<?=($regiao == '788')?'selected':'' ?>	>	788	ª Região	</option>
                    <option value="	789	"	<?=($regiao == '789')?'selected':'' ?>	>	789	ª Região	</option>
                    <option value="	790	"	<?=($regiao == '790')?'selected':'' ?>	>	790	ª Região	</option>
                    <option value="	791	"	<?=($regiao == '791')?'selected':'' ?>	>	791	ª Região	</option>
                    <option value="	792	"	<?=($regiao == '792')?'selected':'' ?>	>	792	ª Região	</option>
                    <option value="	793	"	<?=($regiao == '793')?'selected':'' ?>	>	793	ª Região	</option>
                    <option value="	794	"	<?=($regiao == '794')?'selected':'' ?>	>	794	ª Região	</option>
                    <option value="	795	"	<?=($regiao == '795')?'selected':'' ?>	>	795	ª Região	</option>
                    <option value="	796	"	<?=($regiao == '796')?'selected':'' ?>	>	796	ª Região	</option>
                    <option value="	797	"	<?=($regiao == '797')?'selected':'' ?>	>	797	ª Região	</option>
                    <option value="	798	"	<?=($regiao == '798')?'selected':'' ?>	>	798	ª Região	</option>
                    <option value="	799	"	<?=($regiao == '799')?'selected':'' ?>	>	799	ª Região	</option>
                    <option value="	800	"	<?=($regiao == '800')?'selected':'' ?>	>	800	ª Região	</option>
                    <option value="	801	"	<?=($regiao == '801')?'selected':'' ?>	>	801	ª Região	</option>
                    <option value="	802	"	<?=($regiao == '802')?'selected':'' ?>	>	802	ª Região	</option>
                    <option value="	803	"	<?=($regiao == '803')?'selected':'' ?>	>	803	ª Região	</option>
                    <option value="	804	"	<?=($regiao == '804')?'selected':'' ?>	>	804	ª Região	</option>
                    <option value="	805	"	<?=($regiao == '805')?'selected':'' ?>	>	805	ª Região	</option>
                    <option value="	806	"	<?=($regiao == '806')?'selected':'' ?>	>	806	ª Região	</option>
                    <option value="	807	"	<?=($regiao == '807')?'selected':'' ?>	>	807	ª Região	</option>
                    <option value="	808	"	<?=($regiao == '808')?'selected':'' ?>	>	808	ª Região	</option>
                    <option value="	809	"	<?=($regiao == '809')?'selected':'' ?>	>	809	ª Região	</option>
                    <option value="	810	"	<?=($regiao == '810')?'selected':'' ?>	>	810	ª Região	</option>
                    <option value="	811	"	<?=($regiao == '811')?'selected':'' ?>	>	811	ª Região	</option>
                    <option value="	812	"	<?=($regiao == '812')?'selected':'' ?>	>	812	ª Região	</option>
                    <option value="	813	"	<?=($regiao == '813')?'selected':'' ?>	>	813	ª Região	</option>
                    <option value="	814	"	<?=($regiao == '814')?'selected':'' ?>	>	814	ª Região	</option>
                    <option value="	815	"	<?=($regiao == '815')?'selected':'' ?>	>	815	ª Região	</option>
                    <option value="	816	"	<?=($regiao == '816')?'selected':'' ?>	>	816	ª Região	</option>
                    <option value="	817	"	<?=($regiao == '817')?'selected':'' ?>	>	817	ª Região	</option>
                    <option value="	818	"	<?=($regiao == '818')?'selected':'' ?>	>	818	ª Região	</option>
                    <option value="	819	"	<?=($regiao == '819')?'selected':'' ?>	>	819	ª Região	</option>
                    <option value="	820	"	<?=($regiao == '820')?'selected':'' ?>	>	820	ª Região	</option>
                    <option value="	821	"	<?=($regiao == '821')?'selected':'' ?>	>	821	ª Região	</option>
                    <option value="	822	"	<?=($regiao == '822')?'selected':'' ?>	>	822	ª Região	</option>
                    <option value="	823	"	<?=($regiao == '823')?'selected':'' ?>	>	823	ª Região	</option>
                    <option value="	824	"	<?=($regiao == '824')?'selected':'' ?>	>	824	ª Região	</option>
                    <option value="	825	"	<?=($regiao == '825')?'selected':'' ?>	>	825	ª Região	</option>
                    <option value="	826	"	<?=($regiao == '826')?'selected':'' ?>	>	826	ª Região	</option>
                    <option value="	827	"	<?=($regiao == '827')?'selected':'' ?>	>	827	ª Região	</option>
                    <option value="	828	"	<?=($regiao == '828')?'selected':'' ?>	>	828	ª Região	</option>
                    <option value="	829	"	<?=($regiao == '829')?'selected':'' ?>	>	829	ª Região	</option>
                    <option value="	830	"	<?=($regiao == '830')?'selected':'' ?>	>	830	ª Região	</option>
                    <option value="	831	"	<?=($regiao == '831')?'selected':'' ?>	>	831	ª Região	</option>
                    <option value="	832	"	<?=($regiao == '832')?'selected':'' ?>	>	832	ª Região	</option>
                    <option value="	833	"	<?=($regiao == '833')?'selected':'' ?>	>	833	ª Região	</option>
                    <option value="	834	"	<?=($regiao == '834')?'selected':'' ?>	>	834	ª Região	</option>
                    <option value="	835	"	<?=($regiao == '835')?'selected':'' ?>	>	835	ª Região	</option>
                    <option value="	836	"	<?=($regiao == '836')?'selected':'' ?>	>	836	ª Região	</option>
                    <option value="	837	"	<?=($regiao == '837')?'selected':'' ?>	>	837	ª Região	</option>
                    <option value="	838	"	<?=($regiao == '838')?'selected':'' ?>	>	838	ª Região	</option>
                    <option value="	839	"	<?=($regiao == '839')?'selected':'' ?>	>	839	ª Região	</option>
                    <option value="	840	"	<?=($regiao == '840')?'selected':'' ?>	>	840	ª Região	</option>
                    <option value="	841	"	<?=($regiao == '841')?'selected':'' ?>	>	841	ª Região	</option>
                    <option value="	842	"	<?=($regiao == '842')?'selected':'' ?>	>	842	ª Região	</option>
                    <option value="	843	"	<?=($regiao == '843')?'selected':'' ?>	>	843	ª Região	</option>
                    <option value="	844	"	<?=($regiao == '844')?'selected':'' ?>	>	844	ª Região	</option>
                    <option value="	845	"	<?=($regiao == '845')?'selected':'' ?>	>	845	ª Região	</option>
                    <option value="	846	"	<?=($regiao == '846')?'selected':'' ?>	>	846	ª Região	</option>
                    <option value="	847	"	<?=($regiao == '847')?'selected':'' ?>	>	847	ª Região	</option>
                    <option value="	848	"	<?=($regiao == '848')?'selected':'' ?>	>	848	ª Região	</option>
                    <option value="	849	"	<?=($regiao == '849')?'selected':'' ?>	>	849	ª Região	</option>
                    <option value="	850	"	<?=($regiao == '850')?'selected':'' ?>	>	850	ª Região	</option>
                    <option value="	851	"	<?=($regiao == '851')?'selected':'' ?>	>	851	ª Região	</option>
                    <option value="	852	"	<?=($regiao == '852')?'selected':'' ?>	>	852	ª Região	</option>
                    <option value="	853	"	<?=($regiao == '853')?'selected':'' ?>	>	853	ª Região	</option>
                    <option value="	854	"	<?=($regiao == '854')?'selected':'' ?>	>	854	ª Região	</option>
                    <option value="	855	"	<?=($regiao == '855')?'selected':'' ?>	>	855	ª Região	</option>
                    <option value="	856	"	<?=($regiao == '856')?'selected':'' ?>	>	856	ª Região	</option>
                    <option value="	857	"	<?=($regiao == '857')?'selected':'' ?>	>	857	ª Região	</option>
                    <option value="	858	"	<?=($regiao == '858')?'selected':'' ?>	>	858	ª Região	</option>
                    <option value="	859	"	<?=($regiao == '859')?'selected':'' ?>	>	859	ª Região	</option>
                    <option value="	860	"	<?=($regiao == '860')?'selected':'' ?>	>	860	ª Região	</option>
                    <option value="	861	"	<?=($regiao == '861')?'selected':'' ?>	>	861	ª Região	</option>
                    <option value="	862	"	<?=($regiao == '862')?'selected':'' ?>	>	862	ª Região	</option>
                    <option value="	863	"	<?=($regiao == '863')?'selected':'' ?>	>	863	ª Região	</option>
                    <option value="	864	"	<?=($regiao == '864')?'selected':'' ?>	>	864	ª Região	</option>
                    <option value="	865	"	<?=($regiao == '865')?'selected':'' ?>	>	865	ª Região	</option>
                    <option value="	866	"	<?=($regiao == '866')?'selected':'' ?>	>	866	ª Região	</option>
                    <option value="	867	"	<?=($regiao == '867')?'selected':'' ?>	>	867	ª Região	</option>
                    <option value="	868	"	<?=($regiao == '868')?'selected':'' ?>	>	868	ª Região	</option>
                    <option value="	869	"	<?=($regiao == '869')?'selected':'' ?>	>	869	ª Região	</option>
                    <option value="	870	"	<?=($regiao == '870')?'selected':'' ?>	>	870	ª Região	</option>
                    <option value="	871	"	<?=($regiao == '871')?'selected':'' ?>	>	871	ª Região	</option>
                    <option value="	872	"	<?=($regiao == '872')?'selected':'' ?>	>	872	ª Região	</option>
                    <option value="	873	"	<?=($regiao == '873')?'selected':'' ?>	>	873	ª Região	</option>
                    <option value="	874	"	<?=($regiao == '874')?'selected':'' ?>	>	874	ª Região	</option>
                    <option value="	875	"	<?=($regiao == '875')?'selected':'' ?>	>	875	ª Região	</option>
                    <option value="	876	"	<?=($regiao == '876')?'selected':'' ?>	>	876	ª Região	</option>
                    <option value="	877	"	<?=($regiao == '877')?'selected':'' ?>	>	877	ª Região	</option>
                    <option value="	878	"	<?=($regiao == '878')?'selected':'' ?>	>	878	ª Região	</option>
                    <option value="	879	"	<?=($regiao == '879')?'selected':'' ?>	>	879	ª Região	</option>
                    <option value="	880	"	<?=($regiao == '880')?'selected':'' ?>	>	880	ª Região	</option>
                    <option value="	881	"	<?=($regiao == '881')?'selected':'' ?>	>	881	ª Região	</option>
                    <option value="	882	"	<?=($regiao == '882')?'selected':'' ?>	>	882	ª Região	</option>
                    <option value="	883	"	<?=($regiao == '883')?'selected':'' ?>	>	883	ª Região	</option>
                    <option value="	884	"	<?=($regiao == '884')?'selected':'' ?>	>	884	ª Região	</option>
                    <option value="	885	"	<?=($regiao == '885')?'selected':'' ?>	>	885	ª Região	</option>
                    <option value="	886	"	<?=($regiao == '886')?'selected':'' ?>	>	886	ª Região	</option>
                    <option value="	887	"	<?=($regiao == '887')?'selected':'' ?>	>	887	ª Região	</option>
                    <option value="	888	"	<?=($regiao == '888')?'selected':'' ?>	>	888	ª Região	</option>
                    <option value="	889	"	<?=($regiao == '889')?'selected':'' ?>	>	889	ª Região	</option>
                    <option value="	890	"	<?=($regiao == '890')?'selected':'' ?>	>	890	ª Região	</option>
                    <option value="	891	"	<?=($regiao == '891')?'selected':'' ?>	>	891	ª Região	</option>
                    <option value="	892	"	<?=($regiao == '892')?'selected':'' ?>	>	892	ª Região	</option>
                    <option value="	893	"	<?=($regiao == '893')?'selected':'' ?>	>	893	ª Região	</option>
                    <option value="	894	"	<?=($regiao == '894')?'selected':'' ?>	>	894	ª Região	</option>
                    <option value="	895	"	<?=($regiao == '895')?'selected':'' ?>	>	895	ª Região	</option>
                    <option value="	896	"	<?=($regiao == '896')?'selected':'' ?>	>	896	ª Região	</option>
                    <option value="	897	"	<?=($regiao == '897')?'selected':'' ?>	>	897	ª Região	</option>
                    <option value="	898	"	<?=($regiao == '898')?'selected':'' ?>	>	898	ª Região	</option>
                    <option value="	899	"	<?=($regiao == '899')?'selected':'' ?>	>	899	ª Região	</option>
                    <option value="900	"	<?=($regiao == '900')?'selected':'' ?>	>	900	ª Região	</option>
                    <option value="901	"	<?=($regiao == '901')?'selected':'' ?>	>	901	ª Região	</option>
                    <option value="902	"	<?=($regiao == '902')?'selected':'' ?>	>	902	ª Região	</option>
                    <option value="903	"	<?=($regiao == '903')?'selected':'' ?>	>	903	ª Região	</option>
                    <option value="904	"	<?=($regiao == '904')?'selected':'' ?>	>	904	ª Região	</option>
                    <option value="905	"	<?=($regiao == '905')?'selected':'' ?>	>	905	ª Região	</option>
                    <option value="906	"	<?=($regiao == '906')?'selected':'' ?>	>	906	ª Região	</option>
                    <option value="907	"	<?=($regiao == '907')?'selected':'' ?>	>	907	ª Região	</option>
                    <option value="908	"	<?=($regiao == '908')?'selected':'' ?>	>	908	ª Região	</option>
                    <option value="909	"	<?=($regiao == '909')?'selected':'' ?>	>	909	ª Região	</option>
                    <option value="910	"	<?=($regiao == '910')?'selected':'' ?>	>	910	ª Região	</option>
                    <option value="911	"	<?=($regiao == '911')?'selected':'' ?>	>	911	ª Região	</option>
                    <option value="912	"	<?=($regiao == '912')?'selected':'' ?>	>	912	ª Região	</option>
                    <option value="913	"	<?=($regiao == '913')?'selected':'' ?>	>	913	ª Região	</option>
                    <option value="914	"	<?=($regiao == '914')?'selected':'' ?>	>	914	ª Região	</option>
                    <option value="915	"	<?=($regiao == '915')?'selected':'' ?>	>	915	ª Região	</option>
                    <option value="916	"	<?=($regiao == '916')?'selected':'' ?>	>	916	ª Região	</option>
                    <option value="917	"	<?=($regiao == '917')?'selected':'' ?>	>	917	ª Região	</option>
                    <option value="918	"	<?=($regiao == '918')?'selected':'' ?>	>	918	ª Região	</option>
                    <option value="919	"	<?=($regiao == '919')?'selected':'' ?>	>	919	ª Região	</option>
                    <option value="920	"	<?=($regiao == '920')?'selected':'' ?>	>	920	ª Região	</option>
                    <option value="921	"	<?=($regiao == '921')?'selected':'' ?>	>	921	ª Região	</option>
                    <option value="922	"	<?=($regiao == '922')?'selected':'' ?>	>	922	ª Região	</option>
                    <option value="923	"	<?=($regiao == '923')?'selected':'' ?>	>	923	ª Região	</option>
                    <option value="924	"	<?=($regiao == '924')?'selected':'' ?>	>	924	ª Região	</option>
                    <option value="925	"	<?=($regiao == '925')?'selected':'' ?>	>	925	ª Região	</option>
                    <option value="926	"	<?=($regiao == '926')?'selected':'' ?>	>	926	ª Região	</option>
                    <option value="927	"	<?=($regiao == '927')?'selected':'' ?>	>	927	ª Região	</option>
                    <option value="928	"	<?=($regiao == '928')?'selected':'' ?>	>	928	ª Região	</option>
                    <option value="929	"	<?=($regiao == '929')?'selected':'' ?>	>	929	ª Região	</option>
                    <option value="930	"	<?=($regiao == '930')?'selected':'' ?>	>	930	ª Região	</option>
                    <option value="931	"	<?=($regiao == '931')?'selected':'' ?>	>	931	ª Região	</option>
                    <option value="932	"	<?=($regiao == '932')?'selected':'' ?>	>	932	ª Região	</option>
                    <option value="933	"	<?=($regiao == '933')?'selected':'' ?>	>	933	ª Região	</option>
                    <option value="934	"	<?=($regiao == '934')?'selected':'' ?>	>	934	ª Região	</option>
                    <option value="935	"	<?=($regiao == '935')?'selected':'' ?>	>	935	ª Região	</option>
                    <option value="936	"	<?=($regiao == '936')?'selected':'' ?>	>	936	ª Região	</option>
                    <option value="937	"	<?=($regiao == '937')?'selected':'' ?>	>	937	ª Região	</option>
                    <option value="938	"	<?=($regiao == '938')?'selected':'' ?>	>	938	ª Região	</option>
                    <option value="939	"	<?=($regiao == '939')?'selected':'' ?>	>	939	ª Região	</option>
                    <option value="940	"	<?=($regiao == '940')?'selected':'' ?>	>	940	ª Região	</option>
                    <option value="941	"	<?=($regiao == '941')?'selected':'' ?>	>	941	ª Região	</option>
                    <option value="942	"	<?=($regiao == '942')?'selected':'' ?>	>	942	ª Região	</option>
                    <option value="943	"	<?=($regiao == '943')?'selected':'' ?>	>	943	ª Região	</option>
                    <option value="944	"	<?=($regiao == '944')?'selected':'' ?>	>	944	ª Região	</option>
                    <option value="945	"	<?=($regiao == '945')?'selected':'' ?>	>	945	ª Região	</option>
                    <option value="946	"	<?=($regiao == '946')?'selected':'' ?>	>	946	ª Região	</option>
                    <option value="947	"	<?=($regiao == '947')?'selected':'' ?>	>	947	ª Região	</option>
                    <option value="948	"	<?=($regiao == '948')?'selected':'' ?>	>	948	ª Região	</option>
                    <option value="949	"	<?=($regiao == '949')?'selected':'' ?>	>	949	ª Região	</option>
                    <option value="950	"	<?=($regiao == '950')?'selected':'' ?>	>	950	ª Região	</option>
                    <option value="951	"	<?=($regiao == '951')?'selected':'' ?>	>	951	ª Região	</option>
                    <option value="952	"	<?=($regiao == '952')?'selected':'' ?>	>	952	ª Região	</option>
                    <option value="953	"	<?=($regiao == '953')?'selected':'' ?>	>	953	ª Região	</option>
                    <option value="954	"	<?=($regiao == '954')?'selected':'' ?>	>	954	ª Região	</option>
                    <option value="955	"	<?=($regiao == '955')?'selected':'' ?>	>	955	ª Região	</option>
                    <option value="956	"	<?=($regiao == '956')?'selected':'' ?>	>	956	ª Região	</option>
                    <option value="957	"	<?=($regiao == '957')?'selected':'' ?>	>	957	ª Região	</option>
                    <option value="958	"	<?=($regiao == '958')?'selected':'' ?>	>	958	ª Região	</option>
                    <option value="959	"	<?=($regiao == '959')?'selected':'' ?>	>	959	ª Região	</option>
                    <option value="960	"	<?=($regiao == '960')?'selected':'' ?>	>	960	ª Região	</option>
                    <option value="961	"	<?=($regiao == '961')?'selected':'' ?>	>	961	ª Região	</option>
                    <option value="962	"	<?=($regiao == '962')?'selected':'' ?>	>	962	ª Região	</option>
                    <option value="963	"	<?=($regiao == '963')?'selected':'' ?>	>	963	ª Região	</option>
                    <option value="964	"	<?=($regiao == '964')?'selected':'' ?>	>	964	ª Região	</option>
                    <option value="965	"	<?=($regiao == '965')?'selected':'' ?>	>	965	ª Região	</option>
                    <option value="966	"	<?=($regiao == '966')?'selected':'' ?>	>	966	ª Região	</option>
                    <option value="	967	"	<?=($regiao == '967')?'selected':'' ?>	>	967	ª Região	</option>
                    <option value="968	"	<?=($regiao == '968')?'selected':'' ?>	>	968	ª Região	</option>
                    <option value="969	"	<?=($regiao == '969')?'selected':'' ?>	>	969	ª Região	</option>
                    <option value="970	"	<?=($regiao == '970')?'selected':'' ?>	>	970	ª Região	</option>
                    <option value="971	"	<?=($regiao == '971')?'selected':'' ?>	>	971	ª Região	</option>
                    <option value="972	"	<?=($regiao == '972')?'selected':'' ?>	>	972	ª Região	</option>
                    <option value="973	"	<?=($regiao == '973')?'selected':'' ?>	>	973	ª Região	</option>
                    <option value="974	"	<?=($regiao == '974')?'selected':'' ?>	>	974	ª Região	</option>
                    <option value="975	"	<?=($regiao == '975')?'selected':'' ?>	>	975	ª Região	</option>
                    <option value="976	"	<?=($regiao == '976')?'selected':'' ?>	>	976	ª Região	</option>
                    <option value="977	"	<?=($regiao == '977')?'selected':'' ?>	>	977	ª Região	</option>
                    <option value="978	"	<?=($regiao == '978')?'selected':'' ?>	>	978	ª Região	</option>
                    <option value="979	"	<?=($regiao == '979')?'selected':'' ?>	>	979	ª Região	</option>
                    <option value="980"	<?=($regiao == '980')?'selected':'' ?>>980ª Região</option>
                    <option value="981"	<?=($regiao == '981')?'selected':'' ?>>981ª Região</option>
                    <option value="982"	<?=($regiao == '982')?'selected':'' ?>>982ª Região</option>
                    <option value="983"	<?=($regiao == '983')?'selected':'' ?>>983ª Região</option>
                    <option value="984"	<?=($regiao == '984')?'selected':'' ?>>984ª Região</option>
                    <option value="985"	<?=($regiao == '985')?'selected':'' ?>>985ª Região</option>
                    <option value="986"<?=($regiao == '986')?'selected':''?>>986ª Região</option>
                    <option value="987"<?=($regiao == '987')?'selected':''?>>987ª Região</option>
                    <option value="988"<?=($regiao == '988')?'selected':''?>>988ª Região</option>
                    <option value="989"<?=($regiao == '989')?'selected':''?>>989ª Região</option>
                    <option value="990"<?=($regiao == '990')?'selected':''?>>990ª Região</option>
                    <option value="991"<?=($regiao == '991')?'selected':''?>>991ª Região</option>
                    <option value="992"<?=($regiao == '992')?'selected':''?>>992ª Região</option>
                    <option value="993"<?=($regiao == '993')?'selected':''?>>993ª Região</option>
                    <option value="994"<?=($regiao == '994')?'selected':''?>>994ª Região</option>
                    <option value="995"<?=($regiao == '995')?'selected':''?>>995ª Região</option>
                    <option value="996"<?=($regiao == '996')?'selected':''?>>996ª Região</option>
                    <option value="997"<?=($regiao == '997')?'selected':''?>>997ª Região</option>
                    <option value="998"<?=($regiao == '998')?'selected':''?>>998ª Região</option>
                    <option value="999"<?=($regiao == '999')?'selected':''?>>999ª Região</option>
                    <option value="1000"<?=($regiao == '1000')?'selected':''?>>1000ª Região</option>
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
