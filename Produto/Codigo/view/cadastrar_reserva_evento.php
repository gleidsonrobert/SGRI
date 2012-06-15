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
</div>
<div class="conteudo_direita">
	<div id="div_erro" style="display:none"></div>
	<div id="div_aguarde" style="display:none;float: left; margin-left: 200px;">&nbsp;</div>
	<div id="div_erro_header" style="display:none">&nbsp;</div>
	<form id="form" name="form" method="post" div_header="div_erro_header" div="div_erro" action="../control/ReservaControle.php">
		<input type="hidden" name="opcaoReserva" value="IncluirReservaEvento" />
		<div class="form_cadastro">
			<br class="clear" />
			<h1>Dados da Reserva</h1>
			<div>
				<span>Nome do Evento</span>
				<input type="text"
					   id="nomeEvento"
					   name="nomeEvento"
					   maxlength="50"
					   require="Informe o nome do evento"
				/>
			</div>
			<div>
				<span>Data de Início</span>
				<input type="text"
					   id="dataInicio"
					   name="dataInicio"
					   maxlength="8"
					   filter='\d'
					   format='**/**/****'
					   require="Informe a data de início do evento"
					   onBlur="pesquisa()"
				/>
			</div>
			<div>
				<span>Data de Término</span>
				<input type="text"
					   id="dataFim"
					   name="dataFim"
					   maxlength="8"
					   filter='\d'
					   format='**/**/****'
					   require="Informe a data de término do evento"
					   onBlur="pesquisa()"
				/>
			</div>
			<div>
				<br><hr><br>
				<h1>Professores Envolvidos</h1>
				<br>
				<table>
					<?php include_once("../control/ReservaControle.php"); $reservaControle->listarProfessores(); ?>
				</table>
				<div id="pagina">
					<br><hr><br>
					<h1>Salas Disponíveis</h1>
					<br>
					<table>
						===> Preencha as datas!
					</table>
					<br><br><hr><br>
					<h1>Equipamentos Disponíveis</h1>
					<br>
					<table>
						===> Preencha as datas!
					</table>
				</div>
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
<script>
	function pesquisa()
	{
		var dataInicio = document.getElementById('dataInicio').value;
		var dataFim = document.getElementById('dataFim').value;
		
		//FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
		url="../control/ReservaControle.php?dataInicio="+dataInicio+"&dataFim="+dataFim+"&opcaoReserva=ListarRecursosEvento";
		ajax(url);
	}
</script>