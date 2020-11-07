<?php ob_start();

use mobile\modulos\dao\Login;
use mobile\modulos\Igreja;

require 'init.php';
include_once 'modulos/dao/Connection.php';
include_once 'modulos/dao/Login.php';
include_once 'modulos/Igreja.php';

if(!empty($_POST)){
    $id=null;
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];
/*     if(strlen($email) < 4  || strlen($password) < 4){
        echo "<div style="."display:block;background-color:yellow;margin:20px auto auto auto".">Os campos devem ter mais de 4 caracteres!</div>";
        return;
    } */
    
    $login = new Login();
    $login->getLogin($email, $password);
    $id=$login->getId();
    $uid=$login->getUid();
    $nome=$login->getNome();
    $sobreNome=$login->getSobreNome();
    $senha=$login->getSenha();
    $tentativas=$login->getTentativas();
    $bloqueado=$login->getBloqueado();
    $data=$login->getData();
    $tipo=$login->getTipo();
    $acesso=$login->getAcesso();
    
    if ($uid != ""){
         $_SESSION['id']= $id;
         $_SESSION['uid']= $uid;
         $_SESSION['nome']= $nome;
         $_SESSION['sobreNome']= $sobreNome;
         $_SESSION['email']= $email;
         $_SESSION['senha']=$senha;        
         $_SESSION['tentativas']= $tentativas;
         $_SESSION['bloqueado']= $bloqueado;
         $_SESSION['data']= $data;
         $_SESSION['tipo']= $tipo;
         $_SESSION['acesso']= $acesso;
         $_SESSION['login']=  true;
         $_SESSION['posted']= false;
         $_SESSION['updated']= false;
         $_SESSION['deleted']= false;
         
    $ig= new Igreja();
    $logtipo=null;
	$ret=null;
	$logtipo=$_SESSION['tipo'];
	
        switch ($logtipo) {
                case 1: $ig->adminRead();
                        $ret = $ig->getDados();
                   break;
                case 2: $ig->coordenadorRead();
                        $ret = $ig->getDados();
                   break;
                case 3: $ig->pastorRead();
                        $ret = $ig->getDados();
                   break;
                case 4: $ig->liderRead();
                        $ret = $ig->getDados();
                   break;
                case 5: $ig->colaboradorRead();
                        $ret = $ig->getDados();
                   break;
                case 6: $ig->comumRead();
                        $ret = $ig->getDados();
                   break;
                case 7: '0';
                   break;
                default:
                    ;
                break;
        }
                if(is_array($ret)){
                    Foreach($ret as $raw) {
                     $id= $raw['chuId']; $igreja= $raw['chuIgreja'];
                     $_SESSION['igrejaId']= $id; $_SESSION['igrejaNome']= $igreja;
                    }
                }
        
             header("location: index.php");
             exit();
    }else{
        if ($login->getBloqueado() == "SIM"){
            echo "<!Doctype html>
                  <html lang='pt-br'>
                    <head>
                    	<title>Área de Login</title>
                    	<meta charset='utf-8'>
                    <!-- Chamada do CSS -->
                    <link rel='stylesheet' href='mobile/bootstrap/css/bootstrap.css'>
                    </head>
                 <body>
                    <div id='voltar' style='float:left; width: 90%;display: inline-block;'><a href='index.php' id='voltar' style='position: absolute;margin: 15px 0px 0px 15px;font-size:20px;'><span class='glyphicon glyphicon-chevron-left'></span> Voltar</a></div>
                    <div class='panel-body' style='width:80%; margin: 0px auto 0px auto;'>
                        <div class='panel-heading alert alert-info'><h1>Usuário está bloqueado.</h1></div>
                    </div>                    
                    <header class='jumbotron panel-heading' style='width:80%; margin: 0px auto 0px auto;'>                      
                        <p>Lembre-se que após cinco tentativas erradas ocorre o bloqueio do usuário.</p>
                        <p>Caso ocorra o bloqueio somente um usuário de nível superior poderá desbloquea-lo.</p>
                        <p>Procure o administrador do sistema.</p>
                    </header>
            
                 </body>
                 </html>";
                exit();
        }else{
            echo "<!Doctype html>
                  <html lang='pt-br'>
                    <head>
                    	<title>Área de Login</title>
                    	<meta charset='utf-8'>
                    <!-- Chamada do CSS -->
                    <link rel='stylesheet' href='mobile/bootstrap/css/bootstrap.css'>
                    </head>
                 <body>
                    <div id='voltar' style='float:left; width: 90%;display: inline-block;'><a href='index.php' id='voltar' style='position: absolute;margin: 15px 0px 0px 15px;font-size:20px;'><span class='glyphicon glyphicon-chevron-left'></span> Voltar</a></div>
                    <div class='panel-body' style='width:80%; margin: 0px auto 0px auto;'>
                        <div class='panel-heading alert alert-info'><h1>Usuário ou senha incorretos.</h1></div>
                    </div>                    
                    <header class='jumbotron panel-heading' style='width:80%; margin: 0px auto 0px auto;'>
                        <p>Verifique seus dados e tente novamente.</p>
                        <p>Lembre-se que após cinco tentativas erradas ocorre o bloqueio do usuário.</p>
                        <p>Caso ocorra o bloqueio somente um usuário de nível superior poderá desbloquea-lo.</p>
                    </header>
            
                 </body>
                 </html>";
                exit();
    }
  }
} 
?>
<!Doctype html>
<html lang="pt-br">
<head>
	<title>Área de Login</title>
	<meta charset="utf-8">
<!-- Chamada do CSS -->
<link rel="stylesheet" href="../application/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/login.css">

</head> 
	<body class="bg-color-rosa">
		<form id="login" action="" method="post"class="panel panel-warning">
			<div class="panel-heading">
				<h1>Acesso Restrito - Faça seu login</h1>
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
					<input type="submit" class="btn btn-success" value="Acessar">
					<input type="reset" class="btn btn-cancel" value="Cancelar">
					<div style="margin-left:50%;margin-top:20px;float:rigth;"><a href=""  class="label label-warning hidden" >Esqueci a senha!</a></div>
				</div>
			</div>
		</form>
	</body>
</html>