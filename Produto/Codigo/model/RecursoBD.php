<?php
	/*
	 * Finalidade: Manipular recursos do sistema no banco de dados
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 11/04/2012
	 */
	interface RecursoBD
	{
		/*
		 * Fun��o: Incluir recurso no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function incluirRecurso();
		
		/*
		 * Fun��o: Alterar recurso no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function alterarRecurso();
		
		/*
		 * Fun��o: Excluir recurso no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function excluirRecurso();
	}
?>