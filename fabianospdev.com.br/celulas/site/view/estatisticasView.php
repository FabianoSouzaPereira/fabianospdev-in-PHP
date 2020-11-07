<?php
use application\modulos\modelosRelatorios\Estatisticas;

//require 'init.php';
include_once 'application/modulos/modelosRelatorios/Estatisticas.php';

$ret=null;
$est = new Estatisticas();
$A= $est->getTotalrelatoriosA();$B=$est->getTotalrelatoriosB(); 
$dadosMaisVisitantes= $est->getDadosMaisVisitantes();
$dadosMenosVisitantes= $est->getDadosMenosVisitantes();
$total_pessoas_reuniao= $est->_pessoas_por_reuniao();
$totais_pessoas_relatorios= $est->getPessoasRelatorios();

$_ = "&nbsp;&nbsp;&nbsp;";
$E = "&#013;";


?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var button = document.getElementById('change-chart');
        var chartDiv = document.getElementById('chart_div');

        var data = google.visualization.arrayToDataTable([
          ['Celulas', 'Pessoas', 'Visitantes'],

  		<?php
  	       if (is_array($total_pessoas_reuniao)) {
  	          Foreach ($total_pessoas_reuniao as $raw) {
  	           $celula = $raw['celula'];
  	           $pessoas = $raw['totalpessoas'];
  	           $visitantes= $raw['totalVisitantes'];
        ?>

	      ['<?php  echo $celula; ?>','<?php echo $pessoas; ?>','<?php echo $visitantes;  ?>'],


  	<?php  }  
         }   ?>

        ]);
        
       
        var celulasOptions = {
          width: 700,
          height: 450, 
          chart: {
            title: 'Dados das células',
            subtitle: 'Dados comparativos das células'
          },
          series: {
            	0: { axis: 'Pessoas' },
                1: { axis: 'Visitantes' }
          },
          axes: {
            y: {
              Pessoas: {label: 'Quantidade de pessoas'}, 
              visitantes: {side: 'right', label: 'Quantidade de visitantes'},
            },
             
          },
          bar: { groupWidth: '60%' },
          legend: { position: "relative" },
          backgroundColor: 'white',

          chartArea: {left:20,top:0,width:'100%',height:'75%'},
                
        };

        var classicOptions = {
          width: 700,
          series: {
            0: {targetAxisIndex: 0},
            1: {targetAxisIndex: 1}
          },
          title: 'Nearby galaxies - distance on the left, brightness on the right',
          vAxes: {
            // Adds titles to each axis.
            0: {title: 'Quantidade'},
            1: {title: 'pessoas'}
          }
        };

        function drawCelulasChart() {
          var celulasChart = new google.charts.Bar(chartDiv);
          celulasChart.draw(data, google.charts.Bar.convertOptions(celulasOptions));
          button.innerText = 'Change to Classic';
          button.onclick = drawClassicChart;
        }

        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
          button.innerText = 'Change to Celulas';
          button.onclick = drawCelulasChart;
        }

        drawCelulasChart();
    };
    </script>
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    
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
				<label>Celula com mais visitantes:<?php  echo $est->getCelula(); ?>&nbsp;&nbsp;&nbsp;
       		<ul>
        		<?php
             if (is_array($dadosMaisVisitantes)) {
              Foreach ($dadosMaisVisitantes as $raw) {
                $celula = $raw['celula'];
                $visitantes = $raw['visitantes'];

                echo "<li><label  style='max-width: 200px;'>$celula $_ : <span style='color: blue;'>$_ $visitantes</span></label></li>";
               }
             }
            ?>
           </ul>
		</label></br> 
		 <label>Celula com menos visitantes: <?php echo $est->getCelula(); ?>&nbsp;&nbsp;&nbsp; <?php ?>
        	<ul>
           <?php
                if (is_array($dadosMenosVisitantes)) {
                Foreach ($dadosMenosVisitantes as $raw) {
                    $celula = $raw['celula'];
                    $visitantes = $raw['visitantes'];
    
                    echo "<li><label  style='max-width: 200px;'>$celula $_ : <span style='color: blue;'>$_ $visitantes</span></label></br></li>";
                 }
               }
              ?>
             </ul>
				</label></br>
		
		 </div>
		</section> 
		<section id="membros">
			<div><label>Total de membros frequentando a célula:</label>
			  <label>Total de Membros : <?php   ?>
				<ul>
			<?php

            if (is_array($totais_pessoas_relatorios)) {
            Foreach ($totais_pessoas_relatorios as $raw) { 
                $celula = $raw['celula'];
                $totalmembros = $raw['TotalMembros'];

                echo "<li><label  style='max-width: 200px;'>$celula $_ : <span style='color: blue;'>$_ $totalmembros</span></label></br></li>";
           }
           } 
          ?>   
				</ul>
			  </label></br>
			</div>
		</section>
		
		
		<section id="adultos_criancas">
			<div><label style="margin:10px">Total de adultos e jovens nas células:</label></div>
			  <div><label   style="float:right;margin:0px 10px 0px 5px;">jovens</label><label   style="float:right;margin:0px 10px 0px 5px;">adultos</label></div>
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
					<div id="chart_div" style="padding:10px !important;"></div>
					<div id="piechart" style="width: 900px; height: 500px;"></div>
						<div class="row">
							<div class="col-md-4">
								<canvas id="line-chart" class="chart hidden"></canvas>
							</div>
							<div class="col-md-4">
								<canvas id="bar-chart" class="chart hidden" ></canvas>
							</div>
							<div class="col-md-4">
								<canvas id="pie-chart" class="chart hidden"></canvas>
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
