<?php include_once 'init.php';?>
<!Doctype html>
<html lang="pt-br">
<head>
    <title>Escola</title>
    <meta charset="utf8">
    <!-- Chamada do CSS -->
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <script src="bootstrap/js/jquery-1.12.4.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="application/lib/jquery.js"></script>

</head>
<body>
	    <?php include "top.php"; ?>
		<!-- START SITE CONTEND -->
		<div id="conteudo-principal">
			<?php include $fullpath; ?>
		</div>
		<!-- END SITE CONTEND -->
		<?php include "foot.php"; ?>
</body>
</html>