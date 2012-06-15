<?php
	include_once ("Professor.php");
	
	/*
	 * Finalidade: Instanciar coordenadores do sistema
	 * Autor: Wander Maia da Silva
	 * Data: 06/04/2012
	 */
	class Coordenador extends Professor
	{
		/* Propriedades */
		private $cursoCoordenador;
		
		/*
		 * Funчуo: Definir curso para instтncia do coordenador
		 * Parтmetros
		 * $cursoCoordenador: curso do coordenador
		 */
		public function definirCursoCoordenador($cursoCoordenador)
		{
			$this->cursoCoordenador = $cursoCoordenador;
		}
		
		/*
		 * Funчуo: Obter curso da instтncia do coordenador
		 * Retorno: curso do coordenador
		 */
		public function obterCursoCoordenador()
		{
			return $this->cursoCoordenador;
		}
	}
?>