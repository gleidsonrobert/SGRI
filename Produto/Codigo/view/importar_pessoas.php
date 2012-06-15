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
	<h2>Importar Professores e Funcionários</h2>
	<strong>Sistema de Gestão de Recursos de Infra-Estrutura</strong>
</div>
<div class="conteudo_esquerda">
	<?php include_once("includes/menu.html"); ?>
</div>
<form id="form_importa" enctype="multipart/form-data" action="../control/PessoaControle.php" method="post">
	<input type="hidden" name="opcaoPessoa" value="ImportarPessoas" />
	<div class="conteudo_direita">
		<div class="bloco_busca">
			<div class="bloco_busca_content">
				<span class="titulo">Arquivo</span>
				<input type="text" id="fakeupload" name="fakeupload" />
				<input type="file" id="realupload" name="arquivo" onchange="this.form.fakeupload.value = this.value;" />
				<br><br>
				<a class="botao" href="javascript:document.getElementById('form_importa').submit();">
					<span>IMPORTAR</span>
				</a>
				<span class="obs">(Selecione um arquivo clicando no campo acima e clique em IMPORTAR) >>></span>
			</div>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>