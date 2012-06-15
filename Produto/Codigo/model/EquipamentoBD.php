<?php
	include_once ("Equipamento.php");
	include_once ("RecursoBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular equipamento do sistema no banco de dados
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 12/04/2012
	 */
	class EquipamentoBD extends Equipamento implements RecursoBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Função: Instanciar o objeto de conexão com o banco de dados
		 */
		public function EquipamentoBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Função: Incluir equipamento no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
		 */
		public function incluirRecurso()
		{
			$sql = "INSERT INTO recurso (patrimonioEquipamento, descricaoEquipamento, tipoEquipamento, statusEquipamento, tipoRecurso)
			VALUES('".$this->obterPatrimonioEquipamento()."', '".$this->obterDescricaoEquipamento()."',
			'".$this->obterTipoEquipamento()."', '".$this->obterStatusEquipamento()."', 'E')";
			
			$result = mysql_query($sql);
			
			if (!$result)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
		 * Função: Alterar equipamento no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
		 */
		public function alterarRecurso()
		{
			$sql = "UPDATE recurso SET patrimonioEquipamento = '".$this->obterPatrimonioEquipamento()."' , 
			descricaoEquipamento = '".$this->obterDescricaoEquipamento()."' , tipoEquipamento = '".$this->obterTipoEquipamento()."' ,
			statusEquipamento = '".$this->obterStatusEquipamento()."' , tipoRecurso = 'E' 
			WHERE idRecurso = '".$this->obterIdRecurso()."'";
			
			$result = mysql_query($sql);
			
			if (!$result)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
		 * Função: Excluir equipamento do banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
		 */
		public function excluirRecurso()
		{
			$sql = "DELETE FROM recurso WHERE idRecurso = '".$this->obterIdRecurso()."' AND tipoRecurso = 'E'";
			
			$result = mysql_query($sql);
			
			if (!$result)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
		 * Função: Listar equipamentos no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Lista de equipamentos
		 */
		public static function pesquisarRecurso($idRecurso, $patrimonioEquipamento, $descricaoEquipamento, $tipoEquipamento, $statusEquipamento)
		{
			$sql = "SELECT idRecurso, patrimonioEquipamento, descricaoEquipamento, tipoEquipamento, statusEquipamento
						FROM recurso
						WHERE tipoRecurso = 'E'";
			
			if ($idRecurso != "")
				$sql = $sql." AND idRecurso = '".$idRecurso."'";
			
			if ($patrimonioEquipamento != "")
				$sql = $sql." AND patrimonioEquipamento LIKE '%".$patrimonioEquipamento."%'";
			
			if ($descricaoEquipamento != "")
				$sql = $sql." AND descricaoEquipamento LIKE '%".$descricaoEquipamento."%'";
				
			if ($tipoEquipamento != "")
				$sql = $sql." AND tipoEquipamento LIKE '%".$tipoEquipamento."%'";
				
			if ($statusEquipamento != "")
				$sql = $sql." AND statusEquipamento LIKE '%".$statusEquipamento."%'";
			
			$sql = $sql." ORDER BY descricaoEquipamento";
			
			$result = mysql_query($sql);
			
			return $result;
		}
		
		/*
		 * Função: Listar equipamentos disponíveis no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Lista de equipamentos disponíveis
		 */
		public static function pesquisarRecursoDisponivel($dataInicio, $dataFim, $dataAula, $idHorario)
		{
			$sql = "SELECT idRecurso, patrimonioEquipamento, descricaoEquipamento, tipoEquipamento, statusEquipamento
						FROM recurso
						WHERE idRecurso NOT IN
							(SELECT DISTINCT idRecurso
									FROM itemReserva NATURAL JOIN reserva
									WHERE";
			
			if ($dataAula <> "")
			{
				$sql = $sql." (dataAula = '".$dataAula."' AND idHorario = '".$idHorario."') OR
						   ('".$dataAula."' BETWEEN inicioEvento AND fimEvento))";
			}
			else
			{
				$sql = $sql." ('".$dataInicio."' <= inicioEvento AND '".$dataFim."' >= inicioEvento) OR
							('".$dataInicio."' >= inicioEvento AND '".$dataInicio."' <= fimEvento) OR
							(dataAula BETWEEN '".$dataInicio."' AND '".$dataFim."'))";
			}
			
			$sql = $sql." AND statusEquipamento = 1
						AND tipoRecurso = 'E'
					ORDER BY descricaoEquipamento;";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$equipamentoBD = new EquipamentoBD();
?>