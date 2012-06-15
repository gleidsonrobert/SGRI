<?php
	include_once ("Ocorrencia.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular equipamento do sistema no banco de dados
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 31/05/2012
	 */
	class OcorrenciaBD extends Ocorrencia
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de conex�o com o banco de dados
		 */
		public function OcorrenciaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Fun��o: Incluir ocorr�ncia no banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function incluirOcorrencia()
		{
			$sql = "INSERT INTO ocorrencia (loginUsuario, descricaoOcorrencia, dataOcorrencia)
			VALUES('".$this->obterLoginUsuario()."', '".$this->obterDescricaoOcorrencia()."',
			'".$this->obterDataOcorrencia()."')";
			
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
		 * Fun��o: Excluir ocorr�ncia do banco de dados
		 * Retorno: Resultado da opera��o, sucesso (true) ou falha (false)
		 */
		public function excluirOcorrencia()
		{
			$sql = "DELETE FROM ocorrencia WHERE idOcorrencia = '".$this->obterIdOcorrencia()."'";
			
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
		 * Fun��o: Listar ocorr�ncias no banco de dados
		 * Retorno: Lista de equipamentos
		 */
		public static function pesquisarOcorrencia($idOcorrencia, $descricaoOcorrencia, $dataOcorrencia, $loginUsuario)
		{
			$sql = "SELECT idOcorrencia, descricaoOcorrencia, dataOcorrencia, loginUsuario
						FROM ocorrencia
						WHERE 1 = 1";
			
			if ($idOcorrencia != "")
				$sql = $sql." AND idOcorrencia = '".$idOcorrencia."'";
			
			if ($descricaoOcorrencia != "")
				$sql = $sql." AND descricaoOcorrencia LIKE '%".$descricaoOcorrencia."%'";
			
			if ($dataOcorrencia != "")
				$sql = $sql." AND dataOcorrencia = '".$dataOcorrencia."'";
				
			if ($loginUsuario != "")
				$sql = $sql." AND loginUsuario LIKE '%".$loginUsuario."%'";
			
			$sql = $sql." ORDER BY dataOcorrencia";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$ocorrenciaBD = new OcorrenciaBD();
?>