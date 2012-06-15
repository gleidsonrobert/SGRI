<?php
	include_once ("DataEvento.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular datas de evento do sistema no banco de dados
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class DataEventoBD extends DataEvento
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de conex�o com o banco de dados
		 */
		public function DataEventoBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Fun��o: Incluir data de evento no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function incluirDataEvento()
		{
			$sql = "INSERT INTO dataEvento (idReserva, dataEvento)
			VALUES('".$this->obterIdReserva()."', '".$this->obterDataEvento()."')";
			
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
		 * Fun��o: Excluir datas de evento no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function excluirDatasEvento()
		{
			$sql = "DELETE FROM dataEvento WHERE idReserva = '".$this->obterIdReserva()."'";
			
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
		 * Fun��o: Listar datas de evento no banco de dados
		 * Retorno: Lista de datas de evento
		 */
		public static function pesquisarDataEvento($idReserva)
		{
			$sql = "SELECT dataEvento
						FROM dataEvento
						WHERE 1 = 1";
						
			if ($idReserva != "")
				$sql = $sql." AND idReserva = '".$idReserva."'";
			
			$sql = $sql." ORDER BY dataEvento";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$dataEventoBD = new DataEventoBD();
?>