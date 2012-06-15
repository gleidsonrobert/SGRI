<?php
	/*
	 * Finalidade: Instanciar usu�rios do sistema
	 * Autor: R�mulo de Oliveira Jorge
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
		 * Fun��o: Definir login para inst�ncia do usu�rio
		 * Par�metros
		 * $loginUsuario: Login do usu�rio
		 */
		public function definirLoginUsuario($loginUsuario)
		{
			$this->loginUsuario = $loginUsuario;
		}
		
		/*
		 * Fun��o: Obter login da inst�ncia do usu�rio
		 * Retorno: Login do usu�rio
		 */
		public function obterLoginUsuario()
		{
			return $this->loginUsuario;
		}
		
		/*
		 * Fun��o: Definir CPF da pessoa referente � inst�ncia do usu�rio
		 * Par�metros
		 * $cpfPessoa: CPF da pessoa referente ao usu�rio
		 */
		public function definirCpfPessoa($cpfPessoa)
		{
			$this->cpfPessoa = $cpfPessoa;
		}
		
		/*
		 * Fun��o: Obter CPF da pessoa referente � inst�ncia do usu�rio
		 * Retorno: CPF da pessoa referente ao usu�rio
		 */
		public function obterCpfPessoa()
		{
			return $this->cpfPessoa;
		}
		
		/*
		 * Fun��o: Definir senha para inst�ncia do usu�rio
		 * Par�metros
		 * $senhaUsuario: Senha do usu�rio
		 */
		public function definirSenhaUsuario($senhaUsuario)
		{
			$this->senhaUsuario = $senhaUsuario;
		}
		
		/*
		 * Fun��o: Obter senha da inst�ncia do usu�rio
		 * Retorno: Senha do usu�rio
		 */
		public function obterSenhaUsuario()
		{
			return $this->senhaUsuario;
		}
		
		/*
		 * Fun��o: Definir tipo de permiss�o para inst�ncia do usu�rio
		 * Par�metros
		 * $permissaoUsuario: Tipo de permiss�o do usu�rio
		 */
		public function definirPermissaoUsuario($permissaoUsuario)
		{
			$this->permissaoUsuario = $permissaoUsuario;
		}
		
		/*
		 * Fun��o: Obter tipo de permiss�o da inst�ncia do usu�rio
		 * Retorno: Tipo de permiss�o do usu�rio
		 */
		public function obterPermissaoUsuario()
		{
			return $this->permissaoUsuario;
		}
	}
?>