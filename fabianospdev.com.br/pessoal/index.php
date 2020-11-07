<?php header('Content-Type: text/html; charset=utf-8');

require_once 'init.php';

$fullpath="";

if(strpos($_SERVER['REQUEST_URI'],"=") != 0){
    $url = urlnow();
}else{
    $url="inicio";
}


$fullpath = "public/" . $url . ".php"; 

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=10">
<title>Fabiano's page</title>
<base href="http://pessoal.fabianospdev.com.br/">
<meta name="viewport"
	content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="keywords" content="Developer">
<meta name="author" content="Fabianospdev.com">
	<link rel="stylesheet" href="public/css-public/styleIndex.css" >
	<link rel="stylesheet" href="public/css-public/menu.css" >
	<link rel="stylesheet" href="public/css-public/curriculo.css" >
	<script src="public/functions.js" ></script>
</head>
<body id="body-index">

	    <?php include "public/topo.php"; ?>
		<!-- START SITE CONTEND -->
		<div id="conteudo-principal">
			<?php include $fullpath; ?>
		</div>
		<!-- END SITE CONTEND -->
		<?php include "public/rodape.php"; ?>


</body>
</html>