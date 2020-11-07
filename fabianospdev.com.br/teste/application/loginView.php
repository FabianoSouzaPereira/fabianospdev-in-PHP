<?php //ob_start();
session_start(); 
use application\dao\Login;

include_once 'dao/connection.php';
include_once 'dao/login.php';

if(!empty($_POST)){
    $email = $_POST['userEmail'];
    $password = $_POST['userSenha'];
    $login = new Login();
    $userLog = $login->getLogin($email, $password);
    $pass = array_column($userLog,'password');
    if ($userLog != 0){
     $_SESSION['Login'] =  true;
         header("location: index.php");
         exit();
    }else{
        echo "Usu·rio ou senha incorretos.";
        exit();
    }
    
} 
?>
<!Doctype html>
<html lang="pt-br">
	<head>
		<title>Cadastro Escola</title>
		<meta charset="utf8">
		<!-- Chamada do CSS -->
		<link rel="stylesheet" href="css/estilo.css" >
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<script src="application/bootstrap/js/jquery-1.12.4.min.js"></script>
  		<script src="application/bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<form id="login" action="" method="post"  class="panel panel-warning">
			<div class="panel-heading">
				<h3>Acesso Restrito - Fa√ßa seu login</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="useremail">E-mail</label>
					<input type="text" class="form-control" name="useremail" id="useremail" placeholder="Digite seu e-mail de acesso" required autofocus >
				</div>
				<div class="form-group">
					<label for="senha">Senha</label>
					<input type="password" class="form-control" name="userpassword" id="userpassword" placeholder="Digite sua senha" required autofocus >
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" value="Acessar" >
					<a href="" class="label label-warning" style="float:right;">Esqueci a senha!</a>
				</div>
			</div>
		</form>
	</body>
</html>