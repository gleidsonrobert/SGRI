<?php
	include_once ("../model/EquipamentoBD.php");
	include_once ("../model/SalaBD.php");
	
	/*
	 * Finalidade: Controlar as classes de recurso através das informações fornecidas pela interface
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 12/04/2012
	 */
	class RecursoControle
	{
		/*
		 * Construtora
		 * Função: Instanciar o objeto de controle de recurso
		 */
		public function RecursoControle()
		{
			/* Variável recebe a opção de ação passada pelo formulário através da variavel opcaoRecurso do tipo hidden */
			$opcaoRecurso = $_REQUEST['opcaoRecurso'];
			
			/* Define as ações de acordo com a opção */
			switch ($opcaoRecurso)
			{
				case 'IncluirEquipamento': $this->incluirEquipamento(); break;
				case 'AlterarEquipamento':  $this->alterarEquipamento(); break;
				case 'ExcluirEquipamento':  $this->excluirEquipamento(); break;
				case 'IncluirSala': $this->incluirSala(); break;
				case 'AlterarSala':  $this->alterarSala(); break;
				case 'ExcluirSala':  $this->excluirSala(); break;
				case 'ListarEquipamentos': $this->listarEquipamentos(); break;
				case 'ListarSalas': $this->listarSalas(); break;
			}
		}
		
		/*
		 * Função: Incluir equipamento no sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function incluirEquipamento()
		{
			$model = new EquipamentoBD();
			
			$model->definirPatrimonioEquipamento($_POST['patrimonioEquipamento']);
			$model->definirDescricaoEquipamento($_POST['descricaoEquipamento']);
			$model->definirTipoEquipamento($_POST['tipoEquipamento']);
			$model->definirStatusEquipamento($_POST['statusEquipamento']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_equipamentos.php\">";
			
			if ($model->incluirRecurso())
			{
				echo "<script language='JavaScript'> window.alert('Registro incluido com sucesso!') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro na inclusao do registro!') </script>";
		}
		
		/*
		 * Função: Incluir sala no sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function incluirSala()
		{
			$model = new SalaBD();
			
			$model->definirNumeroSala($_POST['numeroSala']);
			$model->definirDescricaoSala($_POST['descricaoSala']);
			$model->definirLocalizacaoSala($_POST['localizacaoSala']);
			$model->definirCapacidadeSala($_POST['capacidadeSala']);
			$model->definirTipoSala($_POST['tipoSala']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_salas.php\">";
			
			if ($model->incluirRecurso())
			{
				echo "<script language='JavaScript'> window.alert('Registro incluido com sucesso!') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro na inclusao do registro!') </script>";
		}
		
		/*
		 * Função: Alterar equipamento do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function alterarEquipamento()
		{
			$model = new EquipamentoBD();
			
			$model->definirIdRecurso($_POST['idRecurso']);
			$model->definirPatrimonioEquipamento($_POST['patrimonioEquipamento']);
			$model->definirDescricaoEquipamento($_POST['descricaoEquipamento']);
			$model->definirTipoEquipamento($_POST['tipoEquipamento']);
			$model->definirStatusEquipamento($_POST['statusEquipamento']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_equipamentos.php\">";
			
			if ($model->alterarRecurso())
				echo "<script language='JavaScript'> window.alert('Registro alterado com sucesso!') </script>";
			else
				echo "<script language='JavaScript'> window.alert('Erro na alteracao do registro!') </script>";
		}
		
		/*
		 * Função: Alterar sala do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function alterarSala()
		{
			$model = new SalaBD();
			
			$model->definirIdRecurso($_POST['idRecurso']);
			$model->definirNumeroSala($_POST['numeroSala']);
			$model->definirDescricaoSala($_POST['descricaoSala']);
			$model->definirLocalizacaoSala($_POST['localizacaoSala']);
			$model->definirCapacidadeSala($_POST['capacidadeSala']);
			$model->definirTipoSala($_POST['tipoSala']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_salas.php\">";
			
			if ($model->alterarRecurso())
				echo "<script language='JavaScript'> window.alert('Registro alterado com sucesso!') </script>";
			else
				echo "<script language='JavaScript'> window.alert('Erro na alteracao do registro!') </script>";
		}
		
		/*
		 * Função: Excluir equipamento do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function excluirEquipamento()
		{
			$model = new EquipamentoBD();
			
			$model->definirIdRecurso($_GET['idRecurso']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_equipamentos.php\">";
			
			if ($model->excluirRecurso())
				echo "<script language='JavaScript'> window.alert('Registro excluido com sucesso!') </script>";
			else
				echo "<script language='JavaScript'> window.alert('Erro na exclusao do registro!') </script>";
		}
		
		/*
		 * Função: Excluir sala do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function excluirSala()
		{
			$model = new SalaBD();
			
			$model->definirIdRecurso($_GET['idRecurso']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_salas.php\">";
			
			if ($model->excluirRecurso())
				echo "<script language='JavaScript'> window.alert('Registro excluido com sucesso!') </script>";
			else
				echo "<script language='JavaScript'> window.alert('Erro na exclusao do registro!') </script>";
		}
		
		/*
		 * Função: Listar todos os equipamentos do sistema, possibilitando filtragem pela descrição do equipamento
		 * Retorno: Lista com os equipamentos filtrados
		 */
		public function listarEquipamentos()
		{
			//$result = EquipamentoBD::pesquisarRecurso("", $_POST["patrimonioEquipamento"], $_POST["descricaoEquipamento"], $_POST["tipoEquipamento"], $_POST["statusEquipamento"]);
			$result = EquipamentoBD::pesquisarRecurso("", $_GET["patrimonioEquipamento"], $_GET["descricaoEquipamento"], $_GET["tipoEquipamento"], $_GET["statusEquipamento"]);
			
			if (mysql_num_rows($result) > 0)
			{
				while ($registro = mysql_fetch_array($result))
				{
					$idRecurso = $registro["idRecurso"];
					$patrimonioEquipamento = $registro["patrimonioEquipamento"];
					$descricaoEquipamento = $registro["descricaoEquipamento"];
					$tipoEquipamento = $registro["tipoEquipamento"];
					if ($registro["statusEquipamento"])
						$statusEquipamento = "Disponivel";
					else
						$statusEquipamento = "Em Manutencao";
					
					echo "
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"cadastrar_equipamento.php?idRecurso=$idRecurso\">
									<span>ALTERAR</span>
								</a>
								&nbsp;&nbsp;&nbsp;
								<a style=\"float: right;\" class=\"botao\" onclick=\"javascript:return confirma_exclusao()\" href=\"../control/RecursoControle.php?opcaoRecurso=ExcluirEquipamento&idRecurso=$idRecurso\">
									<span>EXCLUIR</span>
								</a>
							</div>
							<h1>$descricaoEquipamento</h1>
							<span>
								Patrimonio: $patrimonioEquipamento <br>
								Tipo: $tipoEquipamento <br>
								Status: $statusEquipamento
							</span>
						</div>
					";
				}
			}
			else
			{
				echo "<h1>Nenhum resultado encontrado!</h1>";
			}
		}
		
		/*
		 * Função: Listar todos as salas do sistema, possibilitando filtragem pela descrição da sala
		 * Retorno: Lista com as salas filtradas
		 */
		public function listarSalas()
		{
			//$result = SalaBD::pesquisarRecurso("", $_POST["numeroSala"], $_POST["descricaoSala"], $_POST["localizacaoSala"], $_POST["capacidadeSala"], $_POST["tipoSala"]);
			$result = SalaBD::pesquisarRecurso("", $_GET["numeroSala"], $_GET["descricaoSala"], $_GET["localizacaoSala"], $_GET["capacidadeSala"], $_GET["tipoSala"]);
			
			if (mysql_num_rows($result) > 0)
			{
				while ($registro = mysql_fetch_array($result))
				{
					$idRecurso = $registro["idRecurso"];
					$numeroSala = $registro["numeroSala"];
					$descricaoSala = $registro["descricaoSala"];
					$localizacaoSala = $registro["localizacaoSala"];
					$capacidadeSala = $registro["capacidadeSala"];
					$tipoSala = $registro["tipoSala"];
					
					echo "
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"cadastrar_sala.php?idRecurso=$idRecurso\">
									<span>ALTERAR</span>
								</a>
								&nbsp;&nbsp;&nbsp;
								<a style=\"float: right;\" class=\"botao\" onclick=\"javascript:return confirma_exclusao()\" href=\"../control/RecursoControle.php?opcaoRecurso=ExcluirSala&idRecurso=$idRecurso\">
									<span>EXCLUIR</span>
								</a>
							</div>
							<h1>$descricaoSala</h1>
							<span>
							";
							
					if ($numeroSala <> 0)
						echo "Numero: $numeroSala &nbsp;&nbsp;&nbsp;";
							
					echo "
								Capacidade: $capacidadeSala <br>
								Localizacao: $localizacaoSala <br>
								Tipo: $tipoSala
							</span>
						</div>
					";
				}
			}
			else
			{
				echo "<h1>Nenhum resultado encontrado!</h1>";
			}
		}
		
		/*
		 * Função: Buscar dados de um equipamento específico
		 * Parâmetros
		 * $idRecurso: ID do recurso desejado
		 * Retorno: Dados do equipamento informado
		 */
		public function buscarDadosEquipamento($idRecurso)
		{
			$result = EquipamentoBD::pesquisarRecurso($idRecurso, "", "", "", "");
			
			$vetor = mysql_fetch_array($result);
			
			return $vetor;
		}
		
		/*
		 * Função: Buscar dados de uma sala específica
		 * Parâmetros
		 * $idRecurso: ID do recurso desejado
		 * Retorno: Dados da sala informada
		 */
		public function buscarDadosSala($idRecurso)
		{
			$result = SalaBD::pesquisarRecurso($idRecurso, "", "", "", "", "");
			
			$vetor = mysql_fetch_array($result);
			
			return $vetor;
		}
	}
	
	$recursoControle = new RecursoControle();
?>