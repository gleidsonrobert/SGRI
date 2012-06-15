<?php
	include_once ("../model/DataEventoBD.php");
	include_once ("../model/ItemReservaBD.php");
	include_once ("../model/ProfessorEventoBD.php");
	include_once ("../model/ReservaAulaBD.php");
	include_once ("../model/ReservaEventoBD.php");
	include_once ("../model/ProfessorBD.php");
	include_once ("../model/CoordenadorBD.php");
	include_once ("../model/SalaBD.php");
	include_once ("../model/EquipamentoBD.php");
	include_once ("../model/TurmaBD.php");
	include_once ("../model/HorarioTurmaBD.php");
	
	/*
	 * Finalidade: Controlar as classes de reserva através das informações fornecidas pela interface
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 14/05/2012
	 */
	class ReservaControle
	{
		/*
		 * Construtora
		 * Função: Instanciar o objeto de controle de reserva
		 */
		public function ReservaControle()
		{
			/* Variável recebe a opção de ação passada pelo formulário através da variavel opcaoReserva do tipo hidden */
			$opcaoReserva = $_REQUEST['opcaoReserva'];
			
			/* Define as ações de acordo com a opção */
			switch ($opcaoReserva)
			{
				case 'IncluirReservaEvento': $this->incluirReservaEvento(); break;
				case 'IncluirReservaAula': $this->incluirReservaAula(); break;
				case 'ExcluirReserva': $this->excluirReserva(); break;
				case 'ListarReservasEvento': $this->listarReservasEvento(); break;
				case 'ListarReservasAula' : $this->listarReservasAula(); break;
				case 'ListarRecursosEvento': $this->listarRecursosEvento(); break;
				case 'ListarRecursosAula': $this->listarRecursosAula(); break;
			}
		}
		
		/*
		 * Função: Incluir reserva de aula no sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function incluirReservaAula()
		{
			$model = new ReservaAulaBD();
			
			session_start();
			$model->definirLoginUsuario($_SESSION["usuario"]);
			$model->definirDataReserva("current_date");
				$dataAux = explode("/", $_POST["dataAula"]);
			$dataAula = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
			$model->definirDataAula($dataAula);
			$model->definirIdHorario($_POST["horarioTurma"]);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_reservas_aula.php\">";
			
			$idReserva = $model->efetuarReserva();
			
			if ($idReserva <> -1)
			{
				if (count($_POST["recurso"]) > 0)
				{
					foreach ($_POST["recurso"] as $key => $idRecurso)
					{
						$itemReserva = new ItemReservaBD();
						$itemReserva->definirIdReserva($idReserva);
						$itemReserva->definirIdRecurso($idRecurso);
						
						$itemReserva->incluirItemReserva();
					}
				}
				
				echo "<script language='JavaScript'> window.alert('Registro incluido com sucesso!') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro na inclusao do registro!') </script>";
		}
		
		/*
		 * Função: Incluir reserva de evento no sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function incluirReservaEvento()
		{
			$model = new ReservaEventoBD();
			
			session_start();
			$model->definirLoginUsuario($_SESSION["usuario"]);
			$model->definirDataReserva("current_date");
			$model->definirNomeEvento($_POST["nomeEvento"]);
				$dataAux = explode("/", $_POST["dataInicio"]);
			$dataInicio = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
			$model->definirInicioEvento($dataInicio);
				$dataAux = explode("/", $_POST["dataFim"]);
			$dataFim = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
			$model->definirFimEvento($dataFim);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_reservas_evento.php\">";
			
			$idReserva = $model->efetuarReserva();
			
			if ($idReserva <> -1)
			{
				if (count($_POST["professor"]) > 0)
				{
					foreach ($_POST["professor"] as $key => $cpfProfessor)
					{
						$professor = new ProfessorEventoBD();
						$professor->definirIdReserva($idReserva);
						$professor->definirCpfProfessor($cpfProfessor);
						
						$professor->incluirProfessorEvento();
					}
				}
				
				if (count($_POST["recurso"]) > 0)
				{
					foreach ($_POST["recurso"] as $key => $idRecurso)
					{
						$itemReserva = new ItemReservaBD();
						$itemReserva->definirIdReserva($idReserva);
						$itemReserva->definirIdRecurso($idRecurso);
						
						$itemReserva->incluirItemReserva();
					}
				}
				
				echo "<script language='JavaScript'> window.alert('Registro incluido com sucesso!') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro na inclusao do registro!') </script>";
		}
		
		/*
		 * Função: Excluir reserva do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function excluirReserva()
		{
			$result = ReservaEventoBD::pesquisarReserva($_GET['idReserva'], "", "", "");
			
			if (mysql_num_rows($result) > 0)
			{
				$model = new ReservaEventoBD();
				$model->definirIdReserva($_GET['idReserva']);
				
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_reservas_evento.php\">";
			}
			else
			{
				$model = new ReservaAulaBD();
				$model->definirIdReserva($_GET['idReserva']);
				
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_reservas_aula.php\">";
			}
			
			if ($model->cancelarReserva())
			{
				$itemReserva = new ItemReservaBD();
				$itemReserva->definirIdReserva($_GET['idReserva']);
				$itemReserva->excluirItensReserva();
				
				$professor = new ProfessorEventoBD();
				$professor->definirIdReserva($_GET['idReserva']);
				$professor->excluirProfessoresEvento();
				
				echo "<script language='JavaScript'> window.alert('Registro excluido com sucesso!') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro na exclusao do registro!') </script>";
		}
		
		/*
		 * Função: Listar todos os recursos disponíveis do sistema
		 * Retorno: Lista com os recursos disponíveis
		 */
		public function listarRecursosAula()
		{
			if ($_GET["dataAula"])
			{
					$dataAux = explode("/", $_GET["dataAula"]);
				$diaSemana = date("w", mktime(0, 0, 0, $dataAux[1], $dataAux[0], $dataAux[2]));
				session_start();
				if ($_SESSION["permissao"] <> "S")
					$usuario = $_SESSION["usuario"];
				else
					$usuario = "";
				
				$result = TurmaBD::pesquisarTurma("", $usuario, $diaSemana);
				
				if (mysql_num_rows($result) > 0)
				{
					echo "
						<div>
							<span>Turma</span>
							<select id=\"disciplinaTurma\" name=\"disciplinaTurma\" require=\"Informe a turma\" onChange=\"pesquisa()\" onClick=\"limpaDados2()\">
								<option value=\"\"></option>
					";
					
					while ($registro = mysql_fetch_array($result))
					{
						$idTurma = $registro["idTurma"];
						$disciplinaTurma = $registro["disciplinaTurma"];
						$numeroSala = $registro["numeroSala"];
							
						echo "
							<option value=\"$idTurma\">$disciplinaTurma [sala $numeroSala]</option>
						";
					}
					
					if ($_GET["disciplinaTurma"] <> "")
					{
						$idTurma = $_GET["disciplinaTurma"];
						$result2 = TurmaBD::pesquisarTurma($idTurma, "", "");
						$registro = mysql_fetch_array($result2);
						$disciplinaTurma = $registro["disciplinaTurma"];
						$numeroSala = $registro["numeroSala"];
						echo "
							<option disabled=\"disabled\" value=\"\">--------------------------------</option>
							<option selected=\"selected\" value=\"$idTurma\">$disciplinaTurma [sala $numeroSala]</option>
						";
					}
					
					echo "
							</select>
						</div>
					";
					
					if ($_GET["disciplinaTurma"] <> "")
					{
						$idTurma = $_GET["disciplinaTurma"];
							$dataAux = explode("/", $_GET["dataAula"]);
						$diaSemana = date("w", mktime(0, 0, 0, $dataAux[1], $dataAux[0], $dataAux[2]));
						
						$result = HorarioTurmaBD::pesquisarHorarioTurma("", $idTurma, $diaSemana);
						
						echo "
							<div>
								<span>Horario</span>
								<select id=\"horarioTurma\" name=\"horarioTurma\" require=\"Informe o horário\" onChange=\"pesquisa()\">
									<option value=\"\"></option>
						";
						
						while ($registro = mysql_fetch_array($result))
						{
							$idHorario = $registro["idHorario"];
							$inicioHorario = $registro["inicioHorario"];
							$fimHorario = $registro["fimHorario"];
								
							echo "
								<option value=\"$idHorario\">$inicioHorario - $fimHorario</option>
							";
						}
						
						if ($_GET["horarioTurma"] <> "")
						{
							$idHorario = $_GET["horarioTurma"];
							$result2 = HorarioTurmaBD::pesquisarHorarioTurma($idHorario, "");
							$registro = mysql_fetch_array($result2);
							$inicioHorario = $registro["inicioHorario"];
							$fimHorario = $registro["fimHorario"];
							echo "
								<option disabled=\"disabled\" value=\"\">--------------------------------</option>
								<option selected=\"selected\" value=\"$idHorario\">$inicioHorario - $fimHorario</option>
							";
						}
						
						echo "
								</select>
							</div>
						";
						
						if ($_GET["horarioTurma"] <> "")
						{
								$dataAux = explode("/", $_GET["dataAula"]);
							$dataAula = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
							$idHorario = $_GET["horarioTurma"];
							
							$result = EquipamentoBD::pesquisarRecursoDisponivel("", "", $dataAula, $idHorario);
							
							if (mysql_num_rows($result) > 0)
							{
								$cont = 0;
								
								echo "
									<div>
										<br><br><hr><br>
										<h1>Equipamentos Disponiveis</h1>
										<br>
										<table>
								";
								
								while ($registro = mysql_fetch_array($result))
								{
									$cont++;
									
									$idRecurso = $registro["idRecurso"];
									$descricaoEquipamento = $registro["descricaoEquipamento"];
									$patrimonioEquipamento = $registro["patrimonioEquipamento"];
									
									if ($cont % 2 <> 0)
										echo "<tr>";
									
									echo "
										<td width=\"350\"><input style=\"width: auto;\" type=\"checkbox\" name=\"recurso[]\" value=\"$idRecurso\" />$descricaoEquipamento [$patrimonioEquipamento]</td>
									";
									
									if ($cont % 2 == 0)
										echo "</tr>";
								}
								
								echo "
										</table>
									</div>
								";
							}
						}
						else
						{
							echo "
								<div>
									<br><hr><br>
									<h1>Equipamentos Disponiveis</h1>
									<br>
									<table>
										===> Selecione o horario!
									</table>
								</div>
							";
						}
					}
					else
					{
						echo "
							<div>
								<span>Horario</span>
								<select id=\"horarioTurma\" name=\"horarioTurma\" require=\"Informe o horário\" onChange=\"pesquisa()\">
									<option disabled=\"disabled\" value=\"\"> ===> Selecione a turma! </option>
								</select>
							</div>
							<div>
								<br><hr><br>
								<h1>Equipamentos Disponiveis</h1>
								<br>
								<table>
									===> Selecione a turma!
								</table>
							</div>
						";
					}
				}
				else
				{
					echo "
						<div>
							<br><hr><br>
							<h1>===> Nao existem aulas neste dia!</h1>
							<input type=\"hidden\" id=\"disciplinaTurma\" name=\"disciplinaTurma\" value=\"\" />
							<input type=\"hidden\" id=\"horarioTurma\" name=\"horarioTurma\" value=\"\" />
							<br>
						</div>
					";
				}
			}
			else
			{
				echo "
					<div>
						<span>Turma</span>
						<select id=\"disciplinaTurma\" name=\"disciplinaTurma\" require=\"Informe a turma\" onChange=\"pesquisa()\" onClick=\"limpaDados2()\">
							<option disabled=\"disabled\" value=\"\"> ===> Preencha a data! </option>
						</select>
					</div>
					<div>
						<span>Horario</span>
						<select id=\"horarioTurma\" name=\"horarioTurma\" require=\"Informe o horário\" onChange=\"pesquisa()\">
							<option disabled=\"disabled\" value=\"\"> ===> Preencha a data! </option>
						</select>
					</div>
					<div>
						<br><hr><br>
						<h1>Equipamentos Disponiveis</h1>
						<br>
						<table>
							===> Preencha a data!
						</table>
					</div>
				";
			}
		}
		
		/*
		 * Função: Listar todos os professores do sistema
		 * Retorno: Lista com os professores
		 */
		public function listarProfessores()
		{
			$result = ProfessorBD::pesquisarPessoa("");
			
			if (mysql_num_rows($result) > 0)
			{
				$cont = 0;
				
				while ($registro = mysql_fetch_array($result))
				{
					$cont++;
					
					$cpfPessoa = $registro["cpfPessoa"];
					$nomePessoa = $registro["nomePessoa"];
					
					if ($cont % 2 <> 0)
						echo "<tr>";
					
					echo "
						<td width=\"350\"><input style=\"width: auto;\" type=\"checkbox\" name=\"professor[]\" value=\"$cpfPessoa\" />$nomePessoa</td>
					";
					
					if ($cont % 2 == 0)
						echo "</tr>";
				}
			}
			
			$result = CoordenadorBD::pesquisarPessoa("");
			
			if (mysql_num_rows($result) > 0)
			{
				$cont = 0;
				
				while ($registro = mysql_fetch_array($result))
				{
					$cont++;
					
					$cpfPessoa = $registro["cpfPessoa"];
					$nomePessoa = $registro["nomePessoa"];
					
					if ($cont % 2 <> 0)
						echo "<tr>";
					
					echo "
						<td width=\"350\"><input style=\"width: auto;\" type=\"checkbox\" name=\"professor[]\" value=\"$cpfPessoa\" />$nomePessoa</td>
					";
					
					if ($cont % 2 == 0)
						echo "</tr>";
				}
			}
		}
		
		/*
		 * Função: Listar todos os recursos disponíveis do sistema
		 * Retorno: Lista com os recursos disponíveis
		 */
		public function listarRecursosEvento()
		{
			if ($_GET["dataInicio"] <> "" && $_GET["dataFim"] <> "")
			{
					$dataAux = explode("/", $_GET["dataInicio"]);
				$dataInicio = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
					$dataAux = explode("/", $_GET["dataFim"]);
				$dataFim = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
				
				$result = SalaBD::pesquisarRecursoDisponivel($dataInicio, $dataFim);
				
				if (mysql_num_rows($result) > 0)
				{
					$cont = 0;
					
					echo "
						<br><hr><br>
						<h1>Salas Disponiveis</h1>
						<br>
						<table>
					";
					
					while ($registro = mysql_fetch_array($result))
					{
						$cont++;
						
						$idRecurso = $registro["idRecurso"];
						$descricaoSala = $registro["descricaoSala"];
						$localizacaoSala = $registro["localizacaoSala"];
						
						if ($cont % 2 <> 0)
							echo "<tr>";
						
						echo "
							<td width=\"350\"><input style=\"width: auto;\" type=\"checkbox\" name=\"recurso[]\" value=\"$idRecurso\" />$descricaoSala [$localizacaoSala]</td>
						";
						
						if ($cont % 2 == 0)
							echo "</tr>";
					}
					
					echo "</table>";
				}
				
				$result = EquipamentoBD::pesquisarRecursoDisponivel($dataInicio, $dataFim, "", "");
				
				if (mysql_num_rows($result) > 0)
				{
					$cont = 0;
					
					echo "
						<br><br><hr><br>
						<h1>Equipamentos Disponiveis</h1>
						<br>
						<table>
					";
					
					while ($registro = mysql_fetch_array($result))
					{
						$cont++;
						
						$idRecurso = $registro["idRecurso"];
						$descricaoEquipamento = $registro["descricaoEquipamento"];
						$patrimonioEquipamento = $registro["patrimonioEquipamento"];
						
						if ($cont % 2 <> 0)
							echo "<tr>";
						
						echo "
							<td width=\"350\"><input style=\"width: auto;\" type=\"checkbox\" name=\"recurso[]\" value=\"$idRecurso\" />$descricaoEquipamento [$patrimonioEquipamento]</td>
						";
						
						if ($cont % 2 == 0)
							echo "</tr>";
					}
					
					echo "</table>";
				}
			}
			else
			{
				echo "
					<br><hr><br>
					<h1>Salas Disponiveis</h1>
					<br>
					<table>
						===> Preencha as datas!
					</table>
					<br><br><hr><br>
					<h1>Equipamentos Disponiveis</h1>
					<br>
					<table>
						===> Preencha as datas!
					</table>
				";
			}
		}
		
		/*
		 * Função: Listar todos as reservas de aula do sistema
		 * Retorno: Lista com as reservas de aula
		 */
		public function listarReservasAula()
		{
			if ($_GET["dataAula"] <> "")
			{
				$dataAux = explode("/", $_GET["dataAula"]);
				$data = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
			}
			else
				$data = "";
			
			if ($_SESSION["permissao"] <> "S")
				$usuario = $_SESSION["usuario"];
			else
				$usuario = "";
			
			$result = ReservaAulaBD::pesquisarReserva("", $usuario, $data, $_GET["disciplinaTurma"]);
			
			if (mysql_num_rows($result) > 0)
			{
				while ($registro = mysql_fetch_array($result))
				{
					$idReserva = $registro["idReserva"];
						$dataAux = explode("-", $registro["dataReserva"]);
					$dataReserva = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
						$dataAux = explode("-", $registro["dataAula"]);
					$dataAula = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
						$horaAux = explode(":", $registro["inicioHorario"]);
					$inicioHorario = $horaAux[0].":".$horaAux[1];
						$horaAux = explode(":", $registro["fimHorario"]);
					$fimHorario = $horaAux[0].":".$horaAux[1];
					switch ($registro["diaHorario"])
					{
						case '0': $diaHorario = "Domingo"; break;
						case '1': $diaHorario = "Segunda-Feira"; break;
						case '2': $diaHorario = "Terca-Feira"; break;
						case '3': $diaHorario = "Quarta-Feira"; break;
						case '4': $diaHorario = "Quinta-Feira"; break;
						case '5': $diaHorario = "Sexa-Feira"; break;
						case '6': $diaHorario = "Sabado"; break;
					}
					$disciplinaTurma = $registro["disciplinaTurma"];
					
					echo "
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"detalhar_reserva_aula.php?idReserva=$idReserva\">
									<span>DETALHES</span>
								</a>
								&nbsp;&nbsp;&nbsp;
								<a style=\"float: right;\" class=\"botao\" onclick=\"javascript:return confirma_exclusao()\" href=\"../control/ReservaControle.php?opcaoReserva=ExcluirReserva&idReserva=$idReserva\">
									<span>EXCLUIR</span>
								</a>
							</div>
							<h1>[$dataReserva]</h1>
							<span>
								Dia da Aula: $dataAula ($diaHorario) <br>
								Horario da Aula: $inicioHorario - $fimHorario <br>
								Disciplina da Aula: $disciplinaTurma <br>
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
		 * Função: Listar todos as reservas de evento do sistema
		 * Retorno: Lista com as reservas de evento
		 */
		public function listarReservasEvento()
		{
			if ($_GET["dataEvento"] <> "")
			{
				$dataAux = explode("/", $_GET["dataEvento"]);
				$data = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
			}
			else
				$data = "";
			
			if ($_SESSION["permissao"] <> "S")
				$usuario = $_SESSION["usuario"];
			else
				$usuario = "";
			
			$result = ReservaEventoBD::pesquisarReserva("", $usuario, $_GET["nomeEvento"], $data);
			
			if (mysql_num_rows($result) > 0)
			{
				while ($registro = mysql_fetch_array($result))
				{
					$idReserva = $registro["idReserva"];
						$dataAux = explode("-", $registro["dataReserva"]);
					$dataReserva = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
					$nomeEvento = $registro["nomeEvento"];
						$dataAux = explode("-", $registro["inicioEvento"]);
					$inicioEvento = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
						$dataAux = explode("-", $registro["fimEvento"]);
					$fimEvento = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
					
					echo "
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a class=\"botao\" href=\"detalhar_reserva_evento.php?idReserva=$idReserva\">
									<span>DETALHES</span>
								</a>
								&nbsp;&nbsp;&nbsp;
								<a style=\"float: right;\" class=\"botao\" onclick=\"javascript:return confirma_exclusao()\" href=\"../control/ReservaControle.php?opcaoReserva=ExcluirReserva&idReserva=$idReserva\">
									<span>EXCLUIR</span>
								</a>
							</div>
							<h1>[$dataReserva]</h1>
							<span>
								Nome do Evento: $nomeEvento <br>
								Periodo do Evento: $inicioEvento a $fimEvento
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
		 * Função: Detalhar uma reserva de aula específica
		 * Parâmetros:
		 * $idReserva: ID da reserva especificada
		 * Retorno: Detalhes da reserva de aula especificada
		 */
		public function detalharReservaAula($idReserva)
		{
			$result = ReservaAulaBD::pesquisarReserva($idReserva, "", "", "");
			$registro = mysql_fetch_array($result);
			
			$nomePessoa = $registro["nomePessoa"];
			$loginUsuario = $registro["loginUsuario"];
				$dataAux = explode("-", $registro["dataReserva"]);
			$dataReserva = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
				$dataAux = explode("-", $registro["dataAula"]);
			$dataAula = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
				$horaAux = explode(":", $registro["inicioHorario"]);
			$inicioHorario = $horaAux[0].":".$horaAux[1];
				$horaAux = explode(":", $registro["fimHorario"]);
			$fimHorario = $horaAux[0].":".$horaAux[1];
			switch ($registro["diaHorario"])
			{
				case '0': $diaHorario = "Domingo"; break;
				case '1': $diaHorario = "Segunda-Feira"; break;
				case '2': $diaHorario = "Terca-Feira"; break;
				case '3': $diaHorario = "Quarta-Feira"; break;
				case '4': $diaHorario = "Quinta-Feira"; break;
				case '5': $diaHorario = "Sexa-Feira"; break;
				case '6': $diaHorario = "Sabado"; break;
			}
			$disciplinaTurma = $registro["disciplinaTurma"];
			
			echo "
				<div>
					<h1>
						<hr />
						<br class=\"clear\" />
						Pessoa Responsavel: $nomePessoa ($loginUsuario) <br>
						Data da Reserva: $dataReserva <br>
						Dia da Aula: $dataAula ($diaHorario) <br>
						Horario da Aula: $inicioHorario - $fimHorario <br>
						Disciplina da Aula: $disciplinaTurma <br>
						<br class=\"clear\" />
						<hr />
						<br class=\"clear\" />
					</h1>
				</div>
				<h1>
					<hr />
					<br class=\"clear\" />
					Equipamentos da Reserva:
					<br class=\"clear\" />
				</h1>
			";
			
			$result = ItemReservaBD::pesquisarItemReserva($idReserva, "E");
			
			while ($registro = mysql_fetch_array($result))
			{
				$patrimonioEquipamento = $registro["patrimonioEquipamento"];
				$descricaoEquipamento = $registro["descricaoEquipamento"];
				
				echo "
					<div>
						<span>
							- $descricaoEquipamento [ $patrimonioEquipamento ] <br>
						</span>
					</div>
				";
			}
			
			echo "
				<br class=\"clear\" />
				<hr />
			";
		}
		
		/*
		 * Função: Detalhar uma reserva de evento específica
		 * Parâmetros:
		 * $idReserva: ID da reserva especificada
		 * Retorno: Detalhes da reserva de evento especificada
		 */
		public function detalharReservaEvento($idReserva)
		{
			$result = ReservaEventoBD::pesquisarReserva($idReserva, "", "", "");
			$registro = mysql_fetch_array($result);
			
			$nomePessoa = $registro["nomePessoa"];
			$loginUsuario = $registro["loginUsuario"];
				$dataAux = explode("-", $registro["dataReserva"]);
			$dataReserva = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
			$nomeEvento = $registro["nomeEvento"];
				$dataAux = explode("-", $registro["inicioEvento"]);
			$inicioEvento = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
				$dataAux = explode("-", $registro["fimEvento"]);
			$fimEvento = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
			
			echo "
				<div>
					<h1>
						<hr />
						<br class=\"clear\" />
						Pessoa Responsavel: $nomePessoa ($loginUsuario) <br>
						Data da Reserva: $dataReserva <br>
						Nome do Evento: $nomeEvento <br>
						Periodo do Evento: $inicioEvento a $fimEvento <br>
						<br class=\"clear\" />
						<hr />
						<br class=\"clear\" />
					</h1>
				</div>
			";
			
			echo "
				<h1>
					<hr />
					<br class=\"clear\" />
					Professores Relacionados:
					<br class=\"clear\" />
				</h1>
			";
			
			$result = ProfessorEventoBD::pesquisarProfessorEvento($idReserva);
			
			while ($registro = mysql_fetch_array($result))
			{
				$nomePessoa = $registro["nomePessoa"];
				
				echo "
					<div>
						<span>
							- $nomePessoa
						</span>
					</div>
				";
			}
			
			echo "
				<br class=\"clear\" />
				<hr />
				<br class=\"clear\" />
			";
			
			echo "
				<h1>
					<hr />
					<br class=\"clear\" />
					Salas da Reserva:
					<br class=\"clear\" />
				</h1>
			";
			
			$result = ItemReservaBD::pesquisarItemReserva($idReserva, "S");
			
			while ($registro = mysql_fetch_array($result))
			{
				$numeroSala = $registro["numeroSala"];
				$descricaoSala = $registro["descricaoSala"];
				$localizacaoSala = $registro["localizacaoSala"];
				$capacidadeSala = $registro["capacidadeSala"];
				
				echo "
					<div>
						<span>
							- $descricaoSala [
				";
				
				if ($numeroSala <> 0)
					echo "Sala $numeroSala / ";
				
				echo "
						$localizacaoSala / $capacidadeSala aluno(s) ] <br>
						</span>
					</div>
				";
			}
			
			echo "
				<br class=\"clear\" />
				<hr />
				<br class=\"clear\" />
			";
			
			echo "
				<h1>
					<hr />
					<br class=\"clear\" />
					Equipamentos da Reserva:
					<br class=\"clear\" />
				</h1>
			";
			
			$result = ItemReservaBD::pesquisarItemReserva($idReserva, "E");
			
			while ($registro = mysql_fetch_array($result))
			{
				$patrimonioEquipamento = $registro["patrimonioEquipamento"];
				$descricaoEquipamento = $registro["descricaoEquipamento"];
				
				echo "
					<div>
						<span>
							- $descricaoEquipamento [ $patrimonioEquipamento ] <br>
						</span>
					</div>
				";
			}
			
			echo "
				<br class=\"clear\" />
				<hr />
			";
		}
	}
	
	$reservaControle = new ReservaControle();
?>