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
</div>
<div class="conteudo_direita">
	<div id="div_erro" style="display:none"></div>
	<div id="div_aguarde" style="display:none;float: left; margin-left: 200px;">&nbsp;</div>
	<div id="div_erro_header" style="display:none">&nbsp;</div>
	<form id="form" name="form" method="post" div_header="div_erro_header" div="div_erro" action="../control/OcorrenciaControle.php">
		<input type="hidden" name="opcaoOcorrencia" value="IncluirOcorrencia" />
		<div class="form_cadastro">
			<br class="clear" />
			<h1>Dados da Ocorrência</h1>
			<div>
				<span>Descrição</span>
				<input type="text"
					   id="descricaoOcorrencia"
					   name="descricaoOcorrencia"
					   maxlength="255"
					   require="Insira uma descrição"
				/>
			</div>
			<div>
				<span>Data</span>
				<input type="text"
					   id="dataOcorrencia"
					   name="dataOcorrencia"
					   maxlength="8"
					   filter='\d'
					   format='**/**/****'
					   require="Insira uma data"
				/>
			</div>
			<br class="clear" />
			<br class="clear" />
			<br class="clear" />
		</div>
		<div class="botoes">
			<a href="javascript: envia_dados()" class="botao">
				<span>GRAVAR</span>
			</a>
			<a href="javascript: history.go(-1)" class="botao">
				<span>CANCELAR</span>
			</a>
		</div>
	</form>
</div>
<?php include_once("includes/rodape.html"); ?>