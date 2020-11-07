<div style="background-color: red;">
<?php 	include_once 'init.php'; ?>
	<div id="dados_gerais" class="container-fluid text-center footer navbar-fixed-bottom" style="border-top: 2px solid #CCC; background-color: #003366; padding: 10px;">
		<span style="color: white;"><?php echo date('d/m/Y h:i:s'); ?></span>
		<span  style="display: block;float:right;height:25px;"><p style="color:white;">Nível de acesso:&nbsp;&nbsp;&nbsp;
        	<?php 	switch ($_SESSION['tipo']) {
            case 1:
                echo "Administrador";
                break;
            case 2:
                echo "Coordenador";
                break;
            case 3:
                echo "Pastor";
                break;
            case 4:
                echo "Lider";
                break;
            case 5:
                echo "Colaborador";
                break;
            case 6:
                echo "Comum";
                break;
            case 7:
                echo "Sem Acesso a nada";
                break;
            Default: 
                echo "Sem acesso";
                break;
        	}
            ?>

		</p></span> 
		<span  style="display: block;float:right;margin-right:20px;height:25px;"><p style="color:white;">usuário:&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['usuNome'];?></p></span>		 
	</div>
</div>