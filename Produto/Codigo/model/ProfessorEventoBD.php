<?php
	include_once ("ProfessorEvento.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular professores de evento do sistema no banco de dados
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ProfessorEventoBD extends ProfessorEvento
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Funчуo: Instanciar o objeto de conexуo com o banco de dados
		 */
		public function ProfessorEventoBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Funчуo: Incluir professor de evento no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function incluirProfessorEvento()
		{
			$sql = "INSERT INTO professorEvento (idReserva, cpfProfessor)
			VALUES('".$this->obterIdReserva()."', '".$this->obterCpfProfessor()."')";
			
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
		 * Funчуo: Excluir professores de evento no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function excluirProfessoresEvento()
		{
			$sql = "DELETE FROM professorEvento WHERE idReserva = '".$this->obterIdReserva()."'";
			
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
		 * Funчуo: Listar professores de evento no banco de dados
		 * Retorno: Lista de professores de evento
		 */
		public static function pesquisarProfessorEvento($idReserva)
		{
			$sql = "SELECT nomePessoa 
						FROM professorEvento JOIN pessoa
							ON professorEvento.cpfProfessor = pessoa.cpfPessoa
						WHERE 1 = 1";
						
			if ($idReserva != "")
				$sql = $sql." AND idReserva = '".$idReserva."'";
			
			$sql = $sql." ORDER BY nomePessoa";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$professorEventoBD = new ProfessorEventoBD();
?>