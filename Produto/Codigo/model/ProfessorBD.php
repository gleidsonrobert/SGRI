<?php
	include_once ("Professor.php");
	include_once ("PessoaBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular professores do sistema no banco de dados
	 * Autor: Tъlio Henrique Cafй Carvalhais
	 * Data: 07/04/2012
	 */
	class ProfessorBD extends Professor implements PessoaBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Funзгo: Instanciar o objeto de conexгo com o banco de dados
		 */
		public function ProfessorBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Funзгo: Incluir professor no banco de dados
		 * Obs: Implementaзгo do mйtodo abstrato
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function incluirPessoa()
		{
			$data = explode("/", $this->obterNascimentoPessoa());
			$data = $data[2]."/".$data[1]."/".$data[0];
			
			$sql = "INSERT INTO pessoa (cpfPessoa, nomePessoa, nascimentoPessoa, sexoPessoa, enderecoPessoa, cidadePessoa,
			ufPessoa,telefonePessoa, emailPessoa, graduacaoProfessor, mestradoProfessor, doutoradoProfessor, tipoPessoa)
			VALUES('".$this->obterCpfPessoa()."', '".$this->obterNomePessoa()."', '".$data."',
			'".$this->obterSexoPessoa()."', '".$this->obterEnderecoPessoa()."', '".$this->obterCidadePessoa()."',
			'".$this->obterUfPessoa()."', '".$this->obterTelefonePessoa()."', '".$this->obterEmailPessoa()."',
			'".$this->obterGraduacaoProfessor()."', '".$this->obterMestradoProfessor()."', '".$this->obterDoutoradoProfessor()."', 'P')";
			
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
		 * Funзгo: Alterar professor no banco de dados
		 * Obs: Implementaзгo do mйtodo abstrato
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
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
			doutoradoProfessor = '".$this->obterDoutoradoProfessor()."' ,
			tipoPessoa = 'P' WHERE cpfPessoa = '".$this->obterCpfPessoa()."'";
			
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
		 * Funзгo: Excluir todas os professores no banco de dados
		 * Obs: Implementaзгo do mйtodo abstrato
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
		 */
		public function excluirPessoas()
		{
			$sql = "DELETE FROM pessoa WHERE tipoPessoa = 'P'";
			
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
		 * Funзгo: Listar professores no banco de dados
		 * Obs: Implementaзгo do mйtodo abstrato
		 * Retorno: Lista de professores
		 */
		public static function pesquisarPessoa($cpfPessoa)
		{
			$sql = "SELECT cpfPessoa, nomePessoa, nascimentoPessoa, sexoPessoa, enderecoPessoa, cidadePessoa, ufPessoa,
							telefonePessoa,	emailPessoa, graduacaoProfessor, mestradoProfessor, doutoradoProfessor, tipoPessoa
						FROM pessoa
						WHERE tipoPessoa = 'P'";
			
			if ($cpfPessoa != "")
				$sql = $sql." AND cpfPessoa = '".$cpfPessoa."'";
			
			$sql = $sql." ORDER BY nomePessoa";
			
			$result = mysql_query($sql);
			
			return $result;
		}
		
		/*
		 * Funзгo: Verificar se existe professor no banco de dados
		 * Obs: Implementaзгo do mйtodo abstrato
		 * Retorno: Resultado da operaзгo, sucesso (true) ou falha (false)
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
	
	$professorBD = new ProfessorBD();
?>