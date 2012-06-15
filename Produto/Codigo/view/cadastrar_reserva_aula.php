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
	<h2>Gerenciar Reservas Para Aulas</h2>
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
		<input type="hidden" name="opcaoReserva" value="IncluirReservaAula" />
		<div class="form_cadastro">
			<br class="clear" />
			<h1>Dados da Reserva</h1>
			<div>
				<span>Data da Aula</span>
				<input type="text"
					   id="dataAula"
					   name="dataAula"
					   maxlength="8"
					   filter='\d'
					   format='**/**/****'
					   require="Informe a data da aula"
					   onBlur="pesquisa()"
					   onKeyUp="limpaDados()"
				/>
			</div>
			<div id="pagina">
				<div>
					<span>Turma</span>
					<select id="disciplinaTurma" name="disciplinaTurma" require="Informe a turma" onChange="pesquisa()" onClick="limpaDados2()">
						<option disabled="disabled" value=""> ===> Preencha a data! </option>
					</select>
				</div>
				<div>
					<span>Horário</span>
					<select id="horarioTurma" name="horarioTurma" require="Informe o horário" onChange="pesquisa()">
						<option disabled="disabled" value=""> ===> Preencha a data! </option>
					</select>
				</div>
				<div>
					<br><hr><br>
					<h1>Equipamentos Disponíveis</h1>
					<br>
					<table>
						===> Preencha a data!
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
	function limpaDados()
	{
		document.getElementById('disciplinaTurma').value = "";
		document.getElementById('horarioTurma').value = "";
	}
	function limpaDados2()
	{
		document.getElementById('horarioTurma').value = "";
	}
	function pesquisa()
	{
		var dataAula = document.getElementById('dataAula').value;
		var disciplinaTurma = document.getElementById('disciplinaTurma').value;
		var horarioTurma = document.getElementById('horarioTurma').value;
		
		//FUNÇÃO QUE MONTA A URL E CHAMA A FUNÇÃO AJAX
		url="../control/ReservaControle.php?dataAula="+dataAula+"&disciplinaTurma="+disciplinaTurma+"&horarioTurma="+horarioTurma+"&opcaoReserva=ListarRecursosAula";
		ajax(url);
	}
</script>