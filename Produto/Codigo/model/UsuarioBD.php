<?php
	include_once ("Usuario.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular usu�rios do sistema no banco de dados
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 06/04/2012
	 */
	class UsuarioBD extends Usuario
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de conex�o com o banco de dados
		 */
		public function UsuarioBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Fun��o: Gerar uma senha aleat�ria para um usu�rio novo
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
		 * Fun��o: Incluir usu�rio no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
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
		 * Fun��o: Alterar usu�rio no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
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
		 * Fun��o: Excluir usu�rio no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
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
		 * Fun��o: Listar usu�rios no banco de dados
		 * Retorno: Lista de usu�rios
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
		 * Fun��o: Validar usu�rio
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
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