<?php
	include_once ("Coordenador.php");
	include_once ("PessoaBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular coordenadores do sistema no banco de dados
	 * Autor: Wander Maia da Silva
	 * Data: 07/04/2012
	 */
	class CoordenadorBD extends Coordenador implements PessoaBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de conex�o com o banco de dados
		 */
		public function CoordenadorBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Fun��o: Incluir coordenador no banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function incluirPessoa()
		{
			$data = explode("/", $this->obterNascimentoPessoa());
			$data = $data[2]."/".$data[1]."/".$data[0];
			
			$sql = "INSERT INTO pessoa (cpfPessoa, nomePessoa, nascimentoPessoa, sexoPessoa, enderecoPessoa, cidadePessoa,
			ufPessoa,telefonePessoa, emailPessoa, graduacaoProfessor, mestradoProfessor, doutoradoProfessor, cursoCoordenador, tipoPessoa)
			VALUES('".$this->obterCpfPessoa()."', '".$this->obterNomePessoa()."', '".$data."',
			'".$this->obterSexoPessoa()."', '".$this->obterEnderecoPessoa()."', '".$this->obterCidadePessoa()."',
			'".$this->obterUfPessoa()."', '".$this->obterTelefonePessoa()."', '".$this->obterEmailPessoa()."', '".$this->obterGraduacaoProfessor()."', 
			'".$this->obterMestradoProfessor()."', '".$this->obterDoutoradoProfessor()."', '".$this->obterCursoCoordenador()."', 'C')";
			
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
		 * Fun��o: Alterar coordenador no banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function alterarPessoa()
		{
			$data = explode("/", $this->obterNascimentoPessoa());
			$data = $data[2]."/".$data[1]."/".$data[0];
			
			$sql = "UPDATE pessoa SET nomePessoa = '".$this->obterNomePessoa()."' , nascimentoPessoa = '".$data."' ,
			sexoPessoa = '".$this->obterSexoPessoa()."' , enderecoPessoa = '".$this->obterEnderecoPessoa()."' ,
			cidadePessoa = '".$this->obterCidadePessoa()."' , ufPessoa = '".$this->obterUfPessoa()."' ,
			telefonePessoa = '".$this->obterTelefonePessoa()."' , emailPessoa = '".$this->obterEmailPessoa()."' ,
			graduacaoProfessor = '".$this->obterGraduacaoProfessor()."' , mestradoProfessor = '".$this->obterMestradoProfessor()."' ,
			doutoradoProfessor = '".$this->obterDoutoradoProfessor()."' , cursoCoordenador = '".$this->obterCursoCoordenador()."' ,
			tipoPessoa = 'C' WHERE cpfPessoa = '".$this->obterCpfPessoa()."'";
			
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
		 * Fun��o: Excluir todas os coordenadores no banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function excluirPessoas()
		{
			$sql = "DELETE FROM pessoa WHERE tipoPessoa = 'C'";
			
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
		 * Fun��o: Listar coordenadores no banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Lista de coordenadores
		 */
		public static function pesquisarPessoa($cpfPessoa)
		{
			$sql = "SELECT cpfPessoa, nomePessoa, nascimentoPessoa, sexoPessoa, enderecoPessoa, cidadePessoa, ufPessoa, telefonePessoa,
							emailPessoa, graduacaoProfessor, mestradoProfessor, doutoradoProfessor, cursoCoordenador, tipoPessoa
						FROM pessoa
						WHERE tipoPessoa = 'C'";
			
			if ($cpfPessoa != "")
				$sql = $sql." AND cpfPessoa = '".$cpfPessoa."'";
			
			$sql = $sql." ORDER BY nomePessoa";
			
			$result = mysql_query($sql);
			
			return $result;
		}
		
		/*
		 * Fun��o: Verificar se existe coordenador no banco de dados
		 * Obs: Implementa��o do m�todo abstrato
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function existePessoa()
		{
			$sql = "SELECT cpfPessoa
						FROM pessoa 
						WHERE cpfPessoa = '".$this->obterCpfPessoa()."'";
			
			$result = mysql_query($sql);
			
			if (mysql_num_rows($result) > 0)
				return true;
			else
				return false;
		}
	}
	
	$coordenadorBD = new CoordenadorBD();
?>