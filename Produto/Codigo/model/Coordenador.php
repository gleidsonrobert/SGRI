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
		 * Fun��o: Definir curso para inst�ncia do coordenador
		 * Par�metros
		 * $cursoCoordenador: curso do coordenador
		 */
		public function definirCursoCoordenador($cursoCoordenador)
		{
			$this->cursoCoordenador = $cursoCoordenador;
		}
		
		/*
		 * Fun��o: Obter curso da inst�ncia do coordenador
		 * Retorno: curso do coordenador
		 */
		public function obterCursoCoordenador()
		{
			return $this->cursoCoordenador;
		}
	}
?>