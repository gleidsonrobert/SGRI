<?php
	/*
	 * Finalidade: Manipular pessoas do sistema no banco de dados
	 * Autor: Tъlio Henrique Cafй Carvalhais
	 * Data: 06/04/2012
	 */
	interface PessoaBD
	{
		/*
		 * Funзгo: Incluir pessoa no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function incluirPessoa();
		
		/*
		 * Funзгo: Alterar pessoa no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function alterarPessoa();
		
		/*
		 * Funзгo: Excluir todas as pessoas no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function excluirPessoas();
		
		/*
		 * Funзгo: Listar pessoas no banco de dados
		 * Retorno: Lista de pessoas
		 */
		public static function pesquisarPessoa($cpfPessoa);
		
		/*
		 * Funзгo: Verificar se existe pessoa no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function existePessoa();
	}
?>