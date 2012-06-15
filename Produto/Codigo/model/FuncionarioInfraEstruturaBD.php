<?php
	include_once ("FuncionarioInfraEstrutura.php");
	include_once ("PessoaBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular funcionсrios de infra-estrutura do sistema no banco de dados
	 * Autor: Wander Maia da Silva
	 * Data: 07/04/2012
	 */
	class FuncionarioInfraEstruturaBD extends FuncionarioInfraEstrutura implements PessoaBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Funчуo: Instanciar o objeto de conexуo com o banco de dados
		 */
		public function FuncionarioInfraEstruturaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Funчуo: Incluir funcionсrio de infra-estrutura no banco de dados
		 * Obs: Implementaчуo do mщtodo abstrato
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function incluirPessoa()
		{
			$data = explode("/", $this->obterNascimentoPessoa());
			$data = $data[2]."/".$data[1]."/".$data[0];
		
			$sql = "INSERT INTO pessoa (cpfPessoa, nomePessoa, nascimentoPessoa, sexoPessoa, enderecoPessoa, cidadePessoa,
			ufPessoa,telefonePessoa, emailPessoa, graduacaoFuncionario, funcaoFuncionario, tipoPessoa)
			VALUES('".$this->obterCpfPessoa()."', '".$this->obterNomePessoa()."', '".$data."',
			'".$this->obterSexoPessoa()."', '".$this->obterEnderecoPessoa()."', '".$this->obterCidadePessoa()."',
			'".$this->obterUfPessoa()."', '".$this->obterTelefonePessoa()."', '".$this->obterEmailPessoa()."',
			'".$this->obterGraduacaoFuncionario()."', '".$this->obterFuncaoFuncionario()."', 'F')";
			
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
		 * Funчуo: Alterar funcionсrio de infra-estrutura no banco de dados
		 * Obs: Implementaчуo do mщtodo abstrato
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function alterarPessoa()
		{
			$data = explode("/", $this->obterNascimentoPessoa());
			$data = $data[2]."/".$data[1]."/".$data[0];
			
			$sql = "UPDATE pessoa SET nomePessoa = '".$this->obterNomePessoa()."' , nascimentoPessoa = '".$data."' ,
			sexoPessoa = '".$this->obterSexoPessoa()."' , enderecoPessoa = '".$this->obterEnderecoPessoa()."' ,
			cidadePessoa = '".$this->obterCidadePessoa()."' , ufPessoa = '".$this->obterUfPessoa()."' ,
			telefonePessoa = '".$this->obterTelefonePessoa()."' , emailPessoa = '".$this->obterEmailPessoa()."' ,
			graduacaoFuncionario = '".$this->obterGraduacaoFuncionario()."' , funcaoFuncionario = '".$this->obterFuncaoFuncionario()."' ,
			tipoPessoa = 'F' WHERE cpfPessoa = '".$this->obterCpfPessoa()."'";
			
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
		 * Funчуo: Excluir todas os funcionсrios de infra-estrutura no banco de dados
		 * Obs: Implementaчуo do mщtodo abstrato
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
		 */
		public function excluirPessoas()
		{
			$sql = "DELETE FROM pessoa WHERE tipoPessoa = 'F'";
			
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
		 * Funчуo: Listar funcionсrios de infra-estrutura no banco de dados
		 * Obs: Implementaчуo do mщtodo abstrato
		 * Retorno: Lista de funcionсrios de infra-estrutura
		 */
		public static function pesquisarPessoa($cpfPessoa)
		{
			$sql = "SELECT cpfPessoa, nomePessoa, nascimentoPessoa, sexoPessoa, enderecoPessoa, cidadePessoa,
							ufPessoa, telefonePessoa, emailPessoa, graduacaoFuncionario, funcaoFuncionario, tipoPessoa
						FROM pessoa
						WHERE tipoPessoa = 'F'";
			
			if ($cpfPessoa != "")
				$sql = $sql." AND cpfPessoa = '".$cpfPessoa."'";
				
			$sql = $sql." ORDER BY nomePessoa";
			
			$result = mysql_query($sql);
			
			return $result;
		}
		
		/*
		 * Funчуo: Verificar se existe funcionсrio de infra-estrutura no banco de dados
		 * Obs: Implementaчуo do mщtodo abstrato
		 * Retorno: Resultado da operaчуo, sucesso (true) ou falha (false)
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
	
	$funcionarioInfraEstruturaBD = new FuncionarioInfraEstruturaBD();
?>