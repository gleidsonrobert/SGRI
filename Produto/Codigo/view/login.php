<?php include_once("includes/head.html"); ?>
<div class="conteudo_direita">
	<form method="post" action="../control/UsuarioControle.php">
		<input type="hidden" name="opcaoUsuario" value="Logar" />
		<div class="login_cont">
			<label>
				<span>Login:</span>
				<input type="text" name="loginUsuario" maxlength="20" />
			</label>
			<label>
				<span>Senha:</span>
				<input type="password" name="senhaUsuario" maxlength="20" />
			</label>
			<br><br><br><br><br><br><br><br>
			<input type="submit" name="enviar" value="Entrar" class="botao_input" />
			<input type="button" name="cancelar" value="Cancelar" onclick="javascript:window.location.href='index.php';" class="botao_input" />
		</div>
	</form>
</div>
<?php include_once("includes/rodape.html"); ?>