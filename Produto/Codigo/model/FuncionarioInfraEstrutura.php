<?php
	include_once ("Pessoa.php");
	
	/*
	 * Finalidade: Instanciar funcionários de infra-estrutura do sistema
	 * Autor: Wander Maia da Silva
	 * Data: 06/04/2012
	 */
	class FuncionarioInfraEstrutura extends Pessoa
	{
		/* Propriedades */
		private $graduacaoFuncionario;
		private $funcaoFuncionario;
				
		/*
		 * Função: Definir graduação para instância do funcionário de infra-estrutura
		 * Parâmetros
		 * $graduacaoFuncionario: graduação do funcionário de infra-estrutura
		 */
		public function definirGraduacaoFuncionario($graduacaoFuncionario)
		{
			$this->graduacaoFuncionario = $graduacaoFuncionario;
		}
		
		/*
		 * Função: Obter graduação da instância do funcionário de infra-estrutura
		 * Retorno: graduação do funcionário de infra-estrutura
		 */
		public function obterGraduacaoFuncionario()
		{
			return $this->graduacaoFuncionario;
		}
		
		/*
		 * Função: Definir função para instância do funcionário de infra-estrutura
		 * Parâmetros
		 * $funcaoFuncionario: função do funcionário de infra-estrutura
		 */
		public function definirFuncaoFuncionario($funcaoFuncionario)
		{
			$this->funcaoFuncionario = $funcaoFuncionario;
		}
		
		/*
		 * Função: Obter função da instância do funcionário de infra-estrutura
		 * Retorno: função do funcionário de infra-estrutura
		 */
		public function obterFuncaoFuncionario()
		{
			return $this->funcaoFuncionario;
		}
	}
?>