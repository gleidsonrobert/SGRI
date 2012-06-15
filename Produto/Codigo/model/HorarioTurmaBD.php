<?php
	include_once ("HorarioTurma.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular horбrios de turma do sistema no banco de dados
	 * Autor: Tъlio Henrique Cafй Carvalhais
	 * Data: 30/05/2012
	 */
	class HorarioTurmaBD extends HorarioTurma
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Funзгo: Instanciar o objeto de conexгo com o banco de dados
		 */
		public function HorarioTurmaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Funзгo: Incluir horбrio no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function incluirHorarioTurma()
		{
			$sql = "INSERT INTO horarioTurma (inicioHorario, fimHorario, diaHorario, idTurma)
			VALUES('".$this->obterInicioHorario()."', '".$this->obterFimHorario()."',
			'".$this->obterDiaHorario()."', '".$this->obterIdTurma()."')";
			
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
		 * Funзгo: Excluir horбrios da turma do banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function excluirHorariosTurma()
		{
			$sql = "DELETE FROM horarioTurma WHERE idTurma = '".$this->obterIdTurma()."'";
			
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
		 * Funзгo: Listar horбrios de turma no banco de dados
		 * Retorno: Lista de horбrios
		 */
		public static function pesquisarHorarioTurma($idHorario, $idTurma, $diaHorario)
		{
			$sql = "SELECT idHorario, inicioHorario, fimHorario, diaHorario
						FROM horarioTurma NATURAL JOIN turma
						WHERE 1 = 1";
			
			if ($idHorario != "")
				$sql = $sql." AND (idHorario = '".$idHorario."')";
			
			if ($idTurma != "")
				$sql = $sql." AND (idTurma = '".$idTurma."')";
			
			if ($diaHorario != "")
				$sql = $sql." AND (diaHorario = '".$diaHorario."')";
			
			$sql = $sql." ORDER BY diaHorario";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$horarioTurmaBD = new HorarioTurmaBD();
?>