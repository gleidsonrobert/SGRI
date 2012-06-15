<?php
	include_once ("Reserva.php");
	
	/*
	 * Finalidade: Instanciar reservas de evento do sistema
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ReservaEvento extends Reserva
	{
		/* Propriedades */
		private $nomeEvento;
		private $inicioEvento;
		private $fimEvento;
		
		/*
		 * Função: Definir nome do evento para instância da reserva
		 * Parâmetros
		 * $nomeEvento: nome do evento
		 */
		public function definirNomeEvento($nomeEvento)
		{
			$this->nomeEvento = $nomeEvento;
		}
		
		/*
		 * Função: Obter nome do evento da instância da reserva
		 * Retorno: nome do evento
		 */
		public function obterNomeEvento()
		{
			return $this->nomeEvento;
		}
		
		/*
		 * Função: Definir data de início do evento para instância da reserva
		 * Parâmetros
		 * $inicioEvento: data de início do evento
		 */
		public function definirInicioEvento($inicioEvento)
		{
			$this->inicioEvento = $inicioEvento;
		}
		
		/*
		 * Função: Obter data de início do evento da instância da reserva
		 * Retorno: data de início do evento
		 */
		public function obterInicioEvento()
		{
			return $this->inicioEvento;
		}
		
		/*
		 * Função: Definir data de fim do evento para instância da reserva
		 * Parâmetros
		 * $fimEvento: data de fim do evento
		 */
		public function definirFimEvento($fimEvento)
		{
			$this->fimEvento = $fimEvento;
		}
		
		/*
		 * Função: Obter data de fim do evento da instância da reserva
		 * Retorno: data de fim do evento
		 */
		public function obterFimEvento()
		{
			return $this->fimEvento;
		}
	}
?>