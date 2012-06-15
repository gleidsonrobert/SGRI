<?php
	/*
	 * Finalidade: Instanciar professores de evento do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ProfessorEvento
	{
		/* Propriedades */
		private $idReserva;
		private $cpfProfessor;
		
		/*
		 * Fun��o: Definir ID da reserva para inst�ncia do professor do evento
		 * Par�metros
		 * $idReserva: ID da reserva da data
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Fun��o: Obter ID da reserva da inst�ncia do professor do evento
		 * Retorno: ID da reserva da data
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
		
		/*
		 * Fun��o: Definir CPF do professor para inst�ncia do professor do evento
		 * Par�metros
		 * $cpfProfessor: CPF do professor
		 */
		public function definirCpfProfessor($cpfProfessor)
		{
			$this->cpfProfessor = $cpfProfessor;
		}
		
		/*
		 * Fun��o: Obter CPF do professor da inst�ncia do professor do evento
		 * Retorno: CPF do professor
		 */
		public function obterCpfProfessor()
		{
			return $this->cpfProfessor;
		}
	}
?>