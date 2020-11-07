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
<link rel="stylesheet" href="../application/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/login.css">
</head>
<body class="bg-color-rosa">
		<form id="logout" action="" method="post"  class="panel panel-warning">
			<div class="panel-heading">
				<h1>Acesso Restrito - Deslogar mesmo?</h1>
			</div>
			</br>
			<div class="panel-body">
				<div class="form-group">
					<input type="submit" name="Sair" class="btn btn-success" style="font-size:50px;" value="Sair" >
					<input type="submit" name="Cancelar" class="btn btn-success" style="margin-left:4px;font-size:50px;" value="Cancelar">
				</div>
			</div>
		</form>
</body>
</html>
