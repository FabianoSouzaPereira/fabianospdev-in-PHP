<?php

use modulos\Igreja;
use application\functions\Validador;

require 'init.php';
include_once 'modulos/Igreja.php';
include_once 'functions/Validador.php';
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
    $logtipo=null;
	$logtipo=$_SESSION['tipo'];
    
    switch ($logtipo) {
                case 1: $igr->insert();
                   break;
                case 2: $igr->coordenadorInsert();
                   break;
                case 3: $igr->PastorInsert();
                   break;
                case 4: $igr->liderInsert();
                   break;
                case 5: $igr->colaboradorInsert();
                   break;
                case 6: $igr->comumInsert();;
                   break;
                case 7: '0';
                   break;
                default:
                    ;
                break;
            }
    
    $igr->insert=FALSE;
    $igr= NULL;
    
    header( "Location: index.php?pag=site_view_churchReadView" );
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
	<a href="index.php?pag=site_view_churchReadView" id="voltar"  class="btn btn-primary btn-voltar"><span class="glyphicon glyphicon-chevron-left"></span> Voltar</a>
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
		<label>Região</label> <select id="regiao" name="chuRegiao" class="form-control" required>
			<option value="1" selected>1° Região</option>
			<option value="2">2° Região</option>
			<option value="3">3° Região</option>
			<option value="4">4° Região</option>
			<option value="5">5° Região</option>
			<option value="6">6° Região</option>
			<option value="7">7ª Região</option>
			<option value="8">8ª Região</option>
			<option value="9">9ª Região</option>
			<option value="10">10ª Região</option>
			<option value="11">11ª Região</option>
			<option value="12">12ª Região</option>
			<option value="13">13ª Região</option>
			<option value="14">14ª Região</option>
			<option value="15">15ª Região</option>
			<option value="16">16ª Região</option>
			<option value="17">18ª Região</option>
			<option value="19">19ª Região</option>
			<option value="20">20ª Região</option>
			<option value="21">21ª Região</option>
			<option value="22">22ª Região</option>
			<option value="23">23ª Região</option>
			<option value="24">24ª Região</option>
			<option value="25">25ª Região</option>
			<option value="26">26ª Região</option>
			<option value="27">27ª Região</option>
			<option value="28">28ª Região</option>
			<option value="29">29ª Região</option>
			<option value="30">30ª Região</option>
			<option value="31">31ª Região</option>
			<option value="32">32ª Região</option>
			<option value="33">33ª Região</option>
			<option value="34">34ª Região</option>
			<option value="35">35ª Região</option>
			<option value="36">36ª Região</option>
			<option value="37">37ª Região</option>
			<option value="38">38ª Região</option>
			<option value="39">39ª Região</option>
			<option value="40">40ª Região</option>
			<option value="41">41ª Região</option>
			<option value="42">42ª Região</option>
			<option value="43">43ª Região</option>
			<option value="44">44ª Região</option>
			<option value="45">45ª Região</option>
			<option value="46">46ª Região</option>
			<option value="47">47ª Região</option>
			<option value="48">48ª Região</option>
			<option value="49">49ª Região</option>
			<option value="50">50ª Região</option>
			<option value="51">51ª Região</option>
			<option value="52">52ª Região</option>
			<option value="53">53ª Região</option>
			<option value="54">54ª Região</option>
			<option value="55">55ª Região</option>
			<option value="56">56ª Região</option>
			<option value="57">57ª Região</option>
			<option value="58">58ª Região</option>
			<option value="59">59ª Região</option>
			<option value="60">60ª Região</option>
			<option value="61">61ª Região</option>
			<option value="62">62ª Região</option>
			<option value="63">63ª Região</option>
			<option value="64">64ª Região</option>
            <option value="	65	">	65	ª Região	</option>
            <option value="	66	">	66	ª Região	</option>
            <option value="	67	">	67	ª Região	</option>
            <option value="	68	">	68	ª Região	</option>
            <option value="	69	">	69	ª Região	</option>
            <option value="	70	">	70	ª Região	</option>
            <option value="	71	">	71	ª Região	</option>
            <option value="	72	">	72	ª Região	</option>
            <option value="	73	">	73	ª Região	</option>
            <option value="	74	">	74	ª Região	</option>
            <option value="	75	">	75	ª Região	</option>
            <option value="	76	">	76	ª Região	</option>
            <option value="	77	">	77	ª Região	</option>
            <option value="	78	">	78	ª Região	</option>
            <option value="	79	">	79	ª Região	</option>
            <option value="	80	">	80	ª Região	</option>
            <option value="	81	">	81	ª Região	</option>
            <option value="	82	">	82	ª Região	</option>
            <option value="	83	">	83	ª Região	</option>
            <option value="	84	">	84	ª Região	</option>
            <option value="	85	">	85	ª Região	</option>
            <option value="	86	">	86	ª Região	</option>
            <option value="	87	">	87	ª Região	</option>
            <option value="	88	">	88	ª Região	</option>
            <option value="	89	">	89	ª Região	</option>
            <option value="	90	">	90	ª Região	</option>
            <option value="	91	">	91	ª Região	</option>
            <option value="	92	">	92	ª Região	</option>
            <option value="	93	">	93	ª Região	</option>
            <option value="	94	">	94	ª Região	</option>
            <option value="	95	">	95	ª Região	</option>
            <option value="	96	">	96	ª Região	</option>
            <option value="	97	">	97	ª Região	</option>
            <option value="	98	">	98	ª Região	</option>
            <option value="	99	">	99	ª Região	</option>
            <option value="	100	">	100	ª Região	</option>
            <option value="	101	">	101	ª Região	</option>
            <option value="	102	">	102	ª Região	</option>
            <option value="	103	">	103	ª Região	</option>
            <option value="	104	">	104	ª Região	</option>
            <option value="	105	">	105	ª Região	</option>
            <option value="	106	">	106	ª Região	</option>
            <option value="	107	">	107	ª Região	</option>
            <option value="	108	">	108	ª Região	</option>
            <option value="	109	">	109	ª Região	</option>
            <option value="	110	">	110	ª Região	</option>
            <option value="	111	">	111	ª Região	</option>
            <option value="	112	">	112	ª Região	</option>
            <option value="	113	">	113	ª Região	</option>
            <option value="	114	">	114	ª Região	</option>
            <option value="	115	">	115	ª Região	</option>
            <option value="	116	">	116	ª Região	</option>
            <option value="	117	">	117	ª Região	</option>
            <option value="	118	">	118	ª Região	</option>
            <option value="	119	">	119	ª Região	</option>
            <option value="	120	">	120	ª Região	</option>
            <option value="	121	">	121	ª Região	</option>
            <option value="	122	">	122	ª Região	</option>
            <option value="	123	">	123	ª Região	</option>
            <option value="	124	">	124	ª Região	</option>
            <option value="	125	">	125	ª Região	</option>
            <option value="	126	">	126	ª Região	</option>
            <option value="	127	">	127	ª Região	</option>
            <option value="	128	">	128	ª Região	</option>
            <option value="	129	">	129	ª Região	</option>
            <option value="	130	">	130	ª Região	</option>
            <option value="	131	">	131	ª Região	</option>
            <option value="	132	">	132	ª Região	</option>
            <option value="	133	">	133	ª Região	</option>
            <option value="	134	">	134	ª Região	</option>
            <option value="	135	">	135	ª Região	</option>
            <option value="	136	">	136	ª Região	</option>
            <option value="	137	">	137	ª Região	</option>
            <option value="	138	">	138	ª Região	</option>
            <option value="	139	">	139	ª Região	</option>
            <option value="	140	">	140	ª Região	</option>
            <option value="	141	">	141	ª Região	</option>
            <option value="	142	">	142	ª Região	</option>
            <option value="	143	">	143	ª Região	</option>
            <option value="	144	">	144	ª Região	</option>
            <option value="	145	">	145	ª Região	</option>
            <option value="	146	">	146	ª Região	</option>
            <option value="	147	">	147	ª Região	</option>
            <option value="	148	">	148	ª Região	</option>
            <option value="	149	">	149	ª Região	</option>
            <option value="	150	">	150	ª Região	</option>
            <option value="	151	">	151	ª Região	</option>
            <option value="	152	">	152	ª Região	</option>
            <option value="	153	">	153	ª Região	</option>
            <option value="	154	">	154	ª Região	</option>
            <option value="	155	">	155	ª Região	</option>
            <option value="	156	">	156	ª Região	</option>
            <option value="	157	">	157	ª Região	</option>
            <option value="	158	">	158	ª Região	</option>
            <option value="	159	">	159	ª Região	</option>
            <option value="	160	">	160	ª Região	</option>
            <option value="	161	">	161	ª Região	</option>
            <option value="	162	">	162	ª Região	</option>
            <option value="	163	">	163	ª Região	</option>
            <option value="	164	">	164	ª Região	</option>
            <option value="	165	">	165	ª Região	</option>
            <option value="	166	">	166	ª Região	</option>
            <option value="	167	">	167	ª Região	</option>
            <option value="	168	">	168	ª Região	</option>
            <option value="	169	">	169	ª Região	</option>
            <option value="	170	">	170	ª Região	</option>
            <option value="	171	">	171	ª Região	</option>
            <option value="	172	">	172	ª Região	</option>
            <option value="	173	">	173	ª Região	</option>
            <option value="	174	">	174	ª Região	</option>
            <option value="	175	">	175	ª Região	</option>
            <option value="	176	">	176	ª Região	</option>
            <option value="	177	">	177	ª Região	</option>
            <option value="	178	">	178	ª Região	</option>
            <option value="	179	">	179	ª Região	</option>
            <option value="	180	">	180	ª Região	</option>
            <option value="	181	">	181	ª Região	</option>
            <option value="	182	">	182	ª Região	</option>
            <option value="	183	">	183	ª Região	</option>
            <option value="	184	">	184	ª Região	</option>
            <option value="	185	">	185	ª Região	</option>
            <option value="	186	">	186	ª Região	</option>
            <option value="	187	">	187	ª Região	</option>
            <option value="	188	">	188	ª Região	</option>
            <option value="	189	">	189	ª Região	</option>
            <option value="	190	">	190	ª Região	</option>
            <option value="	191	">	191	ª Região	</option>
            <option value="	192	">	192	ª Região	</option>
            <option value="	193	">	193	ª Região	</option>
            <option value="	194	">	194	ª Região	</option>
            <option value="	195	">	195	ª Região	</option>
            <option value="	196	">	196	ª Região	</option>
            <option value="	197	">	197	ª Região	</option>
            <option value="	198	">	198	ª Região	</option>
            <option value="	199	">	199	ª Região	</option>
            <option value="	200	">	200	ª Região	</option>
            <option value="	201	">	201	ª Região	</option>
            <option value="	202	">	202	ª Região	</option>
            <option value="	203	">	203	ª Região	</option>
            <option value="	204	">	204	ª Região	</option>
            <option value="	205	">	205	ª Região	</option>
            <option value="	206	">	206	ª Região	</option>
            <option value="	207	">	207	ª Região	</option>
            <option value="	208	">	208	ª Região	</option>
            <option value="	209	">	209	ª Região	</option>
            <option value="	210	">	210	ª Região	</option>
            <option value="	211	">	211	ª Região	</option>
            <option value="	212	">	212	ª Região	</option>
            <option value="	213	">	213	ª Região	</option>
            <option value="	214	">	214	ª Região	</option>
            <option value="	215	">	215	ª Região	</option>
            <option value="	216	">	216	ª Região	</option>
            <option value="	217	">	217	ª Região	</option>
            <option value="	218	">	218	ª Região	</option>
            <option value="	219	">	219	ª Região	</option>
            <option value="	220	">	220	ª Região	</option>
            <option value="	221	">	221	ª Região	</option>
            <option value="	222	">	222	ª Região	</option>
            <option value="	223	">	223	ª Região	</option>
            <option value="	224	">	224	ª Região	</option>
            <option value="	225	">	225	ª Região	</option>
            <option value="	226	">	226	ª Região	</option>
            <option value="	227	">	227	ª Região	</option>
            <option value="	228	">	228	ª Região	</option>
            <option value="	229	">	229	ª Região	</option>
            <option value="	230	">	230	ª Região	</option>
            <option value="	231	">	231	ª Região	</option>
            <option value="	232	">	232	ª Região	</option>
            <option value="	233	">	233	ª Região	</option>
            <option value="	234	">	234	ª Região	</option>
            <option value="	235	">	235	ª Região	</option>
            <option value="	236	">	236	ª Região	</option>
            <option value="	237	">	237	ª Região	</option>
            <option value="	238	">	238	ª Região	</option>
            <option value="	239	">	239	ª Região	</option>
            <option value="	240	">	240	ª Região	</option>
            <option value="	241	">	241	ª Região	</option>
            <option value="	242	">	242	ª Região	</option>
            <option value="	243	">	243	ª Região	</option>
            <option value="	244	">	244	ª Região	</option>
            <option value="	245	">	245	ª Região	</option>
            <option value="	246	">	246	ª Região	</option>
            <option value="	247	">	247	ª Região	</option>
            <option value="	248	">	248	ª Região	</option>
            <option value="	249	">	249	ª Região	</option>
            <option value="	250	">	250	ª Região	</option>
            <option value="	251	">	251	ª Região	</option>
            <option value="	252	">	252	ª Região	</option>
            <option value="	253	">	253	ª Região	</option>
            <option value="	254	">	254	ª Região	</option>
            <option value="	255	">	255	ª Região	</option>
            <option value="	256	">	256	ª Região	</option>
            <option value="	257	">	257	ª Região	</option>
            <option value="	258	">	258	ª Região	</option>
            <option value="	259	">	259	ª Região	</option>
            <option value="	260	">	260	ª Região	</option>
            <option value="	261	">	261	ª Região	</option>
            <option value="	262	">	262	ª Região	</option>
            <option value="	263	">	263	ª Região	</option>
            <option value="	264	">	264	ª Região	</option>
            <option value="	265	">	265	ª Região	</option>
            <option value="	266	">	266	ª Região	</option>
            <option value="	267	">	267	ª Região	</option>
            <option value="	268	">	268	ª Região	</option>
            <option value="	269	">	269	ª Região	</option>
            <option value="	270	">	270	ª Região	</option>
            <option value="	271	">	271	ª Região	</option>
            <option value="	272	">	272	ª Região	</option>
            <option value="	273	">	273	ª Região	</option>
            <option value="	274	">	274	ª Região	</option>
            <option value="	275	">	275	ª Região	</option>
            <option value="	276	">	276	ª Região	</option>
            <option value="	277	">	277	ª Região	</option>
            <option value="	278	">	278	ª Região	</option>
            <option value="	279	">	279	ª Região	</option>
            <option value="	280	">	280	ª Região	</option>
            <option value="	281	">	281	ª Região	</option>
            <option value="	282	">	282	ª Região	</option>
            <option value="	283	">	283	ª Região	</option>
            <option value="	284	">	284	ª Região	</option>
            <option value="	285	">	285	ª Região	</option>
            <option value="	286	">	286	ª Região	</option>
            <option value="	287	">	287	ª Região	</option>
            <option value="	288	">	288	ª Região	</option>
            <option value="	289	">	289	ª Região	</option>
            <option value="	290	">	290	ª Região	</option>
            <option value="	291	">	291	ª Região	</option>
            <option value="	292	">	292	ª Região	</option>
            <option value="	293	">	293	ª Região	</option>
            <option value="	294	">	294	ª Região	</option>
            <option value="	295	">	295	ª Região	</option>
            <option value="	296	">	296	ª Região	</option>
            <option value="	297	">	297	ª Região	</option>
            <option value="	298	">	298	ª Região	</option>
            <option value="	299	">	299	ª Região	</option>
            <option value="	300	">	300	ª Região	</option>
            <option value="	301	">	301	ª Região	</option>
            <option value="	302	">	302	ª Região	</option>
            <option value="	303	">	303	ª Região	</option>
            <option value="	304	">	304	ª Região	</option>
            <option value="	305	">	305	ª Região	</option>
            <option value="	306	">	306	ª Região	</option>
            <option value="	307	">	307	ª Região	</option>
            <option value="	308	">	308	ª Região	</option>
            <option value="	309	">	309	ª Região	</option>
            <option value="	310	">	310	ª Região	</option>
            <option value="	311	">	311	ª Região	</option>
            <option value="	312	">	312	ª Região	</option>
            <option value="	313	">	313	ª Região	</option>
            <option value="	314	">	314	ª Região	</option>
            <option value="	315	">	315	ª Região	</option>
            <option value="	316	">	316	ª Região	</option>
            <option value="	317	">	317	ª Região	</option>
            <option value="	318	">	318	ª Região	</option>
            <option value="	319	">	319	ª Região	</option>
            <option value="	320	">	320	ª Região	</option>
            <option value="	321	">	321	ª Região	</option>
            <option value="	322	">	322	ª Região	</option>
            <option value="	323	">	323	ª Região	</option>
            <option value="	324	">	324	ª Região	</option>
            <option value="	325	">	325	ª Região	</option>
            <option value="	326	">	326	ª Região	</option>
            <option value="	327	">	327	ª Região	</option>
            <option value="	328	">	328	ª Região	</option>
            <option value="	329	">	329	ª Região	</option>
            <option value="	330	">	330	ª Região	</option>
            <option value="	331	">	331	ª Região	</option>
            <option value="	332	">	332	ª Região	</option>
            <option value="	333	">	333	ª Região	</option>
            <option value="	334	">	334	ª Região	</option>
            <option value="	335	">	335	ª Região	</option>
            <option value="	336	">	336	ª Região	</option>
            <option value="	337	">	337	ª Região	</option>
            <option value="	338	">	338	ª Região	</option>
            <option value="	339	">	339	ª Região	</option>
            <option value="	340	">	340	ª Região	</option>
            <option value="	341	">	341	ª Região	</option>
            <option value="	342	">	342	ª Região	</option>
            <option value="	343	">	343	ª Região	</option>
            <option value="	344	">	344	ª Região	</option>
            <option value="	345	">	345	ª Região	</option>
            <option value="	346	">	346	ª Região	</option>
            <option value="	347	">	347	ª Região	</option>
            <option value="	348	">	348	ª Região	</option>
            <option value="	349	">	349	ª Região	</option>
            <option value="	350	">	350	ª Região	</option>
            <option value="	351	">	351	ª Região	</option>
            <option value="	352	">	352	ª Região	</option>
            <option value="	353	">	353	ª Região	</option>
            <option value="	354	">	354	ª Região	</option>
            <option value="	355	">	355	ª Região	</option>
            <option value="	356	">	356	ª Região	</option>
            <option value="	357	">	357	ª Região	</option>
            <option value="	358	">	358	ª Região	</option>
            <option value="	359	">	359	ª Região	</option>
            <option value="	360	">	360	ª Região	</option>
            <option value="	361	">	361	ª Região	</option>
            <option value="	362	">	362	ª Região	</option>
            <option value="	363	">	363	ª Região	</option>
            <option value="	364	">	364	ª Região	</option>
            <option value="	365	">	365	ª Região	</option>
            <option value="	366	">	366	ª Região	</option>
            <option value="	367	">	367	ª Região	</option>
            <option value="	368	">	368	ª Região	</option>
            <option value="	369	">	369	ª Região	</option>
            <option value="	370	">	370	ª Região	</option>
            <option value="	371	">	371	ª Região	</option>
            <option value="	372	">	372	ª Região	</option>
            <option value="	373	">	373	ª Região	</option>
            <option value="	374	">	374	ª Região	</option>
            <option value="	375	">	375	ª Região	</option>
            <option value="	376	">	376	ª Região	</option>
            <option value="	377	">	377	ª Região	</option>
            <option value="	378	">	378	ª Região	</option>
            <option value="	379	">	379	ª Região	</option>
            <option value="	380	">	380	ª Região	</option>
            <option value="	381	">	381	ª Região	</option>
            <option value="	382	">	382	ª Região	</option>
            <option value="	383	">	383	ª Região	</option>
            <option value="	384	">	384	ª Região	</option>
            <option value="	385	">	385	ª Região	</option>
            <option value="	386	">	386	ª Região	</option>
            <option value="	387	">	387	ª Região	</option>
            <option value="	388	">	388	ª Região	</option>
            <option value="	389	">	389	ª Região	</option>
            <option value="	390	">	390	ª Região	</option>
            <option value="	391	">	391	ª Região	</option>
            <option value="	392	">	392	ª Região	</option>
            <option value="	393	">	393	ª Região	</option>
            <option value="	394	">	394	ª Região	</option>
            <option value="	395	">	395	ª Região	</option>
            <option value="	396	">	396	ª Região	</option>
            <option value="	397	">	397	ª Região	</option>
            <option value="	398	">	398	ª Região	</option>
            <option value="	399	">	399	ª Região	</option>
            <option value="	400	">	400	ª Região	</option>
            <option value="	401	">	401	ª Região	</option>
            <option value="	402	">	402	ª Região	</option>
            <option value="	403	">	403	ª Região	</option>
            <option value="	404	">	404	ª Região	</option>
            <option value="	405	">	405	ª Região	</option>
            <option value="	406	">	406	ª Região	</option>
            <option value="	407	">	407	ª Região	</option>
            <option value="	408	">	408	ª Região	</option>
            <option value="	409	">	409	ª Região	</option>
            <option value="	410	">	410	ª Região	</option>
            <option value="	411	">	411	ª Região	</option>
            <option value="	412	">	412	ª Região	</option>
            <option value="	413	">	413	ª Região	</option>
            <option value="	414	">	414	ª Região	</option>
            <option value="	415	">	415	ª Região	</option>
            <option value="	416	">	416	ª Região	</option>
            <option value="	417	">	417	ª Região	</option>
            <option value="	418	">	418	ª Região	</option>
            <option value="	419	">	419	ª Região	</option>
            <option value="	420	">	420	ª Região	</option>
            <option value="	421	">	421	ª Região	</option>
            <option value="	422	">	422	ª Região	</option>
            <option value="	423	">	423	ª Região	</option>
            <option value="	424	">	424	ª Região	</option>
            <option value="	425	">	425	ª Região	</option>
            <option value="	426	">	426	ª Região	</option>
            <option value="	427	">	427	ª Região	</option>
            <option value="	428	">	428	ª Região	</option>
            <option value="	429	">	429	ª Região	</option>
            <option value="	430	">	430	ª Região	</option>
            <option value="	431	">	431	ª Região	</option>
            <option value="	432	">	432	ª Região	</option>
            <option value="	433	">	433	ª Região	</option>
            <option value="	434	">	434	ª Região	</option>
            <option value="	435	">	435	ª Região	</option>
            <option value="	436	">	436	ª Região	</option>
            <option value="	437	">	437	ª Região	</option>
            <option value="	438	">	438	ª Região	</option>
            <option value="	439	">	439	ª Região	</option>
            <option value="	440	">	440	ª Região	</option>
            <option value="	441	">	441	ª Região	</option>
            <option value="	442	">	442	ª Região	</option>
            <option value="	443	">	443	ª Região	</option>
            <option value="	444	">	444	ª Região	</option>
            <option value="	445	">	445	ª Região	</option>
            <option value="	446	">	446	ª Região	</option>
            <option value="	447	">	447	ª Região	</option>
            <option value="	448	">	448	ª Região	</option>
            <option value="	449	">	449	ª Região	</option>
            <option value="	450	">	450	ª Região	</option>
            <option value="	451	">	451	ª Região	</option>
            <option value="	452	">	452	ª Região	</option>
            <option value="	453	">	453	ª Região	</option>
            <option value="	454	">	454	ª Região	</option>
            <option value="	455	">	455	ª Região	</option>
            <option value="	456	">	456	ª Região	</option>
            <option value="	457	">	457	ª Região	</option>
            <option value="	458	">	458	ª Região	</option>
            <option value="	459	">	459	ª Região	</option>
            <option value="	460	">	460	ª Região	</option>
            <option value="	461	">	461	ª Região	</option>
            <option value="	462	">	462	ª Região	</option>
            <option value="	463	">	463	ª Região	</option>
            <option value="	464	">	464	ª Região	</option>
            <option value="	465	">	465	ª Região	</option>
            <option value="	466	">	466	ª Região	</option>
            <option value="	467	">	467	ª Região	</option>
            <option value="	468	">	468	ª Região	</option>
            <option value="	469	">	469	ª Região	</option>
            <option value="	470	">	470	ª Região	</option>
            <option value="	471	">	471	ª Região	</option>
            <option value="	472	">	472	ª Região	</option>
            <option value="	473	">	473	ª Região	</option>
            <option value="	474	">	474	ª Região	</option>
            <option value="	475	">	475	ª Região	</option>
            <option value="	476	">	476	ª Região	</option>
            <option value="	477	">	477	ª Região	</option>
            <option value="	478	">	478	ª Região	</option>
            <option value="	479	">	479	ª Região	</option>
            <option value="	480	">	480	ª Região	</option>
            <option value="	481	">	481	ª Região	</option>
            <option value="	482	">	482	ª Região	</option>
            <option value="	483	">	483	ª Região	</option>
            <option value="	484	">	484	ª Região	</option>
            <option value="	485	">	485	ª Região	</option>
            <option value="	486	">	486	ª Região	</option>
            <option value="	487	">	487	ª Região	</option>
            <option value="	488	">	488	ª Região	</option>
            <option value="	489	">	489	ª Região	</option>
            <option value="	490	">	490	ª Região	</option>
            <option value="	491	">	491	ª Região	</option>
            <option value="	492	">	492	ª Região	</option>
            <option value="	493	">	493	ª Região	</option>
            <option value="	494	">	494	ª Região	</option>
            <option value="	495	">	495	ª Região	</option>
            <option value="	496	">	496	ª Região	</option>
            <option value="	497	">	497	ª Região	</option>
            <option value="	498	">	498	ª Região	</option>
            <option value="	499	">	499	ª Região	</option>
            <option value="	500	">	500	ª Região	</option>
            <option value="	501	">	501	ª Região	</option>
            <option value="	502	">	502	ª Região	</option>
            <option value="	503	">	503	ª Região	</option>
            <option value="	504	">	504	ª Região	</option>
            <option value="	505	">	505	ª Região	</option>
            <option value="	506	">	506	ª Região	</option>
            <option value="	507	">	507	ª Região	</option>
            <option value="	508	">	508	ª Região	</option>
            <option value="	509	">	509	ª Região	</option>
            <option value="	510	">	510	ª Região	</option>
            <option value="	511	">	511	ª Região	</option>
            <option value="	512	">	512	ª Região	</option>
            <option value="	513	">	513	ª Região	</option>
            <option value="	514	">	514	ª Região	</option>
            <option value="	515	">	515	ª Região	</option>
            <option value="	516	">	516	ª Região	</option>
            <option value="	517	">	517	ª Região	</option>
            <option value="	518	">	518	ª Região	</option>
            <option value="	519	">	519	ª Região	</option>
            <option value="	520	">	520	ª Região	</option>
            <option value="	521	">	521	ª Região	</option>
            <option value="	522	">	522	ª Região	</option>
            <option value="	523	">	523	ª Região	</option>
            <option value="	524	">	524	ª Região	</option>
            <option value="	525	">	525	ª Região	</option>
            <option value="	526	">	526	ª Região	</option>
            <option value="	527	">	527	ª Região	</option>
            <option value="	528	">	528	ª Região	</option>
            <option value="	529	">	529	ª Região	</option>
            <option value="	530	">	530	ª Região	</option>
            <option value="	531	">	531	ª Região	</option>
            <option value="	532	">	532	ª Região	</option>
            <option value="	533	">	533	ª Região	</option>
            <option value="	534	">	534	ª Região	</option>
            <option value="	535	">	535	ª Região	</option>
            <option value="	536	">	536	ª Região	</option>
            <option value="	537	">	537	ª Região	</option>
            <option value="	538	">	538	ª Região	</option>
            <option value="	539	">	539	ª Região	</option>
            <option value="	540	">	540	ª Região	</option>
            <option value="	541	">	541	ª Região	</option>
            <option value="	542	">	542	ª Região	</option>
            <option value="	543	">	543	ª Região	</option>
            <option value="	544	">	544	ª Região	</option>
            <option value="	545	">	545	ª Região	</option>
            <option value="	546	">	546	ª Região	</option>
            <option value="	547	">	547	ª Região	</option>
            <option value="	548	">	548	ª Região	</option>
            <option value="	549	">	549	ª Região	</option>
            <option value="	550	">	550	ª Região	</option>
            <option value="	551	">	551	ª Região	</option>
            <option value="	552	">	552	ª Região	</option>
            <option value="	553	">	553	ª Região	</option>
            <option value="	554	">	554	ª Região	</option>
            <option value="	555	">	555	ª Região	</option>
            <option value="	556	">	556	ª Região	</option>
            <option value="	557	">	557	ª Região	</option>
            <option value="	558	">	558	ª Região	</option>
            <option value="	559	">	559	ª Região	</option>
            <option value="	560	">	560	ª Região	</option>
            <option value="	561	">	561	ª Região	</option>
            <option value="	562	">	562	ª Região	</option>
            <option value="	563	">	563	ª Região	</option>
            <option value="	564	">	564	ª Região	</option>
            <option value="	565	">	565	ª Região	</option>
            <option value="	566	">	566	ª Região	</option>
            <option value="	567	">	567	ª Região	</option>
            <option value="	568	">	568	ª Região	</option>
            <option value="	569	">	569	ª Região	</option>
            <option value="	570	">	570	ª Região	</option>
            <option value="	571	">	571	ª Região	</option>
            <option value="	572	">	572	ª Região	</option>
            <option value="	573	">	573	ª Região	</option>
            <option value="	574	">	574	ª Região	</option>
            <option value="	575	">	575	ª Região	</option>
            <option value="	576	">	576	ª Região	</option>
            <option value="	577	">	577	ª Região	</option>
            <option value="	578	">	578	ª Região	</option>
            <option value="	579	">	579	ª Região	</option>
            <option value="	580	">	580	ª Região	</option>
            <option value="	581	">	581	ª Região	</option>
            <option value="	582	">	582	ª Região	</option>
            <option value="	583	">	583	ª Região	</option>
            <option value="	584	">	584	ª Região	</option>
            <option value="	585	">	585	ª Região	</option>
            <option value="	586	">	586	ª Região	</option>
            <option value="	587	">	587	ª Região	</option>
            <option value="	588	">	588	ª Região	</option>
            <option value="	589	">	589	ª Região	</option>
            <option value="	590	">	590	ª Região	</option>
            <option value="	591	">	591	ª Região	</option>
            <option value="	592	">	592	ª Região	</option>
            <option value="	593	">	593	ª Região	</option>
            <option value="	594	">	594	ª Região	</option>
            <option value="	595	">	595	ª Região	</option>
            <option value="	596	">	596	ª Região	</option>
            <option value="	597	">	597	ª Região	</option>
            <option value="	598	">	598	ª Região	</option>
            <option value="	599	">	599	ª Região	</option>
            <option value="	600	">	600	ª Região	</option>
            <option value="	601	">	601	ª Região	</option>
            <option value="	602	">	602	ª Região	</option>
            <option value="	603	">	603	ª Região	</option>
            <option value="	604	">	604	ª Região	</option>
            <option value="	605	">	605	ª Região	</option>
            <option value="	606	">	606	ª Região	</option>
            <option value="	607	">	607	ª Região	</option>
            <option value="	608	">	608	ª Região	</option>
            <option value="	609	">	609	ª Região	</option>
            <option value="	610	">	610	ª Região	</option>
            <option value="	611	">	611	ª Região	</option>
            <option value="	612	">	612	ª Região	</option>
            <option value="	613	">	613	ª Região	</option>
            <option value="	614	">	614	ª Região	</option>
            <option value="	615	">	615	ª Região	</option>
            <option value="	616	">	616	ª Região	</option>
            <option value="	617	">	617	ª Região	</option>
            <option value="	618	">	618	ª Região	</option>
            <option value="	619	">	619	ª Região	</option>
            <option value="	620	">	620	ª Região	</option>
            <option value="	621	">	621	ª Região	</option>
            <option value="	622	">	622	ª Região	</option>
            <option value="	623	">	623	ª Região	</option>
            <option value="	624	">	624	ª Região	</option>
            <option value="	625	">	625	ª Região	</option>
            <option value="	626	">	626	ª Região	</option>
            <option value="	627	">	627	ª Região	</option>
            <option value="	628	">	628	ª Região	</option>
            <option value="	629	">	629	ª Região	</option>
            <option value="	630	">	630	ª Região	</option>
            <option value="	631	">	631	ª Região	</option>
            <option value="	632	">	632	ª Região	</option>
            <option value="	633	">	633	ª Região	</option>
            <option value="	634	">	634	ª Região	</option>
            <option value="	635	">	635	ª Região	</option>
            <option value="	636	">	636	ª Região	</option>
            <option value="	637	">	637	ª Região	</option>
            <option value="	638	">	638	ª Região	</option>
            <option value="	639	">	639	ª Região	</option>
            <option value="	640	">	640	ª Região	</option>
            <option value="	641	">	641	ª Região	</option>
            <option value="	642	">	642	ª Região	</option>
            <option value="	643	">	643	ª Região	</option>
            <option value="	644	">	644	ª Região	</option>
            <option value="	645	">	645	ª Região	</option>
            <option value="	646	">	646	ª Região	</option>
            <option value="	647	">	647	ª Região	</option>
            <option value="	648	">	648	ª Região	</option>
            <option value="	649	">	649	ª Região	</option>
            <option value="	650	">	650	ª Região	</option>
            <option value="	651	">	651	ª Região	</option>
            <option value="	652	">	652	ª Região	</option>
            <option value="	653	">	653	ª Região	</option>
            <option value="	654	">	654	ª Região	</option>
            <option value="	655	">	655	ª Região	</option>
            <option value="	656	">	656	ª Região	</option>
            <option value="	657	">	657	ª Região	</option>
            <option value="	658	">	658	ª Região	</option>
            <option value="	659	">	659	ª Região	</option>
            <option value="	660	">	660	ª Região	</option>
            <option value="	661	">	661	ª Região	</option>
            <option value="	662	">	662	ª Região	</option>
            <option value="	663	">	663	ª Região	</option>
            <option value="	664	">	664	ª Região	</option>
            <option value="	665	">	665	ª Região	</option>
            <option value="	666	">	666	ª Região	</option>
            <option value="	667	">	667	ª Região	</option>
            <option value="	668	">	668	ª Região	</option>
            <option value="	669	">	669	ª Região	</option>
            <option value="	670	">	670	ª Região	</option>
            <option value="	671	">	671	ª Região	</option>
            <option value="	672	">	672	ª Região	</option>
            <option value="	673	">	673	ª Região	</option>
            <option value="	674	">	674	ª Região	</option>
            <option value="	675	">	675	ª Região	</option>
            <option value="	676	">	676	ª Região	</option>
            <option value="	677	">	677	ª Região	</option>
            <option value="	678	">	678	ª Região	</option>
            <option value="	679	">	679	ª Região	</option>
            <option value="	680	">	680	ª Região	</option>
            <option value="	681	">	681	ª Região	</option>
            <option value="	682	">	682	ª Região	</option>
            <option value="	683	">	683	ª Região	</option>
            <option value="	684	">	684	ª Região	</option>
            <option value="	685	">	685	ª Região	</option>
            <option value="	686	">	686	ª Região	</option>
            <option value="	687	">	687	ª Região	</option>
            <option value="	688	">	688	ª Região	</option>
            <option value="	689	">	689	ª Região	</option>
            <option value="	690	">	690	ª Região	</option>
            <option value="	691	">	691	ª Região	</option>
            <option value="	692	">	692	ª Região	</option>
            <option value="	693	">	693	ª Região	</option>
            <option value="	694	">	694	ª Região	</option>
            <option value="	695	">	695	ª Região	</option>
            <option value="	696	">	696	ª Região	</option>
            <option value="	697	">	697	ª Região	</option>
            <option value="	698	">	698	ª Região	</option>
            <option value="	699	">	699	ª Região	</option>
            <option value="	700	">	700	ª Região	</option>
            <option value="	701	">	701	ª Região	</option>
            <option value="	702	">	702	ª Região	</option>
            <option value="	703	">	703	ª Região	</option>
            <option value="	704	">	704	ª Região	</option>
            <option value="	705	">	705	ª Região	</option>
            <option value="	706	">	706	ª Região	</option>
            <option value="	707	">	707	ª Região	</option>
            <option value="	708	">	708	ª Região	</option>
            <option value="	709	">	709	ª Região	</option>
            <option value="	710	">	710	ª Região	</option>
            <option value="	711	">	711	ª Região	</option>
            <option value="	712	">	712	ª Região	</option>
            <option value="	713	">	713	ª Região	</option>
            <option value="	714	">	714	ª Região	</option>
            <option value="	715	">	715	ª Região	</option>
            <option value="	716	">	716	ª Região	</option>
            <option value="	717	">	717	ª Região	</option>
            <option value="	718	">	718	ª Região	</option>
            <option value="	719	">	719	ª Região	</option>
            <option value="	720	">	720	ª Região	</option>
            <option value="	721	">	721	ª Região	</option>
            <option value="	722	">	722	ª Região	</option>
            <option value="	723	">	723	ª Região	</option>
            <option value="	724	">	724	ª Região	</option>
            <option value="	725	">	725	ª Região	</option>
            <option value="	726	">	726	ª Região	</option>
            <option value="	727	">	727	ª Região	</option>
            <option value="	728	">	728	ª Região	</option>
            <option value="	729	">	729	ª Região	</option>
            <option value="	730	">	730	ª Região	</option>
            <option value="	731	">	731	ª Região	</option>
            <option value="	732	">	732	ª Região	</option>
            <option value="	733	">	733	ª Região	</option>
            <option value="	734	">	734	ª Região	</option>
            <option value="	735	">	735	ª Região	</option>
            <option value="	736	">	736	ª Região	</option>
            <option value="	737	">	737	ª Região	</option>
            <option value="	738	">	738	ª Região	</option>
            <option value="	739	">	739	ª Região	</option>
            <option value="	740	">	740	ª Região	</option>
            <option value="	741	">	741	ª Região	</option>
            <option value="	742	">	742	ª Região	</option>
            <option value="	743	">	743	ª Região	</option>
            <option value="	744	">	744	ª Região	</option>
            <option value="	745	">	745	ª Região	</option>
            <option value="	746	">	746	ª Região	</option>
            <option value="	747	">	747	ª Região	</option>
            <option value="	748	">	748	ª Região	</option>
            <option value="	749	">	749	ª Região	</option>
            <option value="	750	">	750	ª Região	</option>
            <option value="	751	">	751	ª Região	</option>
            <option value="	752	">	752	ª Região	</option>
            <option value="	753	">	753	ª Região	</option>
            <option value="	754	">	754	ª Região	</option>
            <option value="	755	">	755	ª Região	</option>
            <option value="	756	">	756	ª Região	</option>
            <option value="	757	">	757	ª Região	</option>
            <option value="	758	">	758	ª Região	</option>
            <option value="	759	">	759	ª Região	</option>
            <option value="	760	">	760	ª Região	</option>
            <option value="	761	">	761	ª Região	</option>
            <option value="	762	">	762	ª Região	</option>
            <option value="	763	">	763	ª Região	</option>
            <option value="	764	">	764	ª Região	</option>
            <option value="	765	">	765	ª Região	</option>
            <option value="	766	">	766	ª Região	</option>
            <option value="	767	">	767	ª Região	</option>
            <option value="	768	">	768	ª Região	</option>
            <option value="	769	">	769	ª Região	</option>
            <option value="	770	">	770	ª Região	</option>
            <option value="	771	">	771	ª Região	</option>
            <option value="	772	">	772	ª Região	</option>
            <option value="	773	">	773	ª Região	</option>
            <option value="	774	">	774	ª Região	</option>
            <option value="	775	">	775	ª Região	</option>
            <option value="	776	">	776	ª Região	</option>
            <option value="	777	">	777	ª Região	</option>
            <option value="	778	">	778	ª Região	</option>
            <option value="	779	">	779	ª Região	</option>
            <option value="	780	">	780	ª Região	</option>
            <option value="	781	">	781	ª Região	</option>
            <option value="	782	">	782	ª Região	</option>
            <option value="	783	">	783	ª Região	</option>
            <option value="	784	">	784	ª Região	</option>
            <option value="	785	">	785	ª Região	</option>
            <option value="	786	">	786	ª Região	</option>
            <option value="	787	">	787	ª Região	</option>
            <option value="	788	">	788	ª Região	</option>
            <option value="	789	">	789	ª Região	</option>
            <option value="	790	">	790	ª Região	</option>
            <option value="	791	">	791	ª Região	</option>
            <option value="	792	">	792	ª Região	</option>
            <option value="	793	">	793	ª Região	</option>
            <option value="	794	">	794	ª Região	</option>
            <option value="	795	">	795	ª Região	</option>
            <option value="	796	">	796	ª Região	</option>
            <option value="	797	">	797	ª Região	</option>
            <option value="	798	">	798	ª Região	</option>
            <option value="	799	">	799	ª Região	</option>
            <option value="	800	">	800	ª Região	</option>
            <option value="	801	">	801	ª Região	</option>
            <option value="	802	">	802	ª Região	</option>
            <option value="	803	">	803	ª Região	</option>
            <option value="	804	">	804	ª Região	</option>
            <option value="	805	">	805	ª Região	</option>
            <option value="	806	">	806	ª Região	</option>
            <option value="	807	">	807	ª Região	</option>
            <option value="	808	">	808	ª Região	</option>
            <option value="	809	">	809	ª Região	</option>
            <option value="	810	">	810	ª Região	</option>
            <option value="	811	">	811	ª Região	</option>
            <option value="	812	">	812	ª Região	</option>
            <option value="	813	">	813	ª Região	</option>
            <option value="	814	">	814	ª Região	</option>
            <option value="	815	">	815	ª Região	</option>
            <option value="	816	">	816	ª Região	</option>
            <option value="	817	">	817	ª Região	</option>
            <option value="	818	">	818	ª Região	</option>
            <option value="	819	">	819	ª Região	</option>
            <option value="	820	">	820	ª Região	</option>
            <option value="	821	">	821	ª Região	</option>
            <option value="	822	">	822	ª Região	</option>
            <option value="	823	">	823	ª Região	</option>
            <option value="	824	">	824	ª Região	</option>
            <option value="	825	">	825	ª Região	</option>
            <option value="	826	">	826	ª Região	</option>
            <option value="	827	">	827	ª Região	</option>
            <option value="	828	">	828	ª Região	</option>
            <option value="	829	">	829	ª Região	</option>
            <option value="	830	">	830	ª Região	</option>
            <option value="	831	">	831	ª Região	</option>
            <option value="	832	">	832	ª Região	</option>
            <option value="	833	">	833	ª Região	</option>
            <option value="	834	">	834	ª Região	</option>
            <option value="	835	">	835	ª Região	</option>
            <option value="	836	">	836	ª Região	</option>
            <option value="	837	">	837	ª Região	</option>
            <option value="	838	">	838	ª Região	</option>
            <option value="	839	">	839	ª Região	</option>
            <option value="	840	">	840	ª Região	</option>
            <option value="	841	">	841	ª Região	</option>
            <option value="	842	">	842	ª Região	</option>
            <option value="	843	">	843	ª Região	</option>
            <option value="	844	">	844	ª Região	</option>
            <option value="	845	">	845	ª Região	</option>
            <option value="	846	">	846	ª Região	</option>
            <option value="	847	">	847	ª Região	</option>
            <option value="	848	">	848	ª Região	</option>
            <option value="	849	">	849	ª Região	</option>
            <option value="	850	">	850	ª Região	</option>
            <option value="	851	">	851	ª Região	</option>
            <option value="	852	">	852	ª Região	</option>
            <option value="	853	">	853	ª Região	</option>
            <option value="	854	">	854	ª Região	</option>
            <option value="	855	">	855	ª Região	</option>
            <option value="	856	">	856	ª Região	</option>
            <option value="	857	">	857	ª Região	</option>
            <option value="	858	">	858	ª Região	</option>
            <option value="	859	">	859	ª Região	</option>
            <option value="	860	">	860	ª Região	</option>
            <option value="	861	">	861	ª Região	</option>
            <option value="	862	">	862	ª Região	</option>
            <option value="	863	">	863	ª Região	</option>
            <option value="	864	">	864	ª Região	</option>
            <option value="	865	">	865	ª Região	</option>
            <option value="	866	">	866	ª Região	</option>
            <option value="	867	">	867	ª Região	</option>
            <option value="	868	">	868	ª Região	</option>
            <option value="	869	">	869	ª Região	</option>
            <option value="	870	">	870	ª Região	</option>
            <option value="	871	">	871	ª Região	</option>
            <option value="	872	">	872	ª Região	</option>
            <option value="	873	">	873	ª Região	</option>
            <option value="	874	">	874	ª Região	</option>
            <option value="	875	">	875	ª Região	</option>
            <option value="	876	">	876	ª Região	</option>
            <option value="	877	">	877	ª Região	</option>
            <option value="	878	">	878	ª Região	</option>
            <option value="	879	">	879	ª Região	</option>
            <option value="	880	">	880	ª Região	</option>
            <option value="	881	">	881	ª Região	</option>
            <option value="	882	">	882	ª Região	</option>
            <option value="	883	">	883	ª Região	</option>
            <option value="	884	">	884	ª Região	</option>
            <option value="	885	">	885	ª Região	</option>
            <option value="	886	">	886	ª Região	</option>
            <option value="	887	">	887	ª Região	</option>
            <option value="	888	">	888	ª Região	</option>
            <option value="	889	">	889	ª Região	</option>
            <option value="	890	">	890	ª Região	</option>
            <option value="	891	">	891	ª Região	</option>
            <option value="	892	">	892	ª Região	</option>
            <option value="	893	">	893	ª Região	</option>
            <option value="	894	">	894	ª Região	</option>
            <option value="	895	">	895	ª Região	</option>
            <option value="	896	">	896	ª Região	</option>
            <option value="	897	">	897	ª Região	</option>
            <option value="	898	">	898	ª Região	</option>
            <option value="	899	">	899	ª Região	</option>
            <option value="	900	">	900	ª Região	</option>
            <option value="	901	">	901	ª Região	</option>
            <option value="	902	">	902	ª Região	</option>
            <option value="	903	">	903	ª Região	</option>
            <option value="	904	">	904	ª Região	</option>
            <option value="	905	">	905	ª Região	</option>
            <option value="	906	">	906	ª Região	</option>
            <option value="	907	">	907	ª Região	</option>
            <option value="	908	">	908	ª Região	</option>
            <option value="	909	">	909	ª Região	</option>
            <option value="	910	">	910	ª Região	</option>
            <option value="	911	">	911	ª Região	</option>
            <option value="	912	">	912	ª Região	</option>
            <option value="	913	">	913	ª Região	</option>
            <option value="	914	">	914	ª Região	</option>
            <option value="	915	">	915	ª Região	</option>
            <option value="	916	">	916	ª Região	</option>
            <option value="	917	">	917	ª Região	</option>
            <option value="	918	">	918	ª Região	</option>
            <option value="	919	">	919	ª Região	</option>
            <option value="	920	">	920	ª Região	</option>
            <option value="	921	">	921	ª Região	</option>
            <option value="	922	">	922	ª Região	</option>
            <option value="	923	">	923	ª Região	</option>
            <option value="	924	">	924	ª Região	</option>
            <option value="	925	">	925	ª Região	</option>
            <option value="	926	">	926	ª Região	</option>
            <option value="	927	">	927	ª Região	</option>
            <option value="	928	">	928	ª Região	</option>
            <option value="	929	">	929	ª Região	</option>
            <option value="	930	">	930	ª Região	</option>
            <option value="	931	">	931	ª Região	</option>
            <option value="	932	">	932	ª Região	</option>
            <option value="	933	">	933	ª Região	</option>
            <option value="	934	">	934	ª Região	</option>
            <option value="	935	">	935	ª Região	</option>
            <option value="	936	">	936	ª Região	</option>
            <option value="	937	">	937	ª Região	</option>
            <option value="	938	">	938	ª Região	</option>
            <option value="	939	">	939	ª Região	</option>
            <option value="	940	">	940	ª Região	</option>
            <option value="	941	">	941	ª Região	</option>
            <option value="	942	">	942	ª Região	</option>
            <option value="	943	">	943	ª Região	</option>
            <option value="	944	">	944	ª Região	</option>
            <option value="	945	">	945	ª Região	</option>
            <option value="	946	">	946	ª Região	</option>
            <option value="	947	">	947	ª Região	</option>
            <option value="	948	">	948	ª Região	</option>
            <option value="	949	">	949	ª Região	</option>
            <option value="	950	">	950	ª Região	</option>
            <option value="	951	">	951	ª Região	</option>
            <option value="	952	">	952	ª Região	</option>
            <option value="	953	">	953	ª Região	</option>
            <option value="	954	">	954	ª Região	</option>
            <option value="	955	">	955	ª Região	</option>
            <option value="	956	">	956	ª Região	</option>
            <option value="	957	">	957	ª Região	</option>
            <option value="	958	">	958	ª Região	</option>
            <option value="	959	">	959	ª Região	</option>
            <option value="	960	">	960	ª Região	</option>
            <option value="	961	">	961	ª Região	</option>
            <option value="	962	">	962	ª Região	</option>
            <option value="	963	">	963	ª Região	</option>
            <option value="	964	">	964	ª Região	</option>
            <option value="	965	">	965	ª Região	</option>
            <option value="	966	">	966	ª Região	</option>
            <option value="	967	">	967	ª Região	</option>
            <option value="	968	">	968	ª Região	</option>
            <option value="	969	">	969	ª Região	</option>
            <option value="	970	">	970	ª Região	</option>
            <option value="	971	">	971	ª Região	</option>
            <option value="	972	">	972	ª Região	</option>
            <option value="	973	">	973	ª Região	</option>
            <option value="	974	">	974	ª Região	</option>
            <option value="	975	">	975	ª Região	</option>
            <option value="	976	">	976	ª Região	</option>
            <option value="	977	">	977	ª Região	</option>
            <option value="	978	">	978	ª Região	</option>
            <option value="	979	">	979	ª Região	</option>
            <option value="	980	">	980	ª Região	</option>
            <option value="	981	">	981	ª Região	</option>
            <option value="	982	">	982	ª Região	</option>
            <option value="	983	">	983	ª Região	</option>
            <option value="	984	">	984	ª Região	</option>
            <option value="	985	">	985	ª Região	</option>
            <option value="	986	">	986	ª Região	</option>
            <option value="	987	">	987	ª Região	</option>
            <option value="	988	">	988	ª Região	</option>
            <option value="	989	">	989	ª Região	</option>
            <option value="	990	">	990	ª Região	</option>
            <option value="	991	">	991	ª Região	</option>
            <option value="	992	">	992	ª Região	</option>
            <option value="	993	">	993	ª Região	</option>
            <option value="	994	">	994	ª Região	</option>
            <option value="	995	">	995	ª Região	</option>
            <option value="	996	">	996	ª Região	</option>
            <option value="	997	">	997	ª Região	</option>
            <option value="	998	">	998	ª Região	</option>
            <option value="	999	">	999	ª Região	</option>
            <option value="	1000">	1000ª Região	</option>



		</select>
	</div>
</div>  
   	<div class="submitting" style="margin: 30px auto 50px auto ">
		<input id="enviar" type="submit" class="left btn btn-success"  value="Enviar">
		<input id="cancelar" type="submit" name="cancelar" class="right btn btn-default" value="Cancelar">
	</div>
</div>
</div>
</form>
</div>
</div>
