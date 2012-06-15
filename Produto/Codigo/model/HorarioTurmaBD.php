<?php
	include_once ("HorarioTurma.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular hor�rios de turma do sistema no banco de dados
	 * Autor: T�lio Henrique Caf� Carvalhais
	 * Data: 30/05/2012
	 */
	class HorarioTurmaBD extends HorarioTurma
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de conex�o com o banco de dados
		 */
		public function HorarioTurmaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Fun��o: Incluir hor�rio no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
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
		 * Fun��o: Excluir hor�rios da turma do banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
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
		 * Fun��o: Listar hor�rios de turma no banco de dados
		 * Retorno: Lista de hor�rios
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