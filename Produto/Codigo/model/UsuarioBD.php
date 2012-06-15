<?php
	include_once ("Usuario.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular usuбrios do sistema no banco de dados
	 * Autor: Rфmulo de Oliveira Jorge
	 * Data: 06/04/2012
	 */
	class UsuarioBD extends Usuario
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Funзгo: Instanciar o objeto de conexгo com o banco de dados
		 */
		public function UsuarioBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Funзгo: Gerar uma senha aleatуria para um usuбrio novo
		 * Retorno: Senha gerada
		 */
		private function gerarSenhaUsuario()
		{
			$letras = "A,B,C,D,E,F,G,H,I,J,K,1,2,3,4,5,6,7,8,9,0";
			$array = explode(",", $letras);
			shuffle($array);
			$senha = implode($array, "");
			return substr($senha, 0, 6);
		}
		
		/*
		 * Funзгo: Incluir usuбrio no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function incluirUsuario()
		{
			$this->definirSenhaUsuario($this->GerarSenhaUsuario());
			
			$sql = "INSERT INTO usuario (loginUsuario, cpfPessoa, senhaUsuario, permissaoUsuario)
			VALUES('".$this->obterLoginUsuario()."', '".$this->obterCpfPessoa()."',
			'".$this->obterSenhaUsuario()."', '".$this->obterPermissaoUsuario()."')";
			
			$result = mysql_query($sql);
			
			if (!$result)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
		 * Funзгo: Alterar usuбrio no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function alterarUsuario()
		{
			$sql = "UPDATE usuario SET cpfPessoa = '".$this->obterCpfPessoa()."' ,
			senhaUsuario = '".$this->obterSenhaUsuario()."' , permissaoUsuario = '".$this->obterPermissaoUsuario()."'
			WHERE loginUsuario = '".$this->obterLoginUsuario()."'";
			
			$result = mysql_query($sql);
			
			if (!$result)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
		 * Funзгo: Excluir usuбrio no banco de dados
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function excluirUsuario()
		{
			$sql = "DELETE FROM usuario WHERE loginUsuario = '".$this->obterLoginUsuario()."'";
			
			$result = mysql_query($sql);
			
			if (!$result)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
		 * Funзгo: Listar usuбrios no banco de dados
		 * Retorno: Lista de usuбrios
		 */
		public static function pesquisarUsuario($loginUsuario)
		{
			$sql = "SELECT loginUsuario, cpfPessoa, nomePessoa, senhaUsuario, permissaoUsuario
						FROM usuario NATURAL JOIN pessoa
						WHERE 1 = 1";
			
			if ($loginUsuario != "")
				$sql = $sql." AND (loginUsuario LIKE '%".$loginUsuario."%' OR nomePessoa LIKE '%".$loginUsuario."%')";
			
			$sql = $sql." ORDER BY nomePessoa";
			
			$result = mysql_query($sql);
			
			return $result;
		}
		
		/*
		 * Funзгo: Validar usuбrio
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function validarUsuario()
		{
			$sql = "SELECT loginUsuario 
						FROM usuario 
						WHERE loginUsuario = '".$this->obterLoginUsuario()."' AND senhaUsuario = '".$this->obterSenhaUsuario()."'";
			
			$result = mysql_query($sql);
			
			if (mysql_num_rows($result) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	$usuarioBD = new UsuarioBD();
?>