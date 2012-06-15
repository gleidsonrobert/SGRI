<?php include_once("includes/test.html"); ?>
<?php
	if ($_SESSION["permissao"] <> "C" && $_SESSION["permissao"] <> "P" && $_SESSION["permissao"] <> "S")
	{
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
		echo "<script language='JavaScript'> window.alert('Voce nao tem permissao para acessar esta pagina!') </script>";
	}
?>
<?php include_once("includes/head.html"); ?>
<div class="bloco_desc_cima">
	<?php include_once("includes/info.html"); ?>
	<h2>Gerenciar Ocorrências</h2>
	<strong>Sistema de Gestão de Recursos de Infra-Estrutura</strong>
</div>
<div class="conteudo_esquerda">
	<?php include_once("includes/menu.html"); ?>
	<a class="botao" href="cadastrar_ocorrencia.php">
		<span>NOVA OCORRÊNCIA</span>
	</a>
</div>
<form id="form_pesquisa" action="#" method="post">
	<div class="conteudo_direita">
		<div class="bloco_busca">
			<div class="bloco_busca_content">
				<span class="titulo">Descrição</span>
				<input type="text"
					   id="descricaoOcorrencia"
					   name="descricaoOcorrencia"
					   maxlength="50"
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Data</span>
				<input type="text"
					   id="dataOcorrencia"
					   name="dataOcorrencia"
					   maxlength="8"
					   filter='\d'
					   format='**/**/****'
					   onBlur="pesquisa()"
				/>
			</div>
		</div>
		<div id="pagina">
			<?php include_once("../control/OcorrenciaControle.php"); $ocorrenciaControle->listarOcorrencias(); ?>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>
<script>
	function pesquisa()
	{
		var descricaoOcorrencia = document.getElementById('descricaoOcorrencia').value;
		var dataOcorrencia = document.getElementById('dataOcorrencia').value;
		
		//FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
		url="../control/OcorrenciaControle.php?descricaoOcorrencia="+descricaoOcorrencia+"&dataOcorrencia="+dataOcorrencia+"&opcaoOcorrencia=ListarOcorrencias";
		ajax(url);
	}
</script>