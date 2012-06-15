<?php
	/*
	 * Finalidade: Instanciar hor�rios de turma do sistema
	 * Autor: T�lio Henrique Caf� Carvalhais
	 * Data: 30/05/2012
	 */
	class HorarioTurma
	{
		/* Propriedades */
		private $idHorario;
		private $inicioHorario;
		private $fimHorario;
		private $diaHorario;
		private $idTurma;
		
		/*
		 * Fun��o: Definir ID para inst�ncia do hor�rio
		 * Par�metros
		 * $idHorario: ID do hor�rio
		 */
		public function definirIdHorario($idHorario)
		{
			$this->idHorario = $idHorario;
		}
		
		/*
		 * Fun��o: Obter ID da inst�ncia do hor�rio
		 * Retorno: ID do hor�rio
		 */
		public function obterIdHorario()
		{
			return $this->idHorario;
		}
		
		/*
		 * Fun��o: Definir in�cio para inst�ncia do hor�rio
		 * Par�metros
		 * $inicioHorario: in�cio do hor�rio
		 */
		public function definirInicioHorario($inicioHorario)
		{
			$this->inicioHorario = $inicioHorario;
		}
		
		/*
		 * Fun��o: Obter in�cio da inst�ncia do hor�rio
		 * Retorno: in�cio do hor�rio
		 */
		public function obterInicioHorario()
		{
			return $this->inicioHorario;
		}
		
		/*
		 * Fun��o: Definir fim para inst�ncia do hor�rio
		 * Par�metros
		 * $fimHorario: fim do hor�rio
		 */
		public function definirFimHorario($fimHorario)
		{
			$this->fimHorario = $fimHorario;
		}
		
		/*
		 * Fun��o: Obter fim da inst�ncia do hor�rio
		 * Retorno: fim do hor�rio
		 */
		public function obterFimHorario()
		{
			return $this->fimHorario;
		}
		
		/*
		 * Fun��o: Definir dia para inst�ncia do hor�rio
		 * Par�metros
		 * $diaHorario: dia do hor�rio
		 */
		public function definirDiaHorario($diaHorario)
		{
			$this->diaHorario = $diaHorario;
		}
		
		/*
		 * Fun��o: Obter dia da inst�ncia do hor�rio
		 * Retorno: dia do hor�rio
		 */
		public function obterDiaHorario()
		{
			return $this->diaHorario;
		}
		
		/*
		 * Fun��o: Definir ID de turma para inst�ncia do hor�rio
		 * Par�metros
		 * $idTurma: ID da turma
		 */
		public function definirIdTurma($idTurma)
		{
			$this->idTurma = $idTurma;
		}
		
		/*
		 * Fun��o: Obter ID de turma da inst�ncia do hor�rio
		 * Retorno: ID da turma
		 */
		public function obterIdTurma()
		{
			return $this->idTurma;
		}
	}
?>