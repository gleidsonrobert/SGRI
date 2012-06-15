<?php
	include_once ("Recurso.php");
	
	/*
	 * Finalidade: Instanciar salas do sistema
	 * Autor: Rфmulo de Oliveira Jorge
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
		 * Funзгo: Definir nъmero para instвncia da sala
		 * Parвmetros
		 * $numeroSala: nъmero da sala
		 */
		public function definirNumeroSala($numeroSala)
		{
			$this->numeroSala = $numeroSala;
		}
		
		/*
		 * Funзгo: Obter nъmero da instвncia da sala
		 * Retorno: nъmero da sala
		 */
		public function obterNumeroSala()
		{
			return $this->numeroSala;
		}
		
		/*
		 * Funзгo: Definir descriзгo para instвncia da sala
		 * Parвmetros
		 * $descricaoSala: descriзгo da sala
		 */
		public function definirDescricaoSala($descricaoSala)
		{
			$this->descricaoSala = $descricaoSala;
		}
		
		/*
		 * Funзгo: Obter descriзгo da instвncia da sala
		 * Retorno: descriзгo da sala
		 */
		public function obterDescricaoSala()
		{
			return $this->descricaoSala;
		}
		
		/*
		 * Funзгo: Definir localizaзгo para instвncia da sala
		 * Parвmetros
		 * $localizacaoSala: localizaзгo da sala
		 */
		public function definirLocalizacaoSala($localizacaoSala)
		{
			$this->localizacaoSala = $localizacaoSala;
		}
		
		/*
		 * Funзгo: Obter localizaзгo da instвncia da sala
		 * Retorno: localizaзгo da sala
		 */
		public function obterLocalizacaoSala()
		{
			return $this->localizacaoSala;
		}
		
		/*
		 * Funзгo: Definir capacidade para instвncia da sala
		 * Parвmetros
		 * $capacidadeSala: capacidade da sala
		 */
		public function definirCapacidadeSala($capacidadeSala)
		{
			$this->capacidadeSala = $capacidadeSala;
		}
		
		/*
		 * Funзгo: Obter capacidade da instвncia da sala
		 * Retorno: capacidade da sala
		 */
		public function obterCapacidadeSala()
		{
			return $this->capacidadeSala;
		}
		
		/*
		 * Funзгo: Definir tipo para instвncia da sala
		 * Parвmetros
		 * $tipoSala: tipo da sala
		 */
		public function definirTipoSala($tipoSala)
		{
			$this->tipoSala = $tipoSala;
		}
		
		/*
		 * Funзгo: Obter tipo da instвncia da sala
		 * Retorno: tipo da sala
		 */
		public function obterTipoSala()
		{
			return $this->tipoSala;
		}
	}
?>