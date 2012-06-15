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
	<h2>Gerenciar Equipamentos</h2>
	<strong>Sistema de Gestão de Recursos de Infra-Estrutura</strong>
</div>
<div class="conteudo_esquerda">
	<?php include_once("includes/menu.html"); ?>
	<a class="botao" href="cadastrar_equipamento.php">
		<span>NOVO EQUIPAMENTO</span>
	</a>
</div>
<form id="form_pesquisa" action="#" method="post">
	<div class="conteudo_direita">
		<div class="bloco_busca">
			<div class="bloco_busca_content">
				<span class="titulo">Patrimônio</span>
				<input type="text"
					   id="patrimonioEquipamento"
					   name="patrimonioEquipamento"
					   maxlength="10"
					   filter='\d'
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Descrição</span>
				<input type="text"
					   id="descricaoEquipamento"
					   name="descricaoEquipamento"
					   maxlength="50"
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Tipo</span>
				<select id="tipoEquipamento" name="tipoEquipamento" onChange="pesquisa()">
					<option value=""></option>
					<option value="TV">TV</option>
					<option value="DVD Player">DVD Player</option>
					<option value="DataShow">DataShow</option>
					<option value="Notebook">Notebook</option>
				</select>
				<br><br>
				<span class="titulo">Status</span>
				<select id="statusEquipamento" name="statusEquipamento" onChange="pesquisa()">
					<option value=""></option>
					<option value="1">Disponível</option>
					<option value="0">Em Manutenção</option>
				</select>
			</div>
		</div>
		<div id="pagina">
			<?php include_once("../control/RecursoControle.php"); $recursoControle->listarEquipamentos(); ?>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>
<script>
	function pesquisa()
	{
		var patrimonioEquipamento = document.getElementById('patrimonioEquipamento').value;
		var descricaoEquipamento = document.getElementById('descricaoEquipamento').value;
		var tipoEquipamento = document.getElementById('tipoEquipamento').value;
		var statusEquipamento = document.getElementById('statusEquipamento').value;
		
		//FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
		url="../control/RecursoControle.php?patrimonioEquipamento="+patrimonioEquipamento+"&descricaoEquipamento="+descricaoEquipamento+"&tipoEquipamento="+tipoEquipamento+"&statusEquipamento="+statusEquipamento+"&opcaoRecurso=ListarEquipamentos";
		ajax(url);
	}
</script>