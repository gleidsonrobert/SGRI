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
		 * Fun��o: Definir ID para inst�ncia da turma
		 * Par�metros
		 * $idTurma: ID da turma
		 */
		public function definirIdTurma($idTurma)
		{
			$this->idTurma = $idTurma;
		}
		
		/*
		 * Fun��o: Obter ID da inst�ncia da turma
		 * Retorno: ID da turma
		 */
		public function obterIdTurma()
		{
			return $this->idTurma;
		}
		
		/*
		 * Fun��o: Definir disciplina para inst�ncia da turma
		 * Par�metros
		 * $disciplinaTurma: Disciplina da turma
		 */
		public function definirDisciplinaTurma($disciplinaTurma)
		{
			$this->disciplinaTurma = $disciplinaTurma;
		}
		
		/*
		 * Fun��o: Obter disciplina da inst�ncia da turma
		 * Retorno: Disciplina da turma
		 */
		public function obterDisciplinaTurma()
		{
			return $this->disciplinaTurma;
		}
		
		/*
		 * Fun��o: Definir n�mero da sala para inst�ncia da turma
		 * Par�metros
		 * $numeroSala: N�mero da sala da turma
		 */
		public function definirNumeroSala($numeroSala)
		{
			$this->numeroSala = $numeroSala;
		}
		
		/*
		 * Fun��o: Obter n�mero da sala para inst�ncia da turma
		 * Retorno: N�mero da sala da turma
		 */
		public function obterNumeroSala()
		{
			return $this->numeroSala;
		}
		
		/*
		 * Fun��o: Definir CPF do professor referente � inst�ncia da turma
		 * Par�metros
		 * $cpfPessoa: CPF do professor referente � turma
		 */
		public function definirCpfPessoa($cpfPessoa)
		{
			$this->cpfPessoa = $cpfPessoa;
		}
		
		/*
		 * Fun��o: Obter CPF do professor referente � inst�ncia da turma
		 * Retorno: CPF do professor referente � turma
		 */
		public function obterCpfPessoa()
		{
			return $this->cpfPessoa;
		}
	}
?>