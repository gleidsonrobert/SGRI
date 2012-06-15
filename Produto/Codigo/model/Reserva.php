<?php
	/*
	 * Finalidade: Instanciar reservas do sistema
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	abstract class Reserva
	{
		/* Propriedades */
		protected $idReserva;
		protected $dataReserva;
		protected $loginUsuario;
		
		/*
		 * Função: Definir ID para instância da reserva
		 * Parâmetros
		 * $idReserva: ID da reserva
		 */
		public function definirIdReserva($idReserva)
		{
			$this->idReserva = $idReserva;
		}
		
		/*
		 * Função: Obter ID da instância da reserva
		 * Retorno: ID da reserva
		 */
		public function obterIdReserva()
		{
			return $this->idReserva;
		}
		
		/*
		 * Função: Definir data para instância da reserva
		 * Parâmetros
		 * $dataReserva: data da reserva
		 */
		public function definirDataReserva($dataReserva)
		{
			$this->dataReserva = $dataReserva;
		}
		
		/*
		 * Função: Obter data da instância da reserva
		 * Retorno: data da reserva
		 */
		public function obterDataReserva()
		{
			return $this->dataReserva;
		}
		
		/*
		 * Função: Definir login de usuário para instância da reserva
		 * Parâmetros
		 * $loginUsuario: login de usuário da reserva
		 */
		public function definirLoginUsuario($loginUsuario)
		{
			$this->loginUsuario = $loginUsuario;
		}
		
		/*
		 * Função: Obter login de usuário da instância da reserva
		 * Retorno: login de usuário da reserva
		 */
		public function obterLoginUsuario()
		{
			return $this->loginUsuario;
		}
	}
?>