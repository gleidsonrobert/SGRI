<?php
	include_once ("../model/TurmaBD.php");
	include_once ("../model/HorarioTurmaBD.php");
	
	/*
	 * Finalidade: Controlar as classes de turma e hor�rio atrav�s das informa��es fornecidas pela interface
	 * Autor: Wander Maia da Silva e T�lio Henrique Caf� Carvalhais
	 * Data: 02/06/2012
	 */
	class TurmaControle
	{
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de controle de turma
		 */
		public function TurmaControle()
		{
			/* Vari�vel recebe a op��o de a��o passada pelo formul�rio atrav�s da variavel opcaoTurma do tipo hidden */
			$opcaoTurma = $_REQUEST['opcaoTurma'];
			
			/* Define as a��es de acordo com a op��o */
			switch ($opcaoTurma)
			{
				case 'ImportarTurmas': $this->importarTurmas(); break;
			}
		}
		
		/*
		 * Fun��o: Importar turmas para o sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function importarTurmas()
		{
			if ($_FILES["arquivo"]["name"] <> "")
			{
				$arquivoTmp = $_FILES["arquivo"]["tmp_name"];
				$arquivo = "../".$_FILES["arquivo"]["name"];
				if(move_uploaded_file($arquivoTmp, $arquivo))
					rename($arquivo, "../XML_TURMAS.xml");
				
				$xml = simplexml_load_file("../XML_TURMAS.xml");
				
				$turmas = $xml->Turmas;
				
				$erro = 0;
				
				if (count($turmas) > 0)
				{
					$modelTurma = new TurmaBD();
					$modelTurma->excluirTurmas();
					
					$modelHorario = new HorarioTurmaBD();
					$modelHorario->excluirHorariosTurma();
					
					foreach($turmas->Turma as $turma)
						if (!$this->importarTurma($turma))
							$erro++;
					
					if ($erro == 0)
						echo "<script language='JavaScript'> window.alert('Arquivo importado com sucesso!') </script>";
					else
						echo "<script language='JavaScript'> window.alert('Erro na importacao do arquivo!') </script>";
				}
				else
					echo "<script language='JavaScript'> window.alert('Formato de arquivo invalido!') </script>";
				
				unlink("../XML_TURMAS.xml");
			}
			else
				echo "<script language='JavaScript'> window.alert('Nenhum arquivo selecionado!') </script>";
				
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/importar_turmas.php\">";
		}
		
		/*
		 * Fun��o: Importar turma para o sistema
		 * Par�metros
		 * $turma: inst�ncia da turma a importar
		 * Retorno: Verdadeiro ou falso
		 */
		private function importarTurma($turma)
		{
			$modelTurma = new TurmaBD();
			
			$modelTurma->definirDisciplinaTurma($turma->disciplinaTurma);
			$modelTurma->definirNumeroSala($turma->numeroSala);
			$modelTurma->definirCpfPessoa($turma->cpfProfessor);
			
			$idTurma = $modelTurma->incluirTurma();
			if ($idTurma == -1)
				return false;
			
			$horarios = $turma->Horarios;
			if (count($horarios) > 0)
			{
				foreach($horarios->Horario as $horario)
					$this->importarHorario($horario, $idTurma);
			}
			
			return true;
		}
		
		/*
		 * Fun��o: Importar hor�rios de turma para o sistema
		 * Par�metros
		 * $horario: inst�ncia do hor�rio a importar
		 * Retorno: Verdadeiro ou falso
		 */
		private function importarHorario($horario, $idTurma)
		{
			$modelHorario = new HorarioTurmaBD();
			
			$modelHorario->definirInicioHorario($horario->inicioHorario);
			$modelHorario->definirFimHorario($horario->fimHorario);
			$modelHorario->definirDiaHorario($horario->diaHorario);
			$modelHorario->definirIdTurma($idTurma);
			
			return $modelHorario->incluirHorarioTurma();
		}
	}
	
	$turmaControle = new TurmaControle();
?>