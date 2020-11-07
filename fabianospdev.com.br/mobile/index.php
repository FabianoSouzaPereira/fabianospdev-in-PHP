<?php 
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
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=10">
<title>Fabiano's page</title>
<!-- <base href="https://fabianospdev.com.br/"> -->
<meta name="viewport"
	content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="keywords" content="Developer">
	<meta name="author" content="Fabianospdev.com">
	<link rel="stylesheet" href="../application/bootstrap/css/bootstrap.css" >
	<link rel="stylesheet" href="public/css-public/styleIndex.css" >
	<link rel="stylesheet" href="public/css-public/style-fotos.css" >
	<link rel="stylesheet" href="public/css-public/style-app.css" >
	<link rel="stylesheet" href="public/css-public/style-web.css">
	<link rel="stylesheet" href="public/css-public/menu.css" >
	<link rel="stylesheet" href="public/css-public/banners.css" >
	<link rel="stylesheet" href="public/css-public/btns.css" >
	<link rel="stylesheet" href="public/css-public/table.css" >
	<script src="../application/bootstrap/js/jquery-1.12.4.min.js"></script>
	<script src="../application/bootstrap/js/bootstrap.min.js"></script>
	<script src="public/functions.js" ></script>
</head>
<body id="body-index" style="width:100%; margin: 0px; font-size:12px;" data-spy="scroll" data-target="#menu-geral" data-offset="60">

	    <?php include "public/topo.php"; ?>
		<!-- START SITE CONTEND -->
		<div id="conteudo-principal">
			<?php include $fullpath; ?>
		</div>
		<!-- END SITE CONTEND -->
		<?php include "public/rodape.php"; ?>

<script>
		$(document).ready(function(){
		  // Add smooth scrolling to all links in navbar + footer link
		  $("#menu-geral a, footer a[href='#body-index']").on('click', function(event) {
		
		    // Prevent default anchor click behavior
		    event.preventDefault();
		
		    // Store hash
		    var hash = this.hash;
		
		    // Using jQuery's animate() method to add smooth page scroll
		    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
		    $('html, body').animate({
		      scrollTop: $(hash).offset().top
		    }, 900, function(){
		   
		      // Add hash (#) to URL when done scrolling (default click behavior)
		      window.location.hash = hash;
		    });
		  });
		  
		  // Slide in elements on scroll
		  $(window).scroll(function() {
		    $(".slideanim").each(function(){
		      var pos = $(this).offset().top;
		
		      var winTop = $(window).scrollTop();
		        if (pos < winTop + 600) {
		          $(this).addClass("slide");
		        }
		    });
		  });
		})
</script>
	<script>
	$(".dropdown-item").on("click", function(){
		   $('.navbar-collapse').collapse('hide');
		});
	</script>
</body>
</html>