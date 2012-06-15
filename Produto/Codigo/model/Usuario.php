<?php
	/*
	 * Finalidade: Instanciar usuários do sistema
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 06/04/2012
	 */
	class Usuario
	{
		/* Propriedades */
		private $loginUsuario;
		private $cpfPessoa;
		private $senhaUsuario;
		private $permissaoUsuario;
		
		/*
		 * Função: Definir login para instância do usuário
		 * Parâmetros
		 * $loginUsuario: Login do usuário
		 */
		public function definirLoginUsuario($loginUsuario)
		{
			$this->loginUsuario = $loginUsuario;
		}
		
		/*
		 * Função: Obter login da instância do usuário
		 * Retorno: Login do usuário
		 */
		public function obterLoginUsuario()
		{
			return $this->loginUsuario;
		}
		
		/*
		 * Função: Definir CPF da pessoa referente à instância do usuário
		 * Parâmetros
		 * $cpfPessoa: CPF da pessoa referente ao usuário
		 */
		public function definirCpfPessoa($cpfPessoa)
		{
			$this->cpfPessoa = $cpfPessoa;
		}
		
		/*
		 * Função: Obter CPF da pessoa referente à instância do usuário
		 * Retorno: CPF da pessoa referente ao usuário
		 */
		public function obterCpfPessoa()
		{
			return $this->cpfPessoa;
		}
		
		/*
		 * Função: Definir senha para instância do usuário
		 * Parâmetros
		 * $senhaUsuario: Senha do usuário
		 */
		public function definirSenhaUsuario($senhaUsuario)
		{
			$this->senhaUsuario = $senhaUsuario;
		}
		
		/*
		 * Função: Obter senha da instância do usuário
		 * Retorno: Senha do usuário
		 */
		public function obterSenhaUsuario()
		{
			return $this->senhaUsuario;
		}
		
		/*
		 * Função: Definir tipo de permissão para instância do usuário
		 * Parâmetros
		 * $permissaoUsuario: Tipo de permissão do usuário
		 */
		public function definirPermissaoUsuario($permissaoUsuario)
		{
			$this->permissaoUsuario = $permissaoUsuario;
		}
		
		/*
		 * Função: Obter tipo de permissão da instância do usuário
		 * Retorno: Tipo de permissão do usuário
		 */
		public function obterPermissaoUsuario()
		{
			return $this->permissaoUsuario;
		}
	}
?>