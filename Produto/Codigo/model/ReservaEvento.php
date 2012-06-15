<?php
	include_once ("Reserva.php");
	
	/*
	 * Finalidade: Instanciar reservas de evento do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ReservaEvento extends Reserva
	{
		/* Propriedades */
		private $nomeEvento;
		private $inicioEvento;
		private $fimEvento;
		
		/*
		 * Fun��o: Definir nome do evento para inst�ncia da reserva
		 * Par�metros
		 * $nomeEvento: nome do evento
		 */
		public function definirNomeEvento($nomeEvento)
		{
			$this->nomeEvento = $nomeEvento;
		}
		
		/*
		 * Fun��o: Obter nome do evento da inst�ncia da reserva
		 * Retorno: nome do evento
		 */
		public function obterNomeEvento()
		{
			return $this->nomeEvento;
		}
		
		/*
		 * Fun��o: Definir data de in�cio do evento para inst�ncia da reserva
		 * Par�metros
		 * $inicioEvento: data de in�cio do evento
		 */
		public function definirInicioEvento($inicioEvento)
		{
			$this->inicioEvento = $inicioEvento;
		}
		
		/*
		 * Fun��o: Obter data de in�cio do evento da inst�ncia da reserva
		 * Retorno: data de in�cio do evento
		 */
		public function obterInicioEvento()
		{
			return $this->inicioEvento;
		}
		
		/*
		 * Fun��o: Definir data de fim do evento para inst�ncia da reserva
		 * Par�metros
		 * $fimEvento: data de fim do evento
		 */
		public function definirFimEvento($fimEvento)
		{
			$this->fimEvento = $fimEvento;
		}
		
		/*
		 * Fun��o: Obter data de fim do evento da inst�ncia da reserva
		 * Retorno: data de fim do evento
		 */
		public function obterFimEvento()
		{
			return $this->fimEvento;
		}
	}
?>