<?php include_once("includes/test.html"); ?>
<?php include_once("includes/head.html"); ?>
<div class="bloco_desc_cima">
	<?php include_once("includes/info.html"); ?>
	<h2>Emitir Relatórios</h2>
	<strong>Sistema de Gestão de Recursos de Infra-Estrutura</strong>
</div>
<div class="conteudo_esquerda">
	<?php include_once("includes/menu.html"); ?>
</div>
<form id="form_pesquisa" action="#" method="post">
	<div class="conteudo_direita">
		<div>
			<?php
				if ($_SESSION["permissao"] == "C" || $_SESSION["permissao"] == "P" || $_SESSION["permissao"] == "S")
				{
					echo "
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"#\">
									<span>GERAR RELATÓRIO</span>
								</a>
							</div>
							<h1>Histórico de Reservas Atendidas</h1>
							<span>Informações</span>
						</div>
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"#\">
									<span>GERAR RELATÓRIO</span>
								</a>
							</div>
							<h1>Reservas Atuais</h1>
							<span>Informações</span>
						</div>
					";
				}
				
				if ($_SESSION["permissao"] == "F" || $_SESSION["permissao"] == "S")
				{
					echo "
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"#\">
									<span>GERAR RELATÓRIO</span>
								</a>
							</div>
							<h1>Equipamentos Mais Utilizados</h1>
							<span>Informações</span>
						</div>
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"#\">
									<span>GERAR RELATÓRIO</span>
								</a>
							</div>
							<h1>Ocorrências</h1>
							<span>Informações</span>
						</div>
					";
				}
			?>
		</div>
	</div>
</form>
<?php include_once("includes/rodape.html"); ?>