<?php
	include_once ("Pessoa.php");
	
	/*
	 * Finalidade: Instanciar professores do sistema
	 * Autor: Tъlio Henrique Cafй Carvalhais
	 * Data: 06/04/2012
	 */
	class Professor extends Pessoa
	{
		/* Propriedades */
		protected $graduacaoProfessor;
		protected $mestradoProfessor;
		protected $doutoradoProfessor;
		
		/*
		 * Funзгo: Definir graduaзгo para instвncia do professor
		 * Parвmetros
		 * $graduacaoProfessor: graduaзгo do professor
		 */
		public function definirGraduacaoProfessor($graduacaoProfessor)
		{
			$this->graduacaoProfessor = $graduacaoProfessor;
		}
		
		/*
		 * Funзгo: Obter graduaзгo da instвncia do professor
		 * Retorno: graduaзгo do professor
		 */
		public function obterGraduacaoProfessor()
		{
			return $this->graduacaoProfessor;
		}
		
		/*
		 * Funзгo: Definir mestrado para instвncia do professor
		 * Parвmetros
		 * $mestradoProfessor: mestrado do professor
		 */
		 
		public function definirMestradoProfessor($mestradoProfessor)
		{
			$this->mestradoProfessor = $mestradoProfessor;
		}
		
		/*
		 * Funзгo: Obter mestrado da instвncia do professor
		 * Retorno: mestrado do professor
		 */
		public function obterMestradoProfessor()
		{
			return $this->mestradoProfessor;
		}
		
		/*
		 * Funзгo: Definir doutorado para instвncia do professor
		 * Parвmetros
		 * $doutoradoProfessor: doutorado do professor
		 */
		public function definirDoutoradoProfessor($doutoradoProfessor)
		{
			$this->doutoradoProfessor = $doutoradoProfessor;
		}
		
		/*
		 * Funзгo: Obter doutorado da instвncia do professor
		 * Retorno: doutorado do professor
		 */
		public function obterDoutoradoProfessor()
		{
			return $this->doutoradoProfessor;
		}
	}
?>