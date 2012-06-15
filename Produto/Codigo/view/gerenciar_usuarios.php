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
	<a class="botao" href="cadastrar_usuario.php">
		<span>NOVO USUÁRIO</span>
	</a>
</div>
<form id="form_pesquisa" action="#" method="post">
	<div class="conteudo_direita">
		<div class="bloco_busca">
			<div class="bloco_busca_content">
				<span class="titulo">Nome</span>
				<input type="text"
					   id="nomeUsuario"
					   name="nomeUsuario"
					   maxlength="50"
					   onKeyUp="pesquisa()"
				/>
			</div>
		</div>
		<div id="pagina">
			<?php include_once("../control/UsuarioControle.php"); $usuarioControle->listarUsuarios(); ?>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>
<script>
	function pesquisa()
	{
		var nomeUsuario = document.getElementById('nomeUsuario').value;
		
		//FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
		url="../control/UsuarioControle.php?nomeUsuario="+nomeUsuario+"&opcaoUsuario=ListarUsuarios";
		ajax(url);
	}
</script>