<?php
	/*
	 * Finalidade: Fazer a conexão entre o sistema e o banco de dados
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 06/04/2012
	 */
	class ConexaoBD
	{
		/* Propriedades */
		private $servidor = "localhost";	/* Nome do Servidor */
		private $usuario = "root";			/* Login de Usuário do Servidor */
		private $senha = "";				/* Senha de Usuário do Servidor */
		private $banco = "ti";		        /* Nome do Banco de Dados */
		private $conexao;					/* Instância da Conexão com o Servidor */
		private $con;						/* Instância da Conexão com o Banco de Dados */
		
		/*
		 * Construtora
		 * Função: Instanciar uma conexão com o banco de dados
		 */
		public function ConexaoBD()
		{
			// Conectando ao Servidor
			if(!($this->conexao = mysql_connect($this->servidor, $this->usuario, $this->senha))) {
				echo "Não foi possível estabelecer uma conexão com o servidor MySQL. Favor Contactar o Administrador.";
				//exit;
			}
			
			// Selecionando o Banco de Dados
			if(!($this->con = mysql_select_db($this->banco, $this->conexao))) {
				echo "Não foi possível estabelecer uma conexão com o banco de dados. Favor Contactar o Administrador.";
				exit;
			}
			
			mysql_set_charset('utf8');
		}
	}
?>