<?php
	include_once ("Recurso.php");
	
	/*
	 * Finalidade: Instanciar equipamentos do sistema
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 11/04/2012
	 */
	class Equipamento extends Recurso
	{
		/* Propriedades */
		private $patrimonioEquipamento;
		private $descricaoEquipamento;
		private $tipoEquipamento;
		private $statusEquipamento;
		
		/*
		 * Funчуo: Definir patrimєnio para instтncia do equipamento
		 * Parтmetros
		 * $patrimonioEquipamento: patrimєnio do equipamento
		 */
		public function definirPatrimonioEquipamento($patrimonioEquipamento)
		{
			$this->patrimonioEquipamento = $patrimonioEquipamento;
		}
		
		/*
		 * Funчуo: Obter patrimєnio da instтncia do equipamento
		 * Retorno: patrimєnio do equipamento
		 */
		public function obterPatrimonioEquipamento()
		{
			return $this->patrimonioEquipamento;
		}
		
		/*
		 * Funчуo: Definir descriчуo para instтncia do equipamento
		 * Parтmetros
		 * $descricaoEquipamento: descriчуo do equipamento
		 */
		public function definirDescricaoEquipamento($descricaoEquipamento)
		{
			$this->descricaoEquipamento = $descricaoEquipamento;
		}
		
		/*
		 * Funчуo: Obter descriчуo da instтncia do equipamento
		 * Retorno: descriчуo do equipamento
		 */
		public function obterDescricaoEquipamento()
		{
			return $this->descricaoEquipamento;
		}
		
		/*
		 * Funчуo: Definir tipo para instтncia do equipamento
		 * Parтmetros
		 * $tipoEquipamento: tipo do equipamento
		 */
		public function definirTipoEquipamento($tipoEquipamento)
		{
			$this->tipoEquipamento = $tipoEquipamento;
		}
		
		/*
		 * Funчуo: Obter tipo da instтncia do equipamento
		 * Retorno: tipo do equipamento
		 */
		public function obterTipoEquipamento()
		{
			return $this->tipoEquipamento;
		}
		
		/*
		 * Funчуo: Definir status para instтncia do equipamento
		 * Parтmetros
		 * $statusEquipamento: status do equipamento
		 */
		public function definirStatusEquipamento($statusEquipamento)
		{
			$this->statusEquipamento = $statusEquipamento;
		}
		
		/*
		 * Funчуo: Obter status da instтncia do equipamento
		 * Retorno: status do equipamento
		 */
		public function obterStatusEquipamento()
		{
			return $this->statusEquipamento;
		}
	}
?>