<?php
	/*
	 * Finalidade: Manipular reservas do sistema no banco de dados
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	interface ReservaBD
	{
		/*
		 * Funчуo: Incluir reserva no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function efetuarReserva();
		
		/*
		 * Funчуo: Excluir reserva do banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function cancelarReserva();
	}
?>