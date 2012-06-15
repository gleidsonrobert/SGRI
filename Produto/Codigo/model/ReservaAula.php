<?php
	include_once ("Reserva.php");
	
	/*
	 * Finalidade: Instanciar reservas de aula do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ReservaAula extends Reserva
	{
		/* Propriedades */
		private $dataAula;
		private $idHorario;
		
		/*
		 * Fun��o: Definir data da aula para inst�ncia da reserva
		 * Par�metros
		 * $dataAula: data da aula
		 */
		public function definirDataAula($dataAula)
		{
			$this->dataAula = $dataAula;
		}
		
		/*
		 * Fun��o: Obter data da aula da inst�ncia da reserva
		 * Retorno: data da aula
		 */
		public function obterDataAula()
		{
			return $this->dataAula;
		}
		
		/*
		 * Fun��o: Definir ID do hor�rio para inst�ncia da reserva
		 * Par�metros
		 * $idHorario: ID do hor�rio
		 */
		public function definirIdHorario($idHorario)
		{
			$this->idHorario = $idHorario;
		}
		
		/*
		 * Fun��o: Obter ID do hor�rio da inst�ncia da reserva
		 * Retorno: ID do hor�rio
		 */
		public function obterIdHorario()
		{
			return $this->idHorario;
		}
	}
?>