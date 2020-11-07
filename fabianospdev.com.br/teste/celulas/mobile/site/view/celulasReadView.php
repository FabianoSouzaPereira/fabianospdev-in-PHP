<?php 

use mobile\modulos\Celula;

require 'init.php';
include_once '../mobile/modulos/Celula.php';
include_once '../mobile/functions/Pesquisa.php';

?>
<div id="bgcelulas" class="tela">
<div class="formato panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Células</h1>
	</div>
<div class="panel-body">	
<div>
<a href="index.php?page=site_view_celulaCreateView" style="background-color: green;" class="btn btn-primary btn-novo"><span class="glyphicon glyphicon-plus"></span> Nova Célula</a>
<label class="acessoSmart" style='display: none'> Pesquisar</label></span>
</button>
    <input type="text" id="pesquisacel" class="form-control sombra-efe" style="display:inline-block;margin-top:6px;width:200px;"  placeholder="Pesquisa...">
</div>
<table id="tbCelulas" class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
	<thead>
	<tr>
		<th style='color: red;'>Celula</th>
		<th style='color: red;'>Editar</th>
	</tr>
</thead>
	<tbody>
	<?php 
	$cel = new Celula(); 
	$id=null;
    try{
        
       $cel->pastorReadCelulas();
       $ret = $cel->getDados();
            $sec=1;
        if(is_array($ret)){
            Foreach($ret as $raw) {
                $id= $raw['celId']; $celula= $raw['celCelula']; $rede= $raw['celRede']; $lider= $raw['celLider']; 
                $vicelider= $raw['celViceLider'];$secretario= $raw['celSecretario']; $anfitriao= $raw['celAnfitriao']; 
                $colaborador= $raw['celColaborador'];$dia= $raw['celDia'];$hora= $raw['celHora'];$data= $raw['celData'];
                echo "<tr>"; 
                echo "<td style='text-transform:uppercase; color: black;'>",$celula,"</td>";
                echo "<td><a href='index.php?page=site_view_celulaUpdateView&id=$id' class='btn btn-primary btn-lista'><span class='glyphicon glyphicon-edit'></span></a></td>";
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

<script>
$(document).ready(function(){
  $("#pesquisacel").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>