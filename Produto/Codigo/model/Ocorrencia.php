<?php
	/*
	 * Finalidade: Instanciar ocorrências do sistema
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 30/05/2012
	 */
	class Ocorrencia
	{
		/* Propriedades */
		private $idOcorrencia;
		private $descricaoOcorrencia;
		private $dataOcorrencia;
		private $loginUsuario;
		
		/*
		 * Função: Definir ID para instância da ocorrência
		 * Parâmetros
		 * $idOcorrencia: ID da ocorrência
		 */
		public function definirIdOcorrencia($idOcorrencia)
		{
			$this->idOcorrencia = $idOcorrencia;
		}
		
		/*
		 * Função: Obter ID da instância da ocorrência
		 * Retorno: ID da ocorrência
		 */
		public function obterIdOcorrencia()
		{
			return $this->idOcorrencia;
		}
		
		/*
		 * Função: Definir descrição para instância da ocorrência
		 * Parâmetros
		 * $descricaoOcorrencia: descrição da ocorrência
		 */
		public function definirDescricaoOcorrencia($descricaoOcorrencia)
		{
			$this->descricaoOcorrencia = $descricaoOcorrencia;
		}
		
		/*
		 * Função: Obter descrição da instância da ocorrência
		 * Retorno: descrição da ocorrência
		 */
		public function obterDescricaoOcorrencia()
		{
			return $this->descricaoOcorrencia;
		}
		
		/*
		 * Função: Definir data para instância da ocorrência
		 * Parâmetros
		 * $dataOcorrencia: data da ocorrência
		 */
		public function definirDataOcorrencia($dataOcorrencia)
		{
			$this->dataOcorrencia = $dataOcorrencia;
		}
		
		/*
		 * Função: Obter data da instância da ocorrência
		 * Retorno: data da ocorrência
		 */
		public function obterDataOcorrencia()
		{
			return $this->dataOcorrencia;
		}
		
		/*
		 * Função: Definir login de usuário para instância da ocorrência
		 * Parâmetros
		 * $loginUsuario: login de usuário da ocorrência
		 */
		public function definirLoginUsuario($loginUsuario)
		{
			$this->loginUsuario = $loginUsuario;
		}
		
		/*
		 * Função: Obter login de usuário da instância da ocorrência
		 * Retorno: login de usuário da ocorrência
		 */
		public function obterLoginUsuario()
		{
			return $this->loginUsuario;
		}
	}
?>