<?php
	/*
	 * Finalidade: Instanciar item de reserva do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ItemReserva
	{
		/* Propriedades */
		private $idReserva;
		private $idRecurso;
		
		/*
		 * Fun��o: Definir ID da reserva para inst�ncia do item
		 * Par�metros
		 * $idReserva: ID da reserva
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Fun��o: Obter ID da reserva da inst�ncia do item
		 * Retorno: ID da reserva
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
		
		/*
		 * Fun��o: Definir ID do recurso para inst�ncia do item
		 * Par�metros
		 * $idRecurso: ID do recurso
		 */
		public function definirIdRecurso($idRecurso)
		{
			$this->idRecurso = $idRecurso;
		}
		
		/*
		 * Fun��o: Obter ID do recurso data inst�ncia do item
		 * Retorno: ID do recurso
		 */
		public function obterIdRecurso()
		{
			return $this->idRecurso;
		}
	}
?>