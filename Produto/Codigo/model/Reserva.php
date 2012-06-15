<?php
	/*
	 * Finalidade: Instanciar reservas do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	abstract class Reserva
	{
		/* Propriedades */
		protected $idReserva;
		protected $dataReserva;
		protected $loginUsuario;
		
		/*
		 * Fun��o: Definir ID para inst�ncia da reserva
		 * Par�metros
		 * $idReserva: ID da reserva
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Fun��o: Obter ID da inst�ncia da reserva
		 * Retorno: ID da reserva
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
		
		/*
		 * Fun��o: Definir data para inst�ncia da reserva
		 * Par�metros
		 * $dataReserva: data da reserva
		 */
		public function definirDataReserva($dataReserva)
		{
			$this->dataReserva = $dataReserva;
		}
		
		/*
		 * Fun��o: Obter data da inst�ncia da reserva
		 * Retorno: data da reserva
		 */
		public function obterDataReserva()
		{
			return $this->dataReserva;
		}
		
		/*
		 * Fun��o: Definir login de usu�rio para inst�ncia da reserva
		 * Par�metros
		 * $loginUsuario: login de usu�rio da reserva
		 */
		public function definirLoginUsuario($loginUsuario)
		{
			$this->loginUsuario = $loginUsuario;
		}
		
		/*
		 * Fun��o: Obter login de usu�rio da inst�ncia da reserva
		 * Retorno: login de usu�rio da reserva
		 */
		public function obterLoginUsuario()
		{
			return $this->loginUsuario;
		}
	}
?>