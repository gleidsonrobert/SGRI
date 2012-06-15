<?php include_once("includes/test.html"); ?>
<?php
	if ($_SESSION["permissao"] <> "C" && $_SESSION["permissao"] <> "S")
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
	<a class="botao" href="cadastrar_reserva_evento.php">
		<span>EFETUAR RESERVA</span>
	</a>
</div>
<form id="form_pesquisa" action="#" method="post">
	<div class="conteudo_direita">
		<div class="bloco_busca">
			<div class="bloco_busca_content">
				<span class="titulo">Evento</span>
				<input type="text"
					   id="nomeEvento"
					   name="nomeEvento"
					   maxlength="50"
					   onKeyUp="pesquisa()"
				/>
				<br><br>
				<span class="titulo">Data Even.</span>
				<input type="text"
					   id="dataEvento"
					   name="dataEvento"
					   maxlength="8"
					   filter='\d'
					   format='**/**/****'
					   onBlur="pesquisa()"
				/>
			</div>
		</div>
		<div id="pagina">
			<?php include_once("../control/ReservaControle.php"); $reservaControle->listarReservasEvento(); ?>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>
<script>
	function pesquisa()
	{
		var nomeEvento = document.getElementById('nomeEvento').value;
		var dataEvento = document.getElementById('dataEvento').value;
		
		//FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
		url="../control/ReservaControle.php?nomeEvento="+nomeEvento+"&dataEvento="+dataEvento+"&opcaoReserva=ListarReservasEvento";
		ajax(url);
	}
</script>