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
</div>
<div class="conteudo_direita">
	<div id="div_erro" style="display:none"></div>
	<div id="div_aguarde" style="display:none;float: left; margin-left: 200px;">&nbsp;</div>
	<div id="div_erro_header" style="display:none">&nbsp;</div>
	<form id="form" name="form" method="post" div_header="div_erro_header" div="div_erro" action="../control/RecursoControle.php">
		<?php
			include_once("../control/RecursoControle.php");
			if (isset($_GET["idRecurso"]))
			{
				$idRecurso = $_GET["idRecurso"];
				$vetorDados = $recursoControle->buscarDadosEquipamento($idRecurso);
				$patrimonioEquipamento = $vetorDados["patrimonioEquipamento"];
				$descricaoEquipamento = $vetorDados["descricaoEquipamento"];
				$tipoEquipamento = $vetorDados["tipoEquipamento"];
				$statusEquipamento = $vetorDados["statusEquipamento"];
			}
		?>
		<input type="hidden" name="opcaoRecurso" value="<?php echo isset($idRecurso) ? "AlterarEquipamento" : "IncluirEquipamento" ?>" />
		<?php echo isset($idRecurso) ? "<input type=\"hidden\" name=\"idRecurso\" value=\"$idRecurso\" />" : "" ?>
		<div class="form_cadastro">
			<br class="clear" />
			<h1>Dados do Equipamento</h1>
			<div>
				<span>Patrimônio</span>
				<input type="text"
					   id="patrimonio"
					   name="patrimonioEquipamento"
					   maxlength="10"
					   filter='\d'
					   require="Informe o código do patrimônio"
					   <?php echo isset($idRecurso) ? "value=\"$patrimonioEquipamento\"" : "" ?>
				/>
			</div>
			<div>
				<span>Descrição</span>
				<input type="text"
					   id="descricao"
					   name="descricaoEquipamento"
					   maxlength="255"
					   require="Insira uma descrição"
					   <?php echo isset($idRecurso) ? "value=\"$descricaoEquipamento\"" : "" ?>
				/>
			</div>
			<div>
				<span>Tipo</span>
				<select id="tipo" name="tipoEquipamento" require="Insira um tipo">
					<option value="TV">TV</option>
					<option value="DVD Player">DVD Player</option>
					<option value="DataShow">DataShow</option>
					<option value="Notebook">Notebook</option>
					<?php echo isset($idRecurso) ? "<option disabled=\"disabled\" value=\"\">--------------------------------</option><option selected=\"selected\" value=\"$tipoEquipamento\">$tipoEquipamento</option>" : "" ?>
				<select/>
			</div>
			<div>
				<span>Status</span>
				<select id="status" name="statusEquipamento" require="Informe o status">
					<option value="1">Disponível</option>
					<option value="0">Em Manutenção</option>
					<?php if (isset($idRecurso)) { echo $statusEquipamento ? "<option disabled=\"disabled\" value=\"\">--------------------------------</option><option selected=\"selected\" value=\"1\">Disponível</option>" : "<option selected=\"selected\" value=\"0\">Em Manutenção</option>"; } ?>
				</select>
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