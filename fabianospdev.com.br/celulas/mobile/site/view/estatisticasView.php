<?php
use mobile\modulos\modelosRelatorios\Estatisticas;

//require 'init.php';
include_once '../mobile/modulos/modelosRelatorios/Estatisticas.php';

$ret=null;
$est = new Estatisticas();
$A= $est->getTotalrelatoriosA();$B=$est->getTotalrelatoriosB();  
$dadosMaisVisitantes= $est->getDadosMaisVisitantes();
$dadosMenosVisitantes= $est->getDadosMenosVisitantes();
$total_pessoas_reuniao= $est->getPessoasPorReuniao();
$totais_pessoas_relatorios= $est->getPessoasRelatorios();
$_ = "&nbsp;&nbsp;&nbsp;";
$E = "&#013;"



?>
<div  id="fundo-estatisticas" class="tela">
	<div class="formato">
	<div>	
		<section id="totais">
		<label class="lbtotais"">ÚLTIMOS 30 DIAS</label><br>
				<label>Total de igrejas:&nbsp;&nbsp;&nbsp;<span style="color: blue;"><?php echo $est->getTotaligrejas(); ?></span></label><br> <label>Total de celulas:&nbsp;&nbsp;&nbsp;<span style="color: blue;"><?php echo $est->getTotalcelulas(); ?></span></label><br>
				<label>Total de relatorios:&nbsp;&nbsp;&nbsp;<span style="color: blue;"><?php echo $somarel=$A+=$B;  ?></span></label><br> <label>Total de visitantes:&nbsp;&nbsp;&nbsp;<span style="color: blue;"><?php echo $est->getTotalvisitantes(); ?></span></label><br>
		</section>
		<section id="ttVisitantes">
		<label class="lbtotais" style="margin-bottom: 10px;">ÚLTIMOS 30 DIAS</label><br>
				<label>Celula com </br> mais visitantes:<?php  echo $est->getCelula(); ?>
       		<ul>
        		<?php
             if (is_array($dadosMaisVisitantes)) {
              Foreach ($dadosMaisVisitantes as $raw) {
                $celula = $raw['celula'];
                $visitantes = $raw['visitantes'];

                echo "<li><label  style='max-width: 200px;color:yellow;margin-left:-100px;margin-top:-10px;'>$celula : <span style='color: blue;'> $visitantes</span></label></li>";
               }
             }
            ?>
           </ul>
		</label></br> 
		 <label>Celula com  </br> menos visitantes: <?php echo $est->getCelula(); ?><?php ?>
        	<ul>
           <?php
                if (is_array($dadosMenosVisitantes)) {
                Foreach ($dadosMenosVisitantes as $raw) {
                    $celula = $raw['celula'];
                    $visitantes = $raw['visitantes'];
    
                    echo "<li><label  style='max-width: 200px;color:yellow;margin-left:-100px;margin-top:-10px;'>$celula  : <span style='color: blue;'>$visitantes</span></label></br></li>";
                 }
               }
              ?>
             </ul>
				</label></br>
		
		 </div>
		</section> 
		<section id="membros">
			<div><label>Total de membros frequentando a célula:</label>
			  <label style="margin-top:5px;">Membros : <?php   ?>
				<ul>
			<?php

            if (is_array($totais_pessoas_relatorios)) {
            Foreach ($totais_pessoas_relatorios as $raw) { 
                $celula = $raw['celula'];
                $totalmembros = $raw['TotalMembros'];

                echo "<li><label  style='max-width: 200px;color:yellow;margin-left:-100px;margin-top:-10px;''>$celula : <span style='color: blue;'>$_ $totalmembros</span></label></br></li>";
           }
           } 
          ?>   
				</ul>
			  </label></br>
			</div>
		</section>
		
		
		<section id="adultos_criancas">
			<div><label style="margin:10px">Total de adultos e jovens nas células:</label></div>
			  <div><label   style="float:right;margin:0px 10px 0px 5px;">crianças</label><label   style="float:right;margin:0px 10px 0px 5px;">adultos</label></div>
			<div id="lista_aj" style="">
			<ul>
			<?php

            if (is_array($totais_pessoas_relatorios)) {
            Foreach ($totais_pessoas_relatorios as $raw) { 
                $celula = $raw['celula'];
                $totalAdultos = $raw['TotalAdultos'];
                $totalJovens = $raw['TotalJovens'];
                echo "<div>";
                echo "<li>";
                echo "<div id='td1' style='display:inline-block;width:70%;'><label style='max-width: 85%;'>$celula</label></div>";
                echo "<div id='td2' style='display:inline-block;width:8%;'><label style='color: blue;margin-right:0%;'>$_$_ $totalAdultos</label></div>";
                echo "<div id='td3' style='display:inline-block;width:8%;'><label style='color: blue;margin-left:100%;text-align: rigth;'>$totalJovens</label></div>";                               
                echo "</li>";
                echo "</div>";
             }
           } 
          ?>   
			</ul>
			</div></br>
		</section>
		<div class="graficos">
			<section class="justa">
				<div class="container-fluid">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<canvas id="line-chart" class="chart hidden"></canvas>
							</div>
							<div class="col-md-4">
								<canvas id="bar-chart" class="chart  hidden"></canvas>
							</div>
							<div class="col-md-4">
								<canvas id="pie-chart" class="chart  hidden"></canvas>
							</div> 
						</div>
					</div>
				</div>
			</section>
			<secion>

            
			</secion>
	   </div>
   </div>
</div>
