<?php
	/*
	 * Finalidade: Manipular pessoas do sistema no banco de dados
	 * Autor: T�lio Henrique Caf� Carvalhais
	 * Data: 06/04/2012
	 */
	interface PessoaBD
	{
		/*
		 * Fun��o: Incluir pessoa no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function incluirPessoa();
		
		/*
		 * Fun��o: Alterar pessoa no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function alterarPessoa();
		
		/*
		 * Fun��o: Excluir todas as pessoas no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function excluirPessoas();
		
		/*
		 * Fun��o: Listar pessoas no banco de dados
		 * Retorno: Lista de pessoas
		 */
		public static function pesquisarPessoa($cpfPessoa);
		
		/*
		 * Fun��o: Verificar se existe pessoa no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function existePessoa();
	}
?>