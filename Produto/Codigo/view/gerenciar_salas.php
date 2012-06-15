<?php include_once("includes/test.html"); ?>
<?php
	if ($_SESSION["permissao"] <> "F" && $_SESSION["permissao"] <> "S")
	{
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
		echo "<script language='JavaScript'> window.alert('Voce nao tem permissao para acessar esta pagina!') </script>";
	}
?>
<?php include_once("includes/head.html"); ?>
<div class="bloco_desc_cima">
	<?php include_once("includes/info.html"); ?>
	<h2>Gerenciar Salas</h2>
	<strong>Sistema de Gestão de Recursos de Infra-Estrutura</strong>
</div>
<div class="conteudo_esquerda">
	<?php include_once("includes/menu.html"); ?>
	<a class="botao" href="cadastrar_sala.php">
		<span>NOVA SALA</span>
	</a>
</div>
<form id="form_pesquisa" action="#" method="post">
	<div class="conteudo_direita">
		<div class="bloco_busca">
			<div class="bloco_busca_content">
				<span class="titulo">Número</span>
				<input type="text"
					   id="numeroSala"
					   name="numeroSala"
					   maxlength="4"
					   filter='\d'
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Descrição</span>
				<input type="text"
					   id="descricaoSala"
					   name="descricaoSala"
					   maxlength="50"
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Localização</span>
				<input type="text"
					   id="localizacaoSala"
					   name="localizacaoSala"
					   maxlength="20"
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Capacidade</span>
				<input type="text"
					   id="capacidadeSala"
					   name="capacidadeSala"
					   maxlength="3"
					   filter='\d'
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Tipo</span>
				<select id="tipoSala" name="tipoSala" onChange="pesquisa()">
					<option value=""></option>
					<option value="Sala de Aula">Sala de Aula</option>
					<option value="Laboratorio">Laboratório</option>
					<option value="Multimeio">Multimeio</option>
					<option value="Auditorio">Auditório</option>
				</select>
			</div>
		</div>
		<div id="pagina">
			<?php include_once("../control/RecursoControle.php"); $recursoControle->listarSalas(); ?>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>
<script>
	function pesquisa()
	{
		var numeroSala = document.getElementById('numeroSala').value;
		var descricaoSala = document.getElementById('descricaoSala').value;
		var localizacaoSala = document.getElementById('localizacaoSala').value;
		var capacidadeSala = document.getElementById('capacidadeSala').value;
		var tipoSala = document.getElementById('tipoSala').value;
		
		//FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
		url="../control/RecursoControle.php?numeroSala="+numeroSala+"&descricaoSala="+descricaoSala+"&localizacaoSala="+localizacaoSala+"&capacidadeSala="+capacidadeSala+"&tipoSala="+tipoSala+"&opcaoRecurso=ListarSalas";
		ajax(url);
	}
</script>