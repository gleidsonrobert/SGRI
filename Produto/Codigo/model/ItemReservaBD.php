<?php
	include_once ("ItemReserva.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular itens de reserva do sistema no banco de dados
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ItemReservaBD extends ItemReserva
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Funчуo: Instanciar o objeto de conexуo com o banco de dados
		 */
		public function ItemReservaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Funчуo: Incluir item de reserva no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function incluirItemReserva()
		{
			$sql = "INSERT INTO itemReserva (idReserva, idRecurso)
			VALUES('".$this->obterIdReserva()."', '".$this->obterIdRecurso()."')";
			
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
		 * Funчуo: Excluir itens da reserva do banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function excluirItensReserva()
		{
			$sql = "DELETE FROM itemReserva WHERE idReserva = '".$this->obterIdReserva()."'";
			
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
		 * Funчуo: Listar itens de reserva do banco de dados
		 * Retorno: Lista de itens
		 */
		public static function pesquisarItemReserva($idReserva, $tipoRecurso)
		{
			$sql = "SELECT patrimonioEquipamento, descricaoEquipamento, tipoEquipamento, statusEquipamento,	
							numeroSala, descricaoSala, localizacaoSala, capacidadeSala, tipoSala
						FROM itemReserva NATURAL JOIN recurso
						WHERE 1 = 1";
			
			if ($idReserva != "")
				$sql = $sql." AND idReserva = '".$idReserva."'";
				
			if ($tipoRecurso != "")
				$sql = $sql." AND tipoRecurso = '".$tipoRecurso."'";
			
			$sql = $sql." ORDER BY descricaoEquipamento, descricaoSala";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$itemReservaBD = new ItemReservaBD();
?>