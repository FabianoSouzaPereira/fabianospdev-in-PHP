<?php

use mobile\modulos\Igreja;
use application\functions\Validador;

require 'init.php';
include_once '../mobile/modulos/Igreja.php';
include_once '../mobile/functions/Validador.php';
include_once '../js/functions.js';

if (isset($_POST['cancelar'])){
    header( "Location: index.php?pag=site_view_churchReadView" );
    exit(); 
}

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
    
    $igr->PastorInsert();
    
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
			<option value="65">Almenara</option>
            <option value="66">Araguari</option>
            <option value="67">Araxa</option>
            <option value="68">Barbacena</option>
            <option value="69">Bom Despacho</option>
            <option value="70">Campo Belo</option>
            <option value="71">Capelinha</option>
            <option value="72">Caratinga</option>
            <option value="73">Cataguases</option>
            <option value="74">Conselheiro Lafaiete</option>
            <option value="75">Coronel Fabriciano</option>
            <option value="76">Curvelo</option>
            <option value="77">Divinopolis</option>
            <option value="78">Formiga</option>
            <option value="79">Governador Valadares</option>
            <option value="80">Guanhaes</option>
            <option value="81">Ipatinga - 01</option>
            <option value="82">Ipatinga - 02</option>
            <option value="83">Ipatinga - 03</option>
            <option value="84">Ipatinga - 04</option>
            <option value="85">Ipatinga - 05</option>
            <option value="86">Itabira</option>
            <option value="87">Itabirito</option>
            <option value="88">Itajuba</option>
            <option value="89">Itamonte</option>
            <option value="90">Itauna</option>
            <option value="91">Janauba</option>
            <option value="92">Joao Monlevade</option>
            <option value="93">Juiz De Fora 01</option>
            <option value="94">Juiz De Fora 02</option>
            <option value="95">Juiz De Fora 03</option>
            <option value="96">Juiz De Fora 04</option>
            <option value="97">Juiz de Fora 5ª Região</option>
            <option value="98">Juíz de Fora 05</option>
            <option value="99">Lagoa Da Prata</option>
            <option value="100">Leopoldina</option>
            <option value="101">Manhuacu</option>
            <option value="102">Mateus Leme</option>
            <option value="103">Montes Claros</option>
            <option value="104">Muriae</option>
            <option value="105">Muriaé II</option>
            <option value="106">Nanuque</option>
            <option value="107">Norte IV</option>
            <option value="108">Nova Serrana</option>
            <option value="109">Para De Minas</option>
            <option value="110">Paracatu</option>
            <option value="111">Passos</option>
            <option value="112">Patos de Minas</option>
            <option value="113">Piumhi</option>
            <option value="114">Pompeu</option>
            <option value="115">Ponte Nova</option>
            <option value="116">Pouso Alegre</option>
            <option value="117">REGIÃO 417</option>
            <option value="118">Santana Do Paraiso</option>
            <option value="119">Santos Dumont</option>
            <option value="120">Sao Lourenco</option>
            <option value="121">São Francisco</option>
            <option value="122">Teofilo Otoni</option>
            <option value="123">Timoteo</option>
            <option value="124">Uba</option>
            <option value="125">Uberaba</option>
            <option value="126">Uberlândia 01</option>
            <option value="127">Uberlândia 03</option>
            <option value="128">Uberlândia 04</option>
            <option value="129">Uberlândia 05</option>
            <option value="130">Unaí</option>
            <option value="131">Viçosa</option>
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
