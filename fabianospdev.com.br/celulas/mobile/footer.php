<div>
<?php 	include_once 'init.php'; ?>
	<div  id="dados_gerais" class="container-fluid footer text-center navbar-fixed-bottom" style="border-top: 2px solid #CCC; background-color: #003366;width: 100%; padding: 10px;">
		<span style="color: white;"><?php  date('d/m/Y h:i:s'); ?></span>
		<span style="display: inline-block;color: white;float:left;">&nbsp;&nbsp;&nbsp;&nbsp;
		Igreja:&nbsp;&nbsp;&nbsp;&nbsp; 
		<?php if (isset($_SESSION['igrejaNome']))
		{ 
		    $igreja= $_SESSION['igrejaNome'];
		    $igreja!=null?$igreja:$igreja="Nenhuma"; 
		    echo $igreja;
		}
		?></span>
		<span style="display: inline-block;float:right;height:25px;"><p style="color:white;">Nível de acesso:&nbsp;&nbsp;&nbsp;
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
		<span id="nomeIgreja" style="display:none;">
		<?php echo $_SESSION['igrejaNome'];	?>	
		</span>
		<span  style="display: block;float:right;margin-right:20px;height:25px;"><p style="color:white;">usuário:&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['usuNome'];?></p></span>		 
	</div>
</div>