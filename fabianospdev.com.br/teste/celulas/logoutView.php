<?php
$Cancelar=null;
$Sair=null;
if(!empty($_POST)){
    $Sair = $_POST['Sair'];  
    $Cancelar= $_POST['Cancelar'];
    if ($Sair == "Sair"){
     $_SESSION['login'] =  false;
         header("location:logout.php");
         exit();
    }else{
        if ($Cancelar == "Cancelar"){
            header("location: index.php");
        }
        return;
    }
    
} 
?>
<!Doctype html>
<html lang="pt-br">
<head>
<title>Área de Logout</title>
<meta charset="utf8">
<link rel="stylesheet" href="application/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/layoutPadrao.css">
<link rel="stylesheet" href="css/estilo2.css">
</head>
<body class="bg-color-rosa">
		<form id="logout" action="" method="post"  class="panel panel-warning">
			<div class="panel-heading">
				<h3>Acesso Restrito - Deslogar mesmo?</h3>
			</div>
			</br>
			<div class="panel-body">
				<div class="form-group" style="postion: absolute;margin-left:30%;">
					<input type="submit" name="Sair" class="btn btn-success" value="Sair" >
					<input type="submit" name="Cancelar" class="btn btn-success" value="Cancelar">
				</div>
			</div>
		</form>
</body>
</html>
