<?php
	/*
	 * Finalidade: Instanciar recursos do sistema
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 11/04/2012
	 */
	abstract class Recurso
	{
		/* Propriedades */
		protected $idRecurso;
		
		/*
		 * Fun��o: Definir ID para inst�ncia da recurso
		 * Par�metros
		 * $idRecurso: ID do recurso
		 */
		public function definirIdRecurso($idRecurso)
		{
			$this->idRecurso = $idRecurso;
		}
		
		/*
		 * Fun��o: Obter ID da inst�ncia da recurso
		 * Retorno: ID do recurso
		 */
		public function obterIdRecurso()
		{
			return $this->idRecurso;
		}
	}
?>