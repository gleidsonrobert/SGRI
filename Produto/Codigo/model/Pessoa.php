<?php
	/*
	 * Finalidade: Instanciar pessoas do sistema
	 * Autor: T�lio Henrique Caf� Carvalhais
	 * Data: 06/04/2012
	 */
	abstract class Pessoa
	{
		/* Propriedades */
		protected $cpfPessoa;
		protected $nomePessoa;
		protected $nascimentoPessoa;
		protected $sexoPessoa;
		protected $enderecoPessoa;
		protected $cidadePessoa;
		protected $ufPessoa;
		protected $telefonePessoa;
		protected $emailPessoa;
		
		/*
		 * Fun��o: Definir CPF para inst�ncia da pessoa
		 * Par�metros
		 * $cpfPessoa: CPF da pessoa
		 */
		public function definirCpfPessoa($cpfPessoa)
		{
			$this->cpfPessoa = $cpfPessoa;
		}
		
		/*
		 * Fun��o: Obter CPF da inst�ncia da pessoa
		 * Retorno: CPF da pessoa
		 */
		public function obterCpfPessoa()
		{
			return $this->cpfPessoa;
		}
		
		/*
		 * Fun��o: Definir nome para inst�ncia da pessoa
		 * Par�metros
		 * $nomePessoa: nome da pessoa
		 */
		public function definirNomePessoa($nomePessoa)
		{
			$this->nomePessoa = $nomePessoa;
		}
		
		/*
		 * Fun��o: Obter nome da inst�ncia da pessoa
		 * Retorno: nome da pessoa
		 */
		public function obterNomePessoa()
		{
			return $this->nomePessoa;
		}
		
		/*
		 * Fun��o: Definir data de nascimento para inst�ncia da pessoa
		 * Par�metros
		 * $nascimentoPessoa: data de nascimento da pessoa
		 */
		public function definirNascimentoPessoa($nascimentoPessoa)
		{
			$this->nascimentoPessoa = $nascimentoPessoa;
		}
		
		/*
		 * Fun��o: Obter data de nascimento da inst�ncia da pessoa
		 * Retorno: data de nascimento da pessoa
		 */
		public function obterNascimentoPessoa()
		{
			return $this->nascimentoPessoa;
		}
		
		/*
		 * Fun��o: Definir sexo para inst�ncia da pessoa
		 * Par�metros
		 * $sexoPessoa: sexo da pessoa
		 */
		public function definirSexoPessoa($sexoPessoa)
		{
			$this->sexoPessoa = $sexoPessoa;
		}
		
		/*
		 * Fun��o: Obter sexo da inst�ncia da pessoa
		 * Retorno: sexo da pessoa
		 */
		public function obterSexoPessoa()
		{
			return $this->sexoPessoa;
		}
		
		/*
		 * Fun��o: Definir endere�o para inst�ncia da pessoa
		 * Par�metros
		 * $enderecoPessoa: endere�o da pessoa
		 */
		public function definirEnderecoPessoa($enderecoPessoa)
		{
			$this->enderecoPessoa = $enderecoPessoa;
		}
		
		/*
		 * Fun��o: Obter endere�o da inst�ncia da pessoa
		 * Retorno: endere�o da pessoa
		 */
		public function obterEnderecoPessoa()
		{
			return $this->enderecoPessoa;
		}
		
		/*
		 * Fun��o: Definir cidade para inst�ncia da pessoa
		 * Par�metros
		 * $cidadePessoa: cidade da pessoa
		 */
		public function definirCidadePessoa($cidadePessoa)
		{
			$this->cidadePessoa = $cidadePessoa;
		}
		
		/*
		 * Fun��o: Obter cidade da inst�ncia da pessoa
		 * Retorno: cidade da pessoa
		 */
		public function obterCidadePessoa()
		{
			return $this->cidadePessoa;
		}
		
		/*
		 * Fun��o: Definir UF para inst�ncia da pessoa
		 * Par�metros
		 * $ufPessoa: UF da pessoa
		 */
		public function definirUfPessoa($ufPessoa)
		{
			$this->ufPessoa = $ufPessoa;
		}
		
		/*
		 * Fun��o: Obter UF da inst�ncia da pessoa
		 * Retorno: UF da pessoa
		 */
		public function obterUfPessoa()
		{
			return $this->ufPessoa;
		}
		
		/*
		 * Fun��o: Definir telefone para inst�ncia da pessoa
		 * Par�metros
		 * $telefonePessoa: telefone da pessoa
		 */
		public function definirTelefonePessoa($telefonePessoa)
		{
			$this->telefonePessoa = $telefonePessoa;
		}
		
		/*
		 * Fun��o: Obter telefone da inst�ncia da pessoa
		 * Retorno: telefone da pessoa
		 */
		public function obterTelefonePessoa()
		{
			return $this->telefonePessoa;
		}
		
		/*
		 * Fun��o: Definir email para inst�ncia da pessoa
		 * Par�metros
		 * $emailPessoa: email da pessoa
		 */
		public function definirEmailPessoa($emailPessoa)
		{
			$this->emailPessoa = $emailPessoa;
		}
		
		/*
		 * Fun��o: Obter email da inst�ncia da pessoa
		 * Retorno: email da pessoa
		 */
		public function obterEmailPessoa()
		{
			return $this->emailPessoa;
		}
	}
?>