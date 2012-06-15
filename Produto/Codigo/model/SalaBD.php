<?php
	include_once ("Sala.php");
	include_once ("RecursoBD.php");
	include_once ("banco/ConexaoBD.php");
	
	/*
	 * Finalidade: Manipular sala do sistema no banco de dados
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 12/04/2012
	 */
	class SalaBD extends Sala implements RecursoBD
	{
		/* Propriedades */
		private $bd;
		
		/*
		 * Construtora
		 * Função: Instanciar o objeto de conexão com o banco de dados
		 */
		public function SalaBD()
		{
			$this->bd = new ConexaoBD();
		}
		
		/*
		 * Função: Incluir sala no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
		 */
		public function incluirRecurso()
		{
			$sql = "INSERT INTO recurso (numeroSala, descricaoSala, localizacaoSala, capacidadeSala, tipoSala, tipoRecurso)
			VALUES('".$this->obterNumeroSala()."', '".$this->obterDescricaoSala()."',
			'".$this->obterLocalizacaoSala()."', '".$this->obterCapacidadeSala()."', '".$this->obterTipoSala()."', 'S')";
			
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
		 * Função: Alterar sala no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
		 */
		public function alterarRecurso()
		{
			$sql = "UPDATE recurso SET numeroSala = '".$this->obterNumeroSala()."' , 
			descricaoSala = '".$this->obterDescricaoSala()."' , localizacaoSala = '".$this->obterLocalizacaoSala()."' ,
			capacidadeSala = '".$this->obterCapacidadeSala()."' , tipoSala = '".$this->obterTipoSala()."' ,
			tipoRecurso = 'S' WHERE idRecurso = '".$this->obterIdRecurso()."'";
			
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
		 * Função: Excluir sala do banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Resultado da operação, sucesso (true) ou falha (false)
		 */
		public function excluirRecurso()
		{
			$sql = "DELETE FROM recurso WHERE idRecurso = '".$this->obterIdRecurso()."' AND tipoRecurso = 'S'";
			
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
		 * Função: Listar salas no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Lista de salas
		 */
		public static function pesquisarRecurso($idRecurso, $numeroSala, $descricaoSala, $localizacaoSala, $capacidadeSala, $tipoSala)
		{
			$sql = "SELECT idRecurso, numeroSala, descricaoSala, localizacaoSala, capacidadeSala, tipoSala
						FROM recurso
						WHERE tipoRecurso = 'S'";
			
			if ($idRecurso != "")
				$sql = $sql." AND idRecurso = '".$idRecurso."'";
			
			if ($numeroSala != "")
				$sql = $sql." AND numeroSala LIKE '%".$numeroSala."%'";
						
			if ($descricaoSala != "")
				$sql = $sql." AND descricaoSala LIKE '%".$descricaoSala."%'";
				
			if ($localizacaoSala != "")
				$sql = $sql." AND localizacaoSala LIKE '%".$localizacaoSala."%'";
				
			if ($capacidadeSala != "")
				$sql = $sql." AND capacidadeSala LIKE '%".$capacidadeSala."%'";
				
			if ($tipoSala != "")
				$sql = $sql." AND tipoSala LIKE '%".$tipoSala."%'";
			
			$sql = $sql." ORDER BY descricaoSala";
			
			$result = mysql_query($sql);
			
			return $result;
		}
		
		/*
		 * Função: Listar salas disponíveis no banco de dados
		 * Obs: Implementação do método abstrato
		 * Retorno: Lista de salas disponíveis
		 */
		public static function pesquisarRecursoDisponivel($dataInicio, $dataFim)
		{
			$sql = "SELECT idRecurso, numeroSala, descricaoSala, localizacaoSala, capacidadeSala, tipoSala
						FROM recurso
						WHERE idRecurso NOT IN
							(SELECT DISTINCT idRecurso
									FROM itemReserva NATURAL JOIN reserva
									WHERE
										('".$dataInicio."' <= inicioEvento AND '".$dataFim."' >= inicioEvento) OR
										('".$dataInicio."' >= inicioEvento AND '".$dataInicio."' <= fimEvento))
							AND tipoRecurso = 'S'
						ORDER BY descricaoSala;";
			
			$result = mysql_query($sql);
			
			return $result;
		}
	}
	
	$salaBD = new SalaBD();
?>