<?php
	/*
	 * Finalidade: Instanciar professores de evento do sistema
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ProfessorEvento
	{
		/* Propriedades */
		private $idReserva;
		private $cpfProfessor;
		
		/*
		 * Funчуo: Definir ID da reserva para instтncia do professor do evento
		 * Parтmetros
		 * $idReserva: ID da reserva da data
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Funчуo: Obter ID da reserva da instтncia do professor do evento
		 * Retorno: ID da reserva da data
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
		
		/*
		 * Funчуo: Definir CPF do professor para instтncia do professor do evento
		 * Parтmetros
		 * $cpfProfessor: CPF do professor
		 */
		public function definirCpfProfessor($cpfProfessor)
		{
			$this->cpfProfessor = $cpfProfessor;
		}
		
		/*
		 * Funчуo: Obter CPF do professor da instтncia do professor do evento
		 * Retorno: CPF do professor
		 */
		public function obterCpfProfessor()
		{
			return $this->cpfProfessor;
		}
	}
?>