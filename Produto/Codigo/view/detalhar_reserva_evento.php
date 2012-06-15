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
	<h2>Gerenciar Reservas Para Eventos</h2>
	<strong>Sistema de Gestão de Recursos de Infra-Estrutura</strong>
</div>
<div class="conteudo_esquerda">
	<?php include_once("includes/menu.html"); ?>
	<a class="botao" href="javascript: history.go(-1)">
		<span>VOLTAR</span>
	</a>
</div>
<form id="form_pesquisa" action="#" method="post">
	<div class="conteudo_direita">
		<div>
			<?php include_once("../control/ReservaControle.php"); $reservaControle->detalharReservaEvento($_GET["idReserva"]); ?>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>