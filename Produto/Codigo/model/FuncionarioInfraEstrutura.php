<?php
	include_once ("Pessoa.php");
	
	/*
	 * Finalidade: Instanciar funcion�rios de infra-estrutura do sistema
	 * Autor: Wander Maia da Silva
	 * Data: 06/04/2012
	 */
	class FuncionarioInfraEstrutura extends Pessoa
	{
		/* Propriedades */
		private $graduacaoFuncionario;
		private $funcaoFuncionario;
				
		/*
		 * Fun��o: Definir gradua��o para inst�ncia do funcion�rio de infra-estrutura
		 * Par�metros
		 * $graduacaoFuncionario: gradua��o do funcion�rio de infra-estrutura
		 */
		public function definirGraduacaoFuncionario($graduacaoFuncionario)
		{
			$this->graduacaoFuncionario = $graduacaoFuncionario;
		}
		
		/*
		 * Fun��o: Obter gradua��o da inst�ncia do funcion�rio de infra-estrutura
		 * Retorno: gradua��o do funcion�rio de infra-estrutura
		 */
		public function obterGraduacaoFuncionario()
		{
			return $this->graduacaoFuncionario;
		}
		
		/*
		 * Fun��o: Definir fun��o para inst�ncia do funcion�rio de infra-estrutura
		 * Par�metros
		 * $funcaoFuncionario: fun��o do funcion�rio de infra-estrutura
		 */
		public function definirFuncaoFuncionario($funcaoFuncionario)
		{
			$this->funcaoFuncionario = $funcaoFuncionario;
		}
		
		/*
		 * Fun��o: Obter fun��o da inst�ncia do funcion�rio de infra-estrutura
		 * Retorno: fun��o do funcion�rio de infra-estrutura
		 */
		public function obterFuncaoFuncionario()
		{
			return $this->funcaoFuncionario;
		}
	}
?>