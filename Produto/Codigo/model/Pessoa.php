<?php
	/*
	 * Finalidade: Instanciar pessoas do sistema
	 * Autor: Túlio Henrique Café Carvalhais
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
		 * Função: Definir CPF para instância da pessoa
		 * Parâmetros
		 * $cpfPessoa: CPF da pessoa
		 */
		public function definirCpfPessoa($cpfPessoa)
		{
			$this->cpfPessoa = $cpfPessoa;
		}
		
		/*
		 * Função: Obter CPF da instância da pessoa
		 * Retorno: CPF da pessoa
		 */
		public function obterCpfPessoa()
		{
			return $this->cpfPessoa;
		}
		
		/*
		 * Função: Definir nome para instância da pessoa
		 * Parâmetros
		 * $nomePessoa: nome da pessoa
		 */
		public function definirNomePessoa($nomePessoa)
		{
			$this->nomePessoa = $nomePessoa;
		}
		
		/*
		 * Função: Obter nome da instância da pessoa
		 * Retorno: nome da pessoa
		 */
		public function obterNomePessoa()
		{
			return $this->nomePessoa;
		}
		
		/*
		 * Função: Definir data de nascimento para instância da pessoa
		 * Parâmetros
		 * $nascimentoPessoa: data de nascimento da pessoa
		 */
		public function definirNascimentoPessoa($nascimentoPessoa)
		{
			$this->nascimentoPessoa = $nascimentoPessoa;
		}
		
		/*
		 * Função: Obter data de nascimento da instância da pessoa
		 * Retorno: data de nascimento da pessoa
		 */
		public function obterNascimentoPessoa()
		{
			return $this->nascimentoPessoa;
		}
		
		/*
		 * Função: Definir sexo para instância da pessoa
		 * Parâmetros
		 * $sexoPessoa: sexo da pessoa
		 */
		public function definirSexoPessoa($sexoPessoa)
		{
			$this->sexoPessoa = $sexoPessoa;
		}
		
		/*
		 * Função: Obter sexo da instância da pessoa
		 * Retorno: sexo da pessoa
		 */
		public function obterSexoPessoa()
		{
			return $this->sexoPessoa;
		}
		
		/*
		 * Função: Definir endereço para instância da pessoa
		 * Parâmetros
		 * $enderecoPessoa: endereço da pessoa
		 */
		public function definirEnderecoPessoa($enderecoPessoa)
		{
			$this->enderecoPessoa = $enderecoPessoa;
		}
		
		/*
		 * Função: Obter endereço da instância da pessoa
		 * Retorno: endereço da pessoa
		 */
		public function obterEnderecoPessoa()
		{
			return $this->enderecoPessoa;
		}
		
		/*
		 * Função: Definir cidade para instância da pessoa
		 * Parâmetros
		 * $cidadePessoa: cidade da pessoa
		 */
		public function definirCidadePessoa($cidadePessoa)
		{
			$this->cidadePessoa = $cidadePessoa;
		}
		
		/*
		 * Função: Obter cidade da instância da pessoa
		 * Retorno: cidade da pessoa
		 */
		public function obterCidadePessoa()
		{
			return $this->cidadePessoa;
		}
		
		/*
		 * Função: Definir UF para instância da pessoa
		 * Parâmetros
		 * $ufPessoa: UF da pessoa
		 */
		public function definirUfPessoa($ufPessoa)
		{
			$this->ufPessoa = $ufPessoa;
		}
		
		/*
		 * Função: Obter UF da instância da pessoa
		 * Retorno: UF da pessoa
		 */
		public function obterUfPessoa()
		{
			return $this->ufPessoa;
		}
		
		/*
		 * Função: Definir telefone para instância da pessoa
		 * Parâmetros
		 * $telefonePessoa: telefone da pessoa
		 */
		public function definirTelefonePessoa($telefonePessoa)
		{
			$this->telefonePessoa = $telefonePessoa;
		}
		
		/*
		 * Função: Obter telefone da instância da pessoa
		 * Retorno: telefone da pessoa
		 */
		public function obterTelefonePessoa()
		{
			return $this->telefonePessoa;
		}
		
		/*
		 * Função: Definir email para instância da pessoa
		 * Parâmetros
		 * $emailPessoa: email da pessoa
		 */
		public function definirEmailPessoa($emailPessoa)
		{
			$this->emailPessoa = $emailPessoa;
		}
		
		/*
		 * Função: Obter email da instância da pessoa
		 * Retorno: email da pessoa
		 */
		public function obterEmailPessoa()
		{
			return $this->emailPessoa;
		}
	}
?>