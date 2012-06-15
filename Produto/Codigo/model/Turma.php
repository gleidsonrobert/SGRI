<?php
	/*
	 * Finalidade: Instanciar turmas do sistema
	 * Autor: Wander Maia da Silva
	 * Data: 29/05/2012
	 */
	class Turma
	{
		/* Propriedades */
		private $idTurma;
		private $disciplinaTurma;
		private $numeroSala;
		private $cpfPessoa;
		
		/*
		 * Funзгo: Definir ID para instвncia da turma
		 * Parвmetros
		 * $idTurma: ID da turma
		 */
		public function definirIdTurma($idTurma)
		{
			$this->idTurma = $idTurma;
		}
		
		/*
		 * Funзгo: Obter ID da instвncia da turma
		 * Retorno: ID da turma
		 */
		public function obterIdTurma()
		{
			return $this->idTurma;
		}
		
		/*
		 * Funзгo: Definir disciplina para instвncia da turma
		 * Parвmetros
		 * $disciplinaTurma: Disciplina da turma
		 */
		public function definirDisciplinaTurma($disciplinaTurma)
		{
			$this->disciplinaTurma = $disciplinaTurma;
		}
		
		/*
		 * Funзгo: Obter disciplina da instвncia da turma
		 * Retorno: Disciplina da turma
		 */
		public function obterDisciplinaTurma()
		{
			return $this->disciplinaTurma;
		}
		
		/*
		 * Funзгo: Definir nъmero da sala para instвncia da turma
		 * Parвmetros
		 * $numeroSala: Nъmero da sala da turma
		 */
		public function definirNumeroSala($numeroSala)
		{
			$this->numeroSala = $numeroSala;
		}
		
		/*
		 * Funзгo: Obter nъmero da sala para instвncia da turma
		 * Retorno: Nъmero da sala da turma
		 */
		public function obterNumeroSala()
		{
			return $this->numeroSala;
		}
		
		/*
		 * Funзгo: Definir CPF do professor referente а instвncia da turma
		 * Parвmetros
		 * $cpfPessoa: CPF do professor referente а turma
		 */
		public function definirCpfPessoa($cpfPessoa)
		{
			$this->cpfPessoa = $cpfPessoa;
		}
		
		/*
		 * Funзгo: Obter CPF do professor referente а instвncia da turma
		 * Retorno: CPF do professor referente а turma
		 */
		public function obterCpfPessoa()
		{
			return $this->cpfPessoa;
		}
	}
?>