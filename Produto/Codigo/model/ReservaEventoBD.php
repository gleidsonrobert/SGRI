<?php
	include_once ("ReservaEvento.php");
	include_once ("ReservaBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular reservas de evento do sistema no banco de dados
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ReservaEventoBD extends ReservaEvento implements ReservaBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Função: Instanciar o objeto de conexão com o banco de dados
		 */
		public function ReservaEventoBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Função: Incluir reserva no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
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
		 * Função: Excluir reserva do banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
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
		 * Função: Listar reservas do banco de dados
		 * Obs: Implementação do método abstrato
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