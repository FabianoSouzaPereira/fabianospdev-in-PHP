<?php 

use modulos\Celula;

require 'init.php';
include_once 'modulos/Celula.php';
include_once '../application/functions/Validador.php';
include_once '../js/functions.js';



?>

<div class="panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Células</h1>
	</div>
<div class="panel-body">	
<div>
<a href="index.php?page=modulos_view_celulaCreateView" style="background-color: green;" class="btn btn-primary btn-novo"><span class="glyphicon glyphicon-plus"></span> Nova Célula</a>
<select id="estado" name="estado" onchange="getcidades(value)" class="form-control" style="display: inline-block;margin-left:12px;width:250px;height:38px;font-size:14px;" >
    <option value="">Selecione um estado</option>
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
</select>
<select id="cidades" name="cidades"  class="form-control" style="display: inline-block;margin-left:12px;width:250px;height:38px;font-size:14px;">
	<option value="SELECIONE">selecione o estado</option>
</select>
<select id="" name=""  class="form-control carregando" style="display: none;margin:0px 0px 0px 12px;width:250px;height:38px;font-size:14px;">
	<option value="">carregando</option>
</select>
<button id="btnCelPesquisa" style="margin-left:10px;"><span class="glyphicon glyphicon-search">
<label class="acessoSmart" style='display: none'> Pesquisar</label></span>
</button>
</div>
<table id="tbCelulas" class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
	<thead>
	<tr>
		<th></th>
		<th style='color: red;'>Celula</th>
		<th style='color: red;'>Rede</th>
		<th style='color: red;'>Lider</th>
		<th style='color: red;'>Anfitriao</th>
		<th style='color: red;'>Data</th>
		<th style='color: red;'>Hora</th>
		<th style='color: red;'>Mais</th>
		<th style='color: red;'>Editar</th>
	</tr>
</thead>
	<tbody>
	<?php 
	$cel = new Celula(); 
	$id=null;
    try{
        if(isset($id) && $id > 0){
            $cel->readCelulas($id);
        }else{
            $cel->readCelulas();
        }
    	    $ret = $cel->getDados();
            $sec=1;
        if(is_array($ret)){
            Foreach($ret as $raw) {
                $id= $raw['celId']; $celula= $raw['celCelula']; $rede= $raw['celRede']; $lider= $raw['celLider']; 
                $vicelider= $raw['celViceLider'];$secretario= $raw['celSecretario']; $anfitriao= $raw['celAnfitriao']; 
                $colaborador= $raw['celColaborador'];$dia= $raw['celDia'];$hora= $raw['celHora'];$data= $raw['celData'];
                echo "<tr>"; 
                echo "<td style='text-transform:uppercase; color: black;'>", $sec++ ,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>",$celula,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $rede,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $lider,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $anfitriao,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $dia,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $hora,"</td>";
                echo "<td><a href='index.php?page=site_view_celulaDetailsView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></a></td>";
                echo "<td><a href='index.php?page=site_view_celulaUpdateView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-edit'></span></a></td>";
                echo "</tr>";
            }
     
        }
    
    	}catch (PDOException $error) {
    	    echo "Error ".$error->getMessage();
    	}
    	
	?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="13" class="text-center"> <?php echo date('d/m/Y h:i:s'); ?></th>
		</tr>
	</tfoot>
 </table>
 </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	  $('#estado').change(function(){
		  var estados= $('#estado').val();
		if( estados ) {
		  $('#cidades').hide();
		  $('.carregando').css('display','inline-block');
		  $('.carregando').show();
	      $.getJSON(
	        'site/pesquisa.php',
	        {
	          estados: estados,
	          ajax: 'true',
	        }, function(j){
	          var options = '<option value="">selecione a cidade</option>';
	          for (var i = 0; i < j.length; i++) {
    	          options += '<option value="' +
    	          j[i].nome + '">' +
    	          j[i].nome + '</option>';  	         
	          } 
	          $('#cidades').html(options).show();
	          $('.carregando').css('display','none');
	          $('.carregando').hide();       
	        });
	    } else {
	      $('#cidades').html(
	        '<option value="">-- Escolha um estado! --</option>'
	      );
	    }
	  });
	});
</script>
<script type="text/javascript">
$(function(){
	  $('#btnCelPesquisa').click(function(){
		var tbody= $('#tbCelulas > tbody');
		var estado = $('#estado').val(); 
		var cidade = $('#cidades').val();
		
	    if( estado ) { 
	      $.getJSON(
	        'site/pesquisa2.php',
	        {
		      estado: estado,
	          cidade: cidade, 
	          ajax: 'true'
	        }, function(x){ 
	        	tbody= $('#tbCelulas > tbody');
	        	var raws = '<tr style="text-transform:uppercase; color: black;>"'; 
	        	$.each(x, function (i, d) {
	                selectbox.append('<td value="' + x[i].id + '">' + x[i].celula + '</td>');
	            });

	          return false;
	        });
	    } else {
	      $('#igrejas').html(
	        '<option value="escolha">-- Escolha uma igreja --</option>'
	      );
	    }
	  });
	});
</script>

