<?php
	/*
	 * Finalidade: Instanciar datas de evento do sistema
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class DataEvento
	{
		/* Propriedades */
		private $idData;
		private $dataEvento;
		private $idReserva;
		
		/*
		 * Funчуo: Definir ID para instтncia da data do evento
		 * Parтmetros
		 * $idData: ID da data
		 */
		public function definirIdData($idData)
		{
			$this->idData = $idData;
		}
		
		/*
		 * Funчуo: Obter ID da instтncia da data do evento
		 * Retorno: ID da data
		 */
		public function obterIdData()
		{
			return $this->idData;
		}
		
		/*
		 * Funчуo: Definir data para instтncia da data do evento
		 * Parтmetros
		 * $dataEvento: data do evento
		 */
		public function definirDataEvento($dataEvento)
		{
			$this->dataEvento = $dataEvento;
		}
		
		/*
		 * Funчуo: Obter data da instтncia da data do evento
		 * Retorno: data do evento
		 */
		public function obterDataEvento()
		{
			return $this->dataEvento;
		}
		
		/*
		 * Funчуo: Definir ID da reserva para instтncia da data do evento
		 * Parтmetros
		 * $idReserva: ID da reserva da data
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Funчуo: Obter ID da reserva da instтncia da data do evento
		 * Retorno: ID da reserva da data
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
	}
?>