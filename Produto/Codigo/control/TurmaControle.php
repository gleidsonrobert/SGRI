<?php
	include_once ("../model/TurmaBD.php");
	include_once ("../model/HorarioTurmaBD.php");
	
	/*
	 * Finalidade: Controlar as classes de turma e horário através das informações fornecidas pela interface
	 * Autor: Wander Maia da Silva e Túlio Henrique Café Carvalhais
	 * Data: 02/06/2012
	 */
	class TurmaControle
	{
		/*
		 * Construtora
		 * Função: Instanciar o objeto de controle de turma
		 */
		public function TurmaControle()
		{
			/* Variável recebe a opção de ação passada pelo formulário através da variavel opcaoTurma do tipo hidden */
			$opcaoTurma = $_REQUEST['opcaoTurma'];
			
			/* Define as ações de acordo com a opção */
			switch ($opcaoTurma)
			{
				case 'ImportarTurmas': $this->importarTurmas(); break;
			}
		}
		
		/*
		 * Função: Importar turmas para o sistema
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
		 * Função: Importar turma para o sistema
		 * Parâmetros
		 * $turma: instância da turma a importar
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
		 * Função: Importar horários de turma para o sistema
		 * Parâmetros
		 * $horario: instância do horário a importar
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