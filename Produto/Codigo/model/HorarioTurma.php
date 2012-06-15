<?php
	/*
	 * Finalidade: Instanciar horários de turma do sistema
	 * Autor: Túlio Henrique Café Carvalhais
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
		 * Função: Definir ID para instância do horário
		 * Parâmetros
		 * $idHorario: ID do horário
		 */
		public function definirIdHorario($idHorario)
		{
			$this->idHorario = $idHorario;
		}
		
		/*
		 * Função: Obter ID da instância do horário
		 * Retorno: ID do horário
		 */
		public function obterIdHorario()
		{
			return $this->idHorario;
		}
		
		/*
		 * Função: Definir início para instância do horário
		 * Parâmetros
		 * $inicioHorario: início do horário
		 */
		public function definirInicioHorario($inicioHorario)
		{
			$this->inicioHorario = $inicioHorario;
		}
		
		/*
		 * Função: Obter início da instância do horário
		 * Retorno: início do horário
		 */
		public function obterInicioHorario()
		{
			return $this->inicioHorario;
		}
		
		/*
		 * Função: Definir fim para instância do horário
		 * Parâmetros
		 * $fimHorario: fim do horário
		 */
		public function definirFimHorario($fimHorario)
		{
			$this->fimHorario = $fimHorario;
		}
		
		/*
		 * Função: Obter fim da instância do horário
		 * Retorno: fim do horário
		 */
		public function obterFimHorario()
		{
			return $this->fimHorario;
		}
		
		/*
		 * Função: Definir dia para instância do horário
		 * Parâmetros
		 * $diaHorario: dia do horário
		 */
		public function definirDiaHorario($diaHorario)
		{
			$this->diaHorario = $diaHorario;
		}
		
		/*
		 * Função: Obter dia da instância do horário
		 * Retorno: dia do horário
		 */
		public function obterDiaHorario()
		{
			return $this->diaHorario;
		}
		
		/*
		 * Função: Definir ID de turma para instância do horário
		 * Parâmetros
		 * $idTurma: ID da turma
		 */
		public function definirIdTurma($idTurma)
		{
			$this->idTurma = $idTurma;
		}
		
		/*
		 * Função: Obter ID de turma da instância do horário
		 * Retorno: ID da turma
		 */
		public function obterIdTurma()
		{
			return $this->idTurma;
		}
	}
?>