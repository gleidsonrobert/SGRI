<?php
	include_once ("ReservaAula.php");
	include_once ("ReservaBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular reservas de aula do sistema no banco de dados
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ReservaAulaBD extends ReservaAula implements ReservaBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de conex�o com o banco de dados
		 */
		public function ReservaAulaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Fun��o: Incluir reserva no banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function efetuarReserva()
		{
			$sql = "INSERT INTO reserva (loginUsuario, idHorario, dataReserva, dataAula, tipoReserva)
			VALUES('".$this->obterLoginUsuario()."', '".$this->obterIdHorario()."',
			".$this->obterDataReserva().", '".$this->obterDataAula()."', 'A')";
			
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
		 * Fun��o: Excluir reserva do banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function cancelarReserva()
		{
			$sql = "DELETE FROM reserva WHERE idReserva = '".$this->obterIdReserva()."'";
			
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
		 * Fun��o: Listar reservas do banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Lista de reservas
		 */
		public function pesquisarReserva($idReserva, $loginUsuario, $dataAula, $disciplinaTurma)
		{
			$sql = "SELECT idReserva, loginUsuario, dataReserva, dataAula, nomePessoa, inicioHorario, fimHorario, diaHorario, disciplinaTurma
						FROM reserva NATURAL JOIN usuario
							NATURAL JOIN pessoa
							NATURAL JOIN horarioTurma
							NATURAL JOIN turma
						WHERE tipoReserva = 'A'";
				
			if ($idReserva != "")
				$sql = $sql." AND idReserva = '".$idReserva."'";
				
			if ($loginUsuario != "")
				$sql = $sql." AND loginUsuario LIKE '%".$loginUsuario."%'";
			
			if ($dataAula != "")
				$sql = $sql." AND dataAula = '".$dataAula."'";
			
			if ($disciplinaTurma != "")
				$sql = $sql." AND disciplinaTurma LIKE '%".$disciplinaTurma."%'";
			
			$sql = $sql." ORDER BY dataReserva, dataAula";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$reservaAulaBD = new ReservaAulaBD();
?>