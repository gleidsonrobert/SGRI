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
				$vetorDados = $recursoControle->buscarDadosSala($idRecurso);
				$numeroSala = $vetorDados["numeroSala"];
				$descricaoSala = $vetorDados["descricaoSala"];
				$localizacaoSala = $vetorDados["localizacaoSala"];
				$capacidadeSala = $vetorDados["capacidadeSala"];
				$tipoSala = $vetorDados["tipoSala"];
			}
		?>
		<input type="hidden" name="opcaoRecurso" value="<?php echo isset($idRecurso) ? "AlterarSala" : "IncluirSala" ?>" />
		<?php echo isset($idRecurso) ? "<input type=\"hidden\" name=\"idRecurso\" value=\"$idRecurso\" />" : "" ?>
		<div class="form_cadastro">
			<br class="clear" />
			<h1>Dados da Sala</h1>
			<div>
				<span>Número</span>
				<input type="text"
					   id="numero"
					   name="numeroSala"
					   maxlength="4"
					   filter='\d'
					   require="Insira o número da sala"
					   <?php echo isset($idRecurso) ? "value=\"$numeroSala\"" : "" ?>
				/>
			</div>
			<div>
				<span>Descrição</span>
				<input type="text"
					   id="descricao"
					   name="descricaoSala"
					   maxlength="255"
					   require="Insira uma descrição"
					   <?php echo isset($idRecurso) ? "value=\"$descricaoSala\"" : "" ?>
				/>
			</div>
			<div>
				<span>Localização</span>
				<input type="text"
					   id="localizacao"
					   name="localizacaoSala"
					   maxlength="20"
					   require="Informe a localização"
					   <?php echo isset($idRecurso) ? "value=\"$localizacaoSala\"" : "" ?>
				/>
			</div>
			<div>
				<span>Capacidade</span>
				<input type="text"
					   id="capacidade"
					   name="capacidadeSala"
					   maxlength="3"
					   filter='\d'
					   require="Informe a capacidade"
					   <?php echo isset($idRecurso) ? "value=\"$capacidadeSala\"" : "" ?>
				/>
				<strong>(quantidade de alunos)</strong>
			</div>
			<div>
				<span>Tipo</span>
				<select id="tipo" name="tipoSala" require="Informe o tipo">
					<option value="Sala de Aula">Sala de Aula</option>
					<option value="Laboratorio">Laboratório</option>
					<option value="Multimeio">Multimeio</option>
					<option value="Auditorio">Auditório</option>
					<?php echo isset($idRecurso) ? "<option disabled=\"disabled\" value=\"\">--------------------------------</option><option selected=\"selected\" value=\"$tipoSala\">$tipoSala</option>" : "" ?>
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