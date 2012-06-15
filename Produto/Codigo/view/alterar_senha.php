<?php include_once("includes/test.html"); ?>
<?php
	if ($_SESSION["permissao"] == "S")
	{
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
		echo "<script language='JavaScript'> window.alert('Voce nao tem permissao para acessar esta pagina!') </script>";
	}
?>
<?php include_once("includes/head.html"); ?>
<div class="bloco_desc_cima">
	<h2>Alterar Senha de <?php echo $_SESSION["nome"]; ?>
	</h2>
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
		<input type="hidden" name="opcaoUsuario" value="AlterarSenha">
		<input type="hidden" name="loginUsuario" value="<?php echo $_SESSION["usuario"] ?>">
		<div class="form_cadastro">
			<br class="clear" />
			<div>
				<span>Senha Atual</span>
				<input type="password" id="senhaAtual" name="senhaAtual" maxlength="20" require="Insira a senha atual" />
			</div>
			<br><br><br>
			<div>
				<span>Nova Senha</span>
				<input type="password" id="senhaNova" name="senhaNova" maxlength="20" require="Insira uma senha nova" />
			</div>
			<div>
				<span>Confirmar Senha</span>
				<input type="password" id="senhaNova2" name="senhaNova2" maxlength="20" require="Insira a confirmação da senha nova" />
			</div>
			<br class="clear" />
			<br class="clear" />
			<br class="clear" />
		</div>
		<div class="botoes">
			<a href="javascript: valida_senha()" class="botao">
				<span>GRAVAR</span>
			</a>
			<a href="javascript: history.go(-1)" class="botao">
				<span>CANCELAR</span>
			</a>
		</div>
	</form>
</div>
<?php include_once("includes/rodape.html"); ?>