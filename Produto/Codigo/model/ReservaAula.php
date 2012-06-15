<?php
	include_once ("Reserva.php");
	
	/*
	 * Finalidade: Instanciar reservas de aula do sistema
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 13/05/2012
	 */
	class ReservaAula extends Reserva
	{
		/* Propriedades */
		private $dataAula;
		private $idHorario;
		
		/*
		 * Função: Definir data da aula para instância da reserva
		 * Parâmetros
		 * $dataAula: data da aula
		 */
		public function definirDataAula($dataAula)
		{
			$this->dataAula = $dataAula;
		}
		
		/*
		 * Função: Obter data da aula da instância da reserva
		 * Retorno: data da aula
		 */
		public function obterDataAula()
		{
			return $this->dataAula;
		}
		
		/*
		 * Função: Definir ID do horário para instância da reserva
		 * Parâmetros
		 * $idHorario: ID do horário
		 */
		public function definirIdHorario($idHorario)
		{
			$this->idHorario = $idHorario;
		}
		
		/*
		 * Função: Obter ID do horário da instância da reserva
		 * Retorno: ID do horário
		 */
		public function obterIdHorario()
		{
			return $this->idHorario;
		}
	}
?>