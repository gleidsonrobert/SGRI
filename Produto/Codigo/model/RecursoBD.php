<?php
	/*
	 * Finalidade: Manipular recursos do sistema no banco de dados
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 11/04/2012
	 */
	interface RecursoBD
	{
		/*
		 * Funчуo: Incluir recurso no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function incluirRecurso();
		
		/*
		 * Funчуo: Alterar recurso no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function alterarRecurso();
		
		/*
		 * Funчуo: Excluir recurso no banco de dados
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function excluirRecurso();
	}
?>