<?php ob_start(); //Carregar sempre o buffer para poder usar a vontade o header("url");
include_once 'init.php';?>
<!Doctype html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" charset="utf-8">
<title>Células</title>
<!-- <base href="https://celulas.fabianospdev.com.br/"> -->
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="Applicação web para gerenciamento de Células da igreja.">
<meta name="keywords" content="Developer">
<meta name="author" content="Fabianospdev.com">
<!-- Chamada do CSS -->
<link rel="stylesheet" href="../application/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/buttoms.css">
<link rel="stylesheet" href="css/layoutPadrao.css">
<link rel="stylesheet" href="css/estilo.css">
<link rel="stylesheet" href="css/estilo2.css">
<link rel="stylesheet" href="css/estilo3.css">
<link rel="stylesheet" href="css/relatorios.css">
<link rel="stylesheet" href="css/estatisticas.css">
<!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
<script src="../application/bootstrap/js/jquery-1.12.4.min.js"></script>
        <!--  Plugin para mascara monetária -->
<script src="../application/bootstrap/js/bootstrap.min.js"></script>
<script src="../application/bootstrap/js/jquery.maskMoney.js"></script>
  		<!-- Plugin para mascara para data -->
<script src="../application/bootstrap/js/maskedinput.min.js"></script>
        <!-- CHART -->
<script type="text/javascript" src="../application/modulos/modelosRelatorios/assets/Chart.min.js"></script>
<script type="text/javascript" src="../application/modulos/modelosRelatorios/assets/chart.init.js"></script>
        <!-- Outros -->
<script src="../application/lib/jquery.js"></script> <!-- não contem jquery é só o nome -->
<script type="text/javascript" src="../js/functions.js"></script>
<script src="../js/selects.js"></script>

<script> 
$(function(){
    $(document).ready(function(){   				 			
    $(".mascaraData").mask("99/99/9999");
    $(".mascaraTelefone").mask("(99) 99999-9999");			
    });	
});
</script>
</head>
<body class="">
	    <?php include "top.php"; ?> 

		<!-- START SITE CONTEND -->
		<div id="conteudo-principal">
			<?php include $fullpath; ?>
		</div>
		<!-- END SITE CONTEND -->
		<?php include "footer.php"; ?>
</body>
</html>
