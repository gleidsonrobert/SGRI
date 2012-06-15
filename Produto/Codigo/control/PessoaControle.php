<?php
	include_once ("../model/FuncionarioInfraEstruturaBD.php");
	include_once ("../model/ProfessorBD.php");
	include_once ("../model/CoordenadorBD.php");
	
	/*
	 * Finalidade: Controlar as classes de pessoa através das informações fornecidas pela interface
	 * Autor: Rômulo de Oliveira Jorge
	 * Data: 07/04/2012
	 */
	class PessoaControle
	{
		/*
		 * Construtora
		 * Função: Instanciar o objeto de controle de pessoa
		 */
		public function PessoaControle()
		{
			/* Variável recebe a opção de ação passada pelo formulário através da variavel opcaoPessoa do tipo hidden */
			$opcaoPessoa = $_REQUEST['opcaoPessoa'];
			
			/* Define as ações de acordo com a opção */
			switch ($opcaoPessoa)
			{
				case 'ImportarPessoas': $this->importarPessoas(); break;
			}
		}
		
		/*
		 * Função: Importar pessoas para o sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function importarPessoas()
		{
			if ($_FILES["arquivo"]["name"] <> "")
			{
				$arquivoTmp = $_FILES["arquivo"]["tmp_name"];
				$arquivo = "../".$_FILES["arquivo"]["name"];
				if(move_uploaded_file($arquivoTmp, $arquivo))
					rename($arquivo, "../XML_PESSOAS.xml");
				
				$xml = simplexml_load_file("../XML_PESSOAS.xml");
				
				$funcionarios = $xml->Funcionarios;
				$professores = $xml->Professores;
				$coordenadores = $xml->Coordenadores;
				
				$erro = 0;
				
				if (count($funcionarios) > 0 || count($professores) > 0 || count($coordenadores) > 0)
				{
					if (count($funcionarios) > 0)
					{
						foreach($funcionarios->Funcionario as $pessoa)
							if (!$this->importarFuncionarios($pessoa))
								$erro++;
					}
					
					if (count($professores) > 0)
					{
						foreach($professores->Professor as $pessoa)
							if (!$this->importarProfessores($pessoa))
								$erro++;
					}
					
					if (count($coordenadores) > 0)
					{
						foreach($coordenadores->Coordenador as $pessoa)
							if (!$this->importarCoordenadores($pessoa))
								$erro++;
					}
					
					if ($erro == 0)
						echo "<script language='JavaScript'> window.alert('Arquivo importado com sucesso!') </script>";
					else
						echo "<script language='JavaScript'> window.alert('Erro na importacao do arquivo!') </script>";
				}
				else
					echo "<script language='JavaScript'> window.alert('Formato de arquivo invalido!') </script>";
				
				unlink("../XML_PESSOAS.xml");
			}
			else
				echo "<script language='JavaScript'> window.alert('Nenhum arquivo selecionado!') </script>";
				
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/importar_pessoas.php\">";
		}
		
		/*
		 * Função: Importar funcionários de infra-estrutura para o sistema
		 * Parâmetros
		 * $pessoa: instância da pessoa a importar
		 * Retorno: Verdadeiro ou falso
		 */
		private function importarFuncionarios($pessoa)
		{
			$modelFuncionario = new FuncionarioInfraEstruturaBD();
			
			$modelFuncionario->definirCpfPessoa($pessoa->cpf);
			$modelFuncionario->definirNomePessoa($pessoa->nome);
			$modelFuncionario->definirNascimentoPessoa($pessoa->nascimento);
			$modelFuncionario->definirSexoPessoa($pessoa->sexo);
				$endereco = $pessoa->endereco;
			$modelFuncionario->definirEnderecoPessoa($endereco->rua." ".$endereco->numero." ".$endereco->cep."".$endereco->complemento);
			$modelFuncionario->definirCidadePessoa($pessoa->cidade);
			$modelFuncionario->definirUfPessoa($pessoa->uf);
			$modelFuncionario->definirTelefonePessoa($pessoa->telefone);
			$modelFuncionario->definirEmailPessoa($pessoa->email);
			$modelFuncionario->definirGraduacaoFuncionario($pessoa->graduacao);
			$modelFuncionario->definirFuncaoFuncionario($pessoa->funcao);
			
			if ($modelFuncionario->existePessoa())
				return $modelFuncionario->alterarPessoa();
			else 
				return $modelFuncionario->incluirPessoa();
		}
		
		/*
		 * Função: Importar professores para o sistema
		 * Parâmetros
		 * $pessoa: instância da pessoa a importar
		 * Retorno: Verdadeiro ou falso
		 */
		private function importarProfessores($pessoa)
		{
			$modelProfessor = new ProfessorBD();
			
			$modelProfessor->definirCpfPessoa($pessoa->cpf);
			$modelProfessor->definirNomePessoa($pessoa->nome);
			$modelProfessor->definirNascimentoPessoa($pessoa->nascimento);
			$modelProfessor->definirSexoPessoa($pessoa->sexo);
			
			$endereco = $pessoa->endereco;
			$modelProfessor->definirEnderecoPessoa($endereco->rua." ".$endereco->numero." ".$endereco->cep."".$endereco->complemento);
			
			$modelProfessor->definirCidadePessoa($pessoa->cidade);
			$modelProfessor->definirUfPessoa($pessoa->uf);
			$modelProfessor->definirTelefonePessoa($pessoa->telefone);
			$modelProfessor->definirEmailPessoa($pessoa->email);
			
			$escolaridade = $pessoa->escolaridade;
			$modelProfessor->definirGraduacaoProfessor($escolaridade->graduacao);
			$modelProfessor->definirMestradoProfessor($escolaridade->mestrado);
			$modelProfessor->definirDoutoradoProfessor($escolaridade->doutorado);
				
			if ($modelProfessor->existePessoa())
				return $modelProfessor->alterarPessoa();
			else 
				return $modelProfessor->incluirPessoa();
		}
		
		/*
		 * Função: Importar coordenador para o sistema
		 * Parâmetros
		 * $pessoa: instância da pessoa a importar
		 * Retorno: Verdadeiro ou falso
		 */
		private function importarCoordenadores($pessoa)
		{
			$modelCoordenador = new CoordenadorBD();
			
			$modelCoordenador->definirCpfPessoa($pessoa->cpf);
			$modelCoordenador->definirNomePessoa($pessoa->nome);
			$modelCoordenador->definirNascimentoPessoa($pessoa->nascimento);
			$modelCoordenador->definirSexoPessoa($pessoa->sexo);
			
			$endereco = $pessoa->endereco;
			$modelCoordenador->definirEnderecoPessoa($endereco->rua." ".$endereco->numero." ".$endereco->cep."".$endereco->complemento);
			
			$modelCoordenador->definirCidadePessoa($pessoa->cidade);
			$modelCoordenador->definirUfPessoa($pessoa->uf);
			$modelCoordenador->definirTelefonePessoa($pessoa->telefone);
			$modelCoordenador->definirEmailPessoa($pessoa->email);
			
			$escolaridade = $pessoa->escolaridade;
			$modelCoordenador->definirGraduacaoProfessor($escolaridade->graduacao);
			$modelCoordenador->definirMestradoProfessor($escolaridade->mestrado);
			$modelCoordenador->definirDoutoradoProfessor($escolaridade->doutorado);
			
			$modelCoordenador->definirCursoCoordenador($pessoa->curso);
			
			if ($modelCoordenador->existePessoa())
				return $modelCoordenador->alterarPessoa();
			else 
				return $modelCoordenador->incluirPessoa();
		}
		
		/*
		 * Função: Listar todos as pessoas do sistema
		 * Retorno: Lista com as pessoas
		 */
		public function listarPessoas()
		{
			$result = FuncionarioInfraEstruturaBD::pesquisarPessoa("");
			
			if (mysql_num_rows($result) > 0)
			{
				echo "
					<option disabled=\"disabled\" style=\"font-weight: bold\"> ------------------- Funcionarios ------------------ </option>
				";
				
				while ($registro = mysql_fetch_array($result))
				{
					$cpfPessoa = $registro["cpfPessoa"];
					$nomePessoa = $registro["nomePessoa"];
					$tipoPessoa = $registro["tipoPessoa"];
					echo "
						<option value=\"$cpfPessoa;$tipoPessoa\">$nomePessoa</option>
					";
				}
			}
			
			$result = ProfessorBD::pesquisarPessoa("");
			
			if (mysql_num_rows($result) > 0)
			{
				echo "
					<option disabled=\"disabled\" style=\"font-weight: bold\"> ------------------- Professores ------------------- </option>
				";
				
				while ($registro = mysql_fetch_array($result))
				{
					$cpfPessoa = $registro["cpfPessoa"];
					$nomePessoa = $registro["nomePessoa"];
					$tipoPessoa = $registro["tipoPessoa"];
					echo "
						<option value=\"$cpfPessoa;$tipoPessoa\">$nomePessoa</option>
					";
				}
			}
			
			$result = CoordenadorBD::pesquisarPessoa("");
			
			if (mysql_num_rows($result) > 0)
			{
				echo "
					<option disabled=\"disabled\" style=\"font-weight: bold\"> ----------------- Coordenadores ----------------- </option>
				";
				
				while ($registro = mysql_fetch_array($result))
				{
					$cpfPessoa = $registro["cpfPessoa"];
					$nomePessoa = $registro["nomePessoa"];
					$tipoPessoa = $registro["tipoPessoa"];
					echo "
						<option value=\"$cpfPessoa;$tipoPessoa\">$nomePessoa</option>
					";
				}
			}
		}
	}
	
	$pessoaControle = new PessoaControle();
?>