<?php
	/*
	 * Finalidade: Instanciar ocorr�ncias do sistema
	 * Autor: R�mulo de Oliveira Jorge
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
		 * Fun��o: Definir ID para inst�ncia da ocorr�ncia
		 * Par�metros
		 * $idOcorrencia: ID da ocorr�ncia
		 */
		public function definirIdOcorrencia($idOcorrencia)
		{
			$this->idOcorrencia = $idOcorrencia;
		}
		
		/*
		 * Fun��o: Obter ID da inst�ncia da ocorr�ncia
		 * Retorno: ID da ocorr�ncia
		 */
		public function obterIdOcorrencia()
		{
			return $this->idOcorrencia;
		}
		
		/*
		 * Fun��o: Definir descri��o para inst�ncia da ocorr�ncia
		 * Par�metros
		 * $descricaoOcorrencia: descri��o da ocorr�ncia
		 */
		public function definirDescricaoOcorrencia($descricaoOcorrencia)
		{
			$this->descricaoOcorrencia = $descricaoOcorrencia;
		}
		
		/*
		 * Fun��o: Obter descri��o da inst�ncia da ocorr�ncia
		 * Retorno: descri��o da ocorr�ncia
		 */
		public function obterDescricaoOcorrencia()
		{
			return $this->descricaoOcorrencia;
		}
		
		/*
		 * Fun��o: Definir data para inst�ncia da ocorr�ncia
		 * Par�metros
		 * $dataOcorrencia: data da ocorr�ncia
		 */
		public function definirDataOcorrencia($dataOcorrencia)
		{
			$this->dataOcorrencia = $dataOcorrencia;
		}
		
		/*
		 * Fun��o: Obter data da inst�ncia da ocorr�ncia
		 * Retorno: data da ocorr�ncia
		 */
		public function obterDataOcorrencia()
		{
			return $this->dataOcorrencia;
		}
		
		/*
		 * Fun��o: Definir login de usu�rio para inst�ncia da ocorr�ncia
		 * Par�metros
		 * $loginUsuario: login de usu�rio da ocorr�ncia
		 */
		public function definirLoginUsuario($loginUsuario)
		{
			$this->loginUsuario = $loginUsuario;
		}
		
		/*
		 * Fun��o: Obter login de usu�rio da inst�ncia da ocorr�ncia
		 * Retorno: login de usu�rio da ocorr�ncia
		 */
		public function obterLoginUsuario()
		{
			return $this->loginUsuario;
		}
	}
?>