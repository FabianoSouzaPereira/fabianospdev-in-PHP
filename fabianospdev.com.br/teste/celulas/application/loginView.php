<?php 
// ob_start();
session_start();
use modulos\dao\Login;

include_once 'modulos/dao/Connection.php';
include_once 'modulos/dao/Login.php';

if (! empty($_POST)) {
    $email = $_POST['usuEmail'];
    $password = $_POST['usuSenha'];
    $login = new Login();
    $login->getLogin($email, $password);
   $senha=$login->getSenha();
    if ($senha != 0) {
        $_SESSION['login'] = true;
        header("location: index.php");
        exit();
    } else {
        echo "Usuário ou senha incorretos.";
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
<link rel="stylesheet" href="css/estilo.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<script src="bootstrap/js/jquery-1.12.4.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<form id="login" action="" method="post" class="panel panel-warning">
		<div class="panel-heading">
			<h3>Acesso Restrito - Faça seu login</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="useremail">E-mail</label> <input type="text"
					class="form-control" name="usuEmail" id="useremail"
					placeholder="Digite seu e-mail de acesso" required autofocus
				>
			</div>
			<div class="form-group">
				<label for="senha">Senha</label> <input type="password"
					class="form-control" name="usuSenha" id="userpassword"
					placeholder="Digite sua senha" required autofocus
				>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-success" value="Acessar"> <a
					href="" class="label label-warning" style="float: right;"
				>Esqueci a senha!</a>
			</div>
		</div>
	</form>
</body>
</html>