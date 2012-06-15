<?php
	/*
	 * Finalidade: Instanciar item de reserva do sistema
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ItemReserva
	{
		/* Propriedades */
		private $idReserva;
		private $idRecurso;
		
		/*
		 * Funчуo: Definir ID da reserva para instтncia do item
		 * Parтmetros
		 * $idReserva: ID da reserva
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Funчуo: Obter ID da reserva da instтncia do item
		 * Retorno: ID da reserva
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
		
		/*
		 * Funчуo: Definir ID do recurso para instтncia do item
		 * Parтmetros
		 * $idRecurso: ID do recurso
		 */
		public function definirIdRecurso($idRecurso)
		{
			$this->idRecurso = $idRecurso;
		}
		
		/*
		 * Funчуo: Obter ID do recurso data instтncia do item
		 * Retorno: ID do recurso
		 */
		public function obterIdRecurso()
		{
			return $this->idRecurso;
		}
	}
?>