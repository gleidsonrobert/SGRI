<?php
	/*
	 * Finalidade: Instanciar datas de evento do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class DataEvento
	{
		/* Propriedades */
		private $idData;
		private $dataEvento;
		private $idReserva;
		
		/*
		 * Fun��o: Definir ID para inst�ncia da data do evento
		 * Par�metros
		 * $idData: ID da data
		 */
		public function definirIdData($idData)
		{
			$this->idData = $idData;
		}
		
		/*
		 * Fun��o: Obter ID da inst�ncia da data do evento
		 * Retorno: ID da data
		 */
		public function obterIdData()
		{
			return $this->idData;
		}
		
		/*
		 * Fun��o: Definir data para inst�ncia da data do evento
		 * Par�metros
		 * $dataEvento: data do evento
		 */
		public function definirDataEvento($dataEvento)
		{
			$this->dataEvento = $dataEvento;
		}
		
		/*
		 * Fun��o: Obter data da inst�ncia da data do evento
		 * Retorno: data do evento
		 */
		public function obterDataEvento()
		{
			return $this->dataEvento;
		}
		
		/*
		 * Fun��o: Definir ID da reserva para inst�ncia da data do evento
		 * Par�metros
		 * $idReserva: ID da reserva da data
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Fun��o: Obter ID da reserva da inst�ncia da data do evento
		 * Retorno: ID da reserva da data
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
	}
?>