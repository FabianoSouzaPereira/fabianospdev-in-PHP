<?php 
	include_once 'init.php';
	//include 'site/view/celulasReadView.php' 

	
?>	

<div id="begin-face" class="">
<section id="begin-section">
<header id="begin-header">
	<hgroup>
		<span><h1 id="hgroup-title">Crie e gerencie as células de sua igreja </h1></span>
		<h4>Você pode ter o controle sobre todas as células aqui.</h4>
	</hgroup>
	<hr>
</header>
<div id="grupo-accordion">
<button class='accordion'>CRIANDO IGREJAS</button>
<div class='panel1'>
<pre style=""><b>Cadastrando uma Igreja:</b>
1. Para criar uma igreja você deve 
   acessar o no menu principal: 
   cadastro -> igrejas -> Nova 
   igreja.
2. Tendo acessado a página de 
   cadastro da igreja preencha 
   todos os campos e click em 
   salvar.
3. Cada pastor só poderá cadastrar
   a sua igreja,e somente ele 
   poderá altera-la ou apaga-la 
   do sistema.

<b>Editando a Igreja:</b>
1. Click em   cadastro->Igreja 
2. Estando na lista de igrejas 
   (que no caso do pastor 
   conterá apenas a sua igreja)
   click  no  botão  editar  no 
   campo a direita da  linha 
   correspondente  ao  nome  da 
   igreja;
3. Altere o campo desejado 
4. click em enviar.

<b>Apagando uma Igreja:</b>
1. Click em cadastro->igreja->
   editar;
2. Estando na pagina de edição
   da igreja, click na lixeira no
   canto superior direito;
3. Você será redirecionado para
   a página lista de igrejas, 
   agora sem ver a igreja na 
   lista;
4. Caso queira, poderá recadastrar
 outra igreja, basta seguir os 
 passos de “cadastrando a igrejas”.
  
  Obs. Ao apagar uma igreja todas 
  as células que ela contem serão 
  apagadas também. 
  Ficando seus relatórios também 
  inacessíveis.
   
</pre>
</div>
    
<button class='accordion'>CRIANDO CÉLULAS</button>
<div class='panel1'>
<pre><b>Criando Células:</b>
1. Click em cadastro->células 
para ir à pagina de listagem de 
células;
2. Click no botão Nova Célula e 
preencha todos os campos do 
cadastro;
3. Click em Enviar.
    Obs.: O pastor só pode criar 
    células para a sua igreja.
    
<b>Editando Célula:</b>
1. Click em  cadastro->Células
2. Estando na lista de células 
   click no botão editar no campo 
   a direita da linha 
   correspondente ao nome da 
   célula que deseja editar;
3. Altere o campo desejado ;
4. Click em enviar.

<b>Apagando Células:</b>
1. Click em cadastro->Células->
   editar;
2. Estando na pagina de edição 
   das células, click na lixeira no
   canto superior direito;
3. Você será redirecionado para
   a página lista de células, 
   agora sem ver a célula apagada
   na lista;
4. Caso queira poderá recadastrar
   outra célula, basta seguir os 
   passos de “Criando Nova Célula”.
    Obs. Ao apagar uma célula todos
    os relatórios que ela produziu
    ficarão inacessíveis.

</pre>
</div>

<button class='accordion'>CRIANDO RELATÓRIOS</button>
<div class='panel1'>
      <pre><b>Criando Relatórios:</b>
1. Click em relatórios->criar
   relatório;
2. Selecione para qual célula 
   enviará o relatório;
3. Click Criar Relatório;
4. Preencha todos os campos do 
   relatório;
5. Click em enviar.
    Obs.: O pastor pode criar 
    relatório para as células 
    de sua igreja.
    
<b>Editando relatórios:</b>
1. Click em relatórios->Lista
   de Relatórios;
2. Estando na lista de 
   relatórios click no botão 
   editar no campo direito da 
   linha correspondente ao nome
   da célula cujo relatório
   deseja editar;
3. Caso tenha muitos relatórios
   utilize o campo pesquisa ao 
   lado do botão -Novo relatório;
4. Após localizar e abrir o 
   relatório desejado, altere os 
   campos desejados;
5. Click em enviar.

<b>Apagando relatórios</b>
1. Click em relatórios->Lista 
   de Relatórios;
2. Estando na lista de relatórios,
   click no botão editar no campo 
   direito da linha correspondente
   ao nome 
   da célula cujo relatório deseja
    apagar;
3. Você será redirecionado para a 
   página com o relatório escolhido;
4. Click no canto superior direito 
   no botão lixeira para apagar a 
   célula;
5. Caso queira poderá enviar outro 
   relatório para essa mesma célula,
   basta seguir os passos de 
   “Criando Relatórios”.
    Obs. Ao apagar um relatório seus
    dados ficarão inacessíveis.

</pre>
</div>
</div>
</br>
<div>
    <article id="art">

    </article>
</div>
</section>
<script>
/* INICIO accordion menu Control */
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}

	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
	    this.classList.toggle("active");
	    var panel = this.nextElementSibling;
	    if (panel.style.maxHeight) {
	      panel.style.maxHeight = null;
	    } else {
	      panel.style.maxHeight = panel.scrollHeight + "px";
	    }
	  });
	}
	
/* FIM accordion menu Control */
</script>
</div>
