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
	<h2>Gerenciar Usuários</h2>
	<strong>Sistema de Gestão de Recursos de Infra-Estrutura</strong>
</div>
<div class="conteudo_esquerda">
	<?php include_once("includes/menu.html"); ?>
</div>
<div class="conteudo_direita">
	<div id="div_erro" style="display:none"></div>
	<div id="div_aguarde" style="display:none;float: left; margin-left: 200px;">&nbsp;</div>
	<div id="div_erro_header" style="display:none">&nbsp;</div>
	<form id="form" name="form" method="post" div_header="div_erro_header" div="div_erro" action="../control/UsuarioControle.php">
		<?php
			include_once("../control/UsuarioControle.php");
			if (isset($_GET["loginUsuario"]))
			{
				$loginUsuario = $_GET["loginUsuario"];
				$vetorDados = $usuarioControle->buscarDados($loginUsuario);
				$permissaoUsuario = $vetorDados["permissaoUsuario"];
				$cpfPessoa = $vetorDados["cpfPessoa"];
				$nomePessoa = $vetorDados["nomePessoa"];
			}
		?>
		<input type="hidden" name="opcaoUsuario" value="<?php echo isset($loginUsuario) ? "AlterarUsuario" : "IncluirUsuario" ?>" />
		<div class="form_cadastro">
			<br class="clear" />
			<h1>Dados do Usuário</h1>
			<div>
				<span>Login</span>
				<input type="text"
					   id="login"
					   name="loginUsuario"
					   maxlength="20"
					   require="Insira o login"
					   <?php echo isset($loginUsuario) ? "value=\"$loginUsuario\" readonly=\"readonly\"" : "" ?>
				/>
			</div>
			<div>
				<span>Pessoa</span>
				<select id="pessoa" name="cpfPessoa" require="Informe a pessoa">
					<?php include_once("../control/PessoaControle.php"); $pessoaControle->listarPessoas(); ?>
					<?php echo isset($loginUsuario) ? "<option disabled=\"disabled\" value=\"\">-----------------------------------------------------</option><option selected=\"selected\" value=\"$cpfPessoa;$permissaoUsuario\">$nomePessoa</option>" : "" ?>
				</select>
				<strong>(pessoa vinculada ao usuário)</strong>
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