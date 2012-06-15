<?php
	include_once ("ReservaEvento.php");
	include_once ("ReservaBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular reservas de evento do sistema no banco de dados
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ReservaEventoBD extends ReservaEvento implements ReservaBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de conex�o com o banco de dados
		 */
		public function ReservaEventoBD()
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
			$sql = "INSERT INTO reserva (loginUsuario, dataReserva, nomeEvento, inicioEvento, fimEvento, tipoReserva)
			VALUES('".$this->obterLoginUsuario()."', ".$this->obterDataReserva().", '".$this->obterNomeEvento()."',
			'".$this->obterInicioEvento()."', '".$this->obterFimEvento()."', 'E')";
			
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
		public function pesquisarReserva($idReserva, $loginUsuario, $nomeEvento, $dataEvento)
		{
			$sql = "SELECT idReserva, loginUsuario, dataReserva, nomeEvento, inicioEvento, fimEvento, nomePessoa
						FROM reserva NATURAL JOIN usuario
							NATURAL JOIN pessoa
						WHERE tipoReserva = 'E'";
			
			if ($idReserva != "")
				$sql = $sql." AND idReserva = '".$idReserva."'";
				
			if ($loginUsuario != "")
				$sql = $sql." AND loginUsuario LIKE '%".$loginUsuario."%'";
			
			if ($nomeEvento != "")
				$sql = $sql." AND nomeEvento LIKE '%".$nomeEvento."%'";
				
			if ($dataEvento != "")
				$sql = $sql." AND (inicioEvento <= '".$dataEvento."' AND fimEvento >= '".$dataEvento."')";
			
			$sql = $sql." ORDER BY dataReserva, inicioEvento";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$reservaEventoBD = new ReservaEventoBD();
?>