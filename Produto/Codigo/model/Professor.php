<?php
	include_once ("Pessoa.php");
	
	/*
	 * Finalidade: Instanciar professores do sistema
	 * Autor: T�lio Henrique Caf� Carvalhais
	 * Data: 06/04/2012
	 */
	class Professor extends Pessoa
	{
		/* Propriedades */
		protected $graduacaoProfessor;
		protected $mestradoProfessor;
		protected $doutoradoProfessor;
		
		/*
		 * Fun��o: Definir gradua��o para inst�ncia do professor
		 * Par�metros
		 * $graduacaoProfessor: gradua��o do professor
		 */
		public function definirGraduacaoProfessor($graduacaoProfessor)
		{
			$this->graduacaoProfessor = $graduacaoProfessor;
		}
		
		/*
		 * Fun��o: Obter gradua��o da inst�ncia do professor
		 * Retorno: gradua��o do professor
		 */
		public function obterGraduacaoProfessor()
		{
			return $this->graduacaoProfessor;
		}
		
		/*
		 * Fun��o: Definir mestrado para inst�ncia do professor
		 * Par�metros
		 * $mestradoProfessor: mestrado do professor
		 */
		 
		public function definirMestradoProfessor($mestradoProfessor)
		{
			$this->mestradoProfessor = $mestradoProfessor;
		}
		
		/*
		 * Fun��o: Obter mestrado da inst�ncia do professor
		 * Retorno: mestrado do professor
		 */
		public function obterMestradoProfessor()
		{
			return $this->mestradoProfessor;
		}
		
		/*
		 * Fun��o: Definir doutorado para inst�ncia do professor
		 * Par�metros
		 * $doutoradoProfessor: doutorado do professor
		 */
		public function definirDoutoradoProfessor($doutoradoProfessor)
		{
			$this->doutoradoProfessor = $doutoradoProfessor;
		}
		
		/*
		 * Fun��o: Obter doutorado da inst�ncia do professor
		 * Retorno: doutorado do professor
		 */
		public function obterDoutoradoProfessor()
		{
			return $this->doutoradoProfessor;
		}
	}
?>