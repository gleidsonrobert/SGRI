<?php
	include_once ("Turma.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular turmas do sistema no banco de dados
	 * Autor: Wander Maia da Silva
	 * Data: 29/05/2012
	 */
	class TurmaBD extends Turma
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Funчуo: Instanciar o objeto de conexуo com o banco de dados
		 */
		public function TurmaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Funчуo: Incluir turma no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function incluirTurma()
		{
			$sql = "INSERT INTO turma (disciplinaTurma, numeroSala, cpfProfessor)
			VALUES('".$this->obterDisciplinaTurma()."', '".$this->obterNumeroSala()."',
			'".$this->obterCpfPessoa()."')";
			
			$result = mysql_query($sql);
			
			if (!$result)
			{
				return -1;
			}
			else
			{
				return mysql_insert_id();
			}
		}
		
		/*
		 * Funчуo: Excluir todas as turmas no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function excluirTurmas()
		{
			$sql = "DELETE FROM turma";
			
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
		 * Funчуo: Listar turmas no banco de dados
		 * Retorno: Lista de turmas
		 */
		public static function pesquisarTurma($idTurma, $loginUsuario, $diaHorario)
		{
			$sql = "SELECT idTurma, disciplinaTurma, numeroSala
						FROM turma JOIN usuario ON turma.cpfProfessor = usuario.cpfPessoa
							NATURAL JOIN horarioTurma
						WHERE 1 = 1";
			
			if ($idTurma != "")
				$sql = $sql." AND (idTurma = '".$idTurma."')";
				
			if ($loginUsuario != "")
				$sql = $sql." AND (loginUsuario = '".$loginUsuario."')";
				
			if ($diaHorario != "")
				$sql = $sql." AND (diaHorario = '".$diaHorario."')";
			
			$sql = $sql." ORDER BY disciplinaTurma";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$turmaBD = new TurmaBD();
?>