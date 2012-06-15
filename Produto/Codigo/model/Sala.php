<?php
	include_once ("Recurso.php");
	
	/*
	 * Finalidade: Instanciar salas do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 11/04/2012
	 */
	class Sala extends Recurso
	{
		/* Propriedades */
		private $numeroSala;
		private $descricaoSala;
		private $localizacaoSala;
		private $capacidadeSala;
		private $tipoSala;
		
		/*
		 * Fun��o: Definir n�mero para inst�ncia da sala
		 * Par�metros
		 * $numeroSala: n�mero da sala
		 */
		public function definirNumeroSala($numeroSala)
		{
			$this->numeroSala = $numeroSala;
		}
		
		/*
		 * Fun��o: Obter n�mero da inst�ncia da sala
		 * Retorno: n�mero da sala
		 */
		public function obterNumeroSala()
		{
			return $this->numeroSala;
		}
		
		/*
		 * Fun��o: Definir descri��o para inst�ncia da sala
		 * Par�metros
		 * $descricaoSala: descri��o da sala
		 */
		public function definirDescricaoSala($descricaoSala)
		{
			$this->descricaoSala = $descricaoSala;
		}
		
		/*
		 * Fun��o: Obter descri��o da inst�ncia da sala
		 * Retorno: descri��o da sala
		 */
		public function obterDescricaoSala()
		{
			return $this->descricaoSala;
		}
		
		/*
		 * Fun��o: Definir localiza��o para inst�ncia da sala
		 * Par�metros
		 * $localizacaoSala: localiza��o da sala
		 */
		public function definirLocalizacaoSala($localizacaoSala)
		{
			$this->localizacaoSala = $localizacaoSala;
		}
		
		/*
		 * Fun��o: Obter localiza��o da inst�ncia da sala
		 * Retorno: localiza��o da sala
		 */
		public function obterLocalizacaoSala()
		{
			return $this->localizacaoSala;
		}
		
		/*
		 * Fun��o: Definir capacidade para inst�ncia da sala
		 * Par�metros
		 * $capacidadeSala: capacidade da sala
		 */
		public function definirCapacidadeSala($capacidadeSala)
		{
			$this->capacidadeSala = $capacidadeSala;
		}
		
		/*
		 * Fun��o: Obter capacidade da inst�ncia da sala
		 * Retorno: capacidade da sala
		 */
		public function obterCapacidadeSala()
		{
			return $this->capacidadeSala;
		}
		
		/*
		 * Fun��o: Definir tipo para inst�ncia da sala
		 * Par�metros
		 * $tipoSala: tipo da sala
		 */
		public function definirTipoSala($tipoSala)
		{
			$this->tipoSala = $tipoSala;
		}
		
		/*
		 * Fun��o: Obter tipo da inst�ncia da sala
		 * Retorno: tipo da sala
		 */
		public function obterTipoSala()
		{
			return $this->tipoSala;
		}
	}
?>