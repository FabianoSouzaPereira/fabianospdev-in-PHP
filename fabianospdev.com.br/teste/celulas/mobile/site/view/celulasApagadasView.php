<?php
use mobile\modulos\Celula;

require 'init.php';
include_once '../mobile/modulos/Celula.php';

?>
<div class="tela">
<div class="formato">
<div class="panel panel-warning">
	<div class="panel-heading">
		<h1>Lista de Células Apagadas</h1>
	</div>
<div class="panel-body">	
<a href="index.php?page=site_view_celulaCreateView" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Nova célula</a>
<a href="index.php?page=site_view_celulaDeleteView" class="btn btn-primary"><span class="glyphicon glyphicon-minus"></span> Apagar célula</a>
<table class="listagem table table-bordered table-striped table-responsive"  style="margin-top:10px;">
	<thead>
	<tr>
		<th></th>
		<th style='color: red;'>Celula</th>
		<th style='color: red;'>Rede</th>
		<th style='color: red;'>Data</th>
		<th style='color: red;'>Hora</th>
		<th style='color: red;'>Mais</th>
		<th style='color: red;'>Apagar</th>
	</tr>
</thead>
	<tbody>
	<?php 
	$cel = new Celula(); 
	$id=null;
    try{
        $cel->pastorReadDeleteds();

    	    $ret = $cel->getDados();
    	    $data=null;
            $sec=1;
        if(is_array($ret)){
            Foreach($ret as $raw) {
                $id= $raw['celId']; $celula= $raw['celCelula']; $rede= $raw['celRede']; $lider= $raw['celLider']; $vicelider= $raw['celViceLider'];$secretario= $raw['celSecretario']; $anfitriao= $raw['celAnfitriao']; $colaborador= $raw['celColaborador'];$dia= $raw['celDia'];$hora= $raw['celHora'];$data= $raw['celData'];
                echo "<tr>"; 
                echo "<td style='text-transform:uppercase; color: black;'>", $sec++ ,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>",$celula,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $rede,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $dia,"</td>";
                echo "<td style='text-transform:uppercase; color: black;'>", $hora,"</td>";
                echo "<td><a href='index.php?page=site_view_celulaDetailsView&id=$id' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></a></td>";
                echo "<td><a href='index.php?page=site_view_celulaDeleteforever&id=$id&ac=delpen' class='btn btn-primary'><span class='glyphicon glyphicon-remove'></span></a></td>";
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
</div>

