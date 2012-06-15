<?php
	include_once ("Recurso.php");
	
	/*
	 * Finalidade: Instanciar equipamentos do sistema
	 * Autor: R�mulo de Oliveira Jorge
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
		 * Fun��o: Definir patrim�nio para inst�ncia do equipamento
		 * Par�metros
		 * $patrimonioEquipamento: patrim�nio do equipamento
		 */
		public function definirPatrimonioEquipamento($patrimonioEquipamento)
		{
			$this->patrimonioEquipamento = $patrimonioEquipamento;
		}
		
		/*
		 * Fun��o: Obter patrim�nio da inst�ncia do equipamento
		 * Retorno: patrim�nio do equipamento
		 */
		public function obterPatrimonioEquipamento()
		{
			return $this->patrimonioEquipamento;
		}
		
		/*
		 * Fun��o: Definir descri��o para inst�ncia do equipamento
		 * Par�metros
		 * $descricaoEquipamento: descri��o do equipamento
		 */
		public function definirDescricaoEquipamento($descricaoEquipamento)
		{
			$this->descricaoEquipamento = $descricaoEquipamento;
		}
		
		/*
		 * Fun��o: Obter descri��o da inst�ncia do equipamento
		 * Retorno: descri��o do equipamento
		 */
		public function obterDescricaoEquipamento()
		{
			return $this->descricaoEquipamento;
		}
		
		/*
		 * Fun��o: Definir tipo para inst�ncia do equipamento
		 * Par�metros
		 * $tipoEquipamento: tipo do equipamento
		 */
		public function definirTipoEquipamento($tipoEquipamento)
		{
			$this->tipoEquipamento = $tipoEquipamento;
		}
		
		/*
		 * Fun��o: Obter tipo da inst�ncia do equipamento
		 * Retorno: tipo do equipamento
		 */
		public function obterTipoEquipamento()
		{
			return $this->tipoEquipamento;
		}
		
		/*
		 * Fun��o: Definir status para inst�ncia do equipamento
		 * Par�metros
		 * $statusEquipamento: status do equipamento
		 */
		public function definirStatusEquipamento($statusEquipamento)
		{
			$this->statusEquipamento = $statusEquipamento;
		}
		
		/*
		 * Fun��o: Obter status da inst�ncia do equipamento
		 * Retorno: status do equipamento
		 */
		public function obterStatusEquipamento()
		{
			return $this->statusEquipamento;
		}
	}
?>