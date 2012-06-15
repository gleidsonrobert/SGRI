<?php
	/*
	 * Finalidade: Manipular reservas do sistema no banco de dados
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	interface ReservaBD
	{
		/*
		 * Fun��o: Incluir reserva no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function efetuarReserva();
		
		/*
		 * Fun��o: Excluir reserva do banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function cancelarReserva();
	}
?>