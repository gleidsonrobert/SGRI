<?php
	/*
	 * Finalidade: Instanciar recursos do sistema
	 * Autor: Rєmulo de Oliveira Jorge
	 * Data: 11/04/2012
	 */
	abstract class Recurso
	{
		/* Propriedades */
		protected $idRecurso;
		
		/*
		 * Funчуo: Definir ID para instтncia da recurso
		 * Parтmetros
		 * $idRecurso: ID do recurso
		 */
		public function definirIdRecurso($idRecurso)
		{
			$this->idRecurso = $idRecurso;
		}
		
		/*
		 * Funчуo: Obter ID da instтncia da recurso
		 * Retorno: ID do recurso
		 */
		public function obterIdRecurso()
		{
			return $this->idRecurso;
		}
	}
?>