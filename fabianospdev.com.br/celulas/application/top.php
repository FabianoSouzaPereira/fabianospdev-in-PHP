<?php 	include_once 'init.php'; $tipo=$_SESSION['tipo']; ?>
<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header" style="margin-left:-75px;">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#myNavbar"
				>
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"
					></span>
				</button>
				<a class="navbar-brand" href="index.php"> <span
					class="glyphicon glyphicon-globe"
				> </span> IGREJA EM CÉLULAS
				</a>
			</div>

			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">INICIO</a></li>
					<li><a href="index.php?pag=modulos_view_churchReadView">IGREJAS</a></li>
					<li><a href="index.php?pag=modulos_view_celulasReadView">CÉLULAS</a></li>
					<li><a href="index.php?pag=modulos_view_userReadView">USUÁRIOS</a></li>
					<li><a href="index.php?pag=modulos_view_relatorioView">RELATÓRIOS</a></li>
					<li><a href="index.php?pag=modulos_view_sobreView">SOBRE</a></li>
					<li><a id="link-user" title="Clique aqui para realizar o acesso"
						href="" data-toggle="modal" data-target="#modal-login"
					> <span class="glyphicon glyphicon-user"><label class="acessoSmart"
								style='display: none'
							> Acessar</label> </span> <!-- Acesso -->
					</a></li>
					<li><a href="" data-toggle="modal" data-target="#modal-pesquisa"><span
							class="glyphicon glyphicon-search"
						><label class="acessoSmart" style='display: none'> Pesquisar</label>
						</span></a></li>
						<li role="presentation"><a href="../logoutView.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
			<!-- Modal para pesquisa de produtos -->
			<div style="margin-top: 10%;" id="modal-login" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Login</h4>
			      </div>
			      <div class="modal-body">
					<form action="loginView.php" class="form-inline">
					<button title="Clique para logar como usuário" type="submit" class="btn btn-primary  btn-lg  btn-block">
						Trocar usuário
					<span class="" ></span></button>
					<button title="Clique para logar como administrador" type="submit" class="btn btn-primary btn-lg  btn-block disabled">
						Logar como administrador( em construção ) 
 					<span class="" ></span></button>
	  					<br />
	  					<!-- 
	  					<label>
	  					<input type="radio" name="dentroCategoria" value="1" /> - Pesquisar dentro da categoria</label>
	  					<br />
	  					<label>
	  					<input type="radio" name="dentroCategoria" value="0" /> - Pesquisar em todo o site</label>
	  					 -->
	  				</form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"> </span> Fechar</button>
			       
			      </div>
			    </div>
			
			  </div>
			</div>
			<!-- Modal -->

		<!-- Modal para pesquisa de produtos -->
			<div style="margin-top: 10%;" id="modal-pesquisa" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Pesquisa</h4>
			      </div>
			      <div class="modal-body">
					<form action="" class="form-inline">
	    				<input value="<?php echo @$_GET['p']; ?>" type="text" name="p" id="fpesquisa" class="form-control" size="50" placeholder="Pesquise por nome descricao ou categoria." >
	    				<button title="Clique para efetuar a pesquisa" type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-search" > </span> </button>
	  					<br />
	  					<!-- 
	  					<label>
	  					<input type="radio" name="dentroCategoria" value="1" /> - Pesquisar dentro da categoria</label>
	  					<br />
	  					<label>
	  					<input type="radio" name="dentroCategoria" value="0" /> - Pesquisar em todo o site</label>
	  					 -->
	  				</form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"> </span> Fechar</button>
			       
			      </div>
			    </div>
			
			  </div>
			</div>
			<!-- Modal -->
