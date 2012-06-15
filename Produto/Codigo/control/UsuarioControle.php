<?php
	include_once ("../model/UsuarioBD.php");
	include_once ("../model/FuncionarioInfraEstruturaBD.php");
	include_once ("../model/ProfessorBD.php");
	include_once ("../model/CoordenadorBD.php");
	
	/*
	 * Finalidade: Controlar as classes de usu�rio atrav�s das informa��es fornecidas pela interface
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 06/04/2012
	 */
	class UsuarioControle
	{
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de controle de usu�rio
		 */
		public function UsuarioControle()
		{		
			/* Vari�vel recebe a op��o de a��o passada pelo formul�rio atrav�s da variavel opcaoUsuario do tipo hidden */
			$opcaoUsuario = $_REQUEST['opcaoUsuario'];
			
			/* Define as a��es de acordo com a op��o */
			switch ($opcaoUsuario)
			{
				case 'IncluirUsuario': $this->incluirUsuario(); break;
				case 'AlterarUsuario':  $this->alterarUsuario(); break;
				case 'AlterarSenha':  $this->alterarSenhaUsuario(); break;
				case 'ExcluirUsuario':  $this->excluirUsuario(); break;
				case 'Logar':  $this->logar(); break;
				case 'Deslogar':  $this->deslogar(); break;
				case 'ListarUsuarios': $this->listarUsuarios(); break;
			}
		}
		
		/*
		 * Fun��o: Incluir usu�rio no sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function incluirUsuario()
		{
			$model = new UsuarioBD();
						
			$pessoa = explode(";", $_POST['cpfPessoa']);
			
			$model->definirLoginUsuario($_POST['loginUsuario']);
			$model->definirCpfPessoa($pessoa[0]);
			$model->definirPermissaoUsuario($pessoa[1]);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_usuarios.php\">";
			
			if ($model->incluirUsuario())
			{
				$senha = $model->obterSenhaUsuario();
				
				switch ($model->obterPermissaoUsuario())
				{
					case 'F': $result = FuncionarioInfraEstruturaBD::pesquisarPessoa($model->obterCpfPessoa()); break;
					case 'P': $result = ProfessorBD::pesquisarPessoa($model->obterCpfPessoa()); break;
					case 'C': $result = CoordenadorBD::pesquisarPessoa($model->obterCpfPessoa()); break;
				}
				
				$registro = mysql_fetch_array($result);
				$nome = $registro["nomePessoa"];
				$email = $registro["emailPessoa"];
				$assunto = "Contato SGRI";
				$mensagem = "Bom dia $nome, \n\nO SGRI criou uma senha para voc�: $senha \n\nUtilize esta senha para acessar o sistema agora mesmo";
				$extra = "Mensagem enviada automaticamente." . "X-Mailer: PHP/" . phpversion();
				
				if ($email <> "")
				{
					mail($email, $assunto, $mensagem, $extra);
					echo "<script language='JavaScript'> window.alert('Registro incluido com sucesso!\\nA senha foi enviada para o email cadastrado.') </script>";
				}
				else
					echo "<script language='JavaScript'> window.alert('Registro incluido com sucesso!\\nAnote a senha: $senha.') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro na inclusao do registro!') </script>";
		}
		
		/*
		 * Fun��o: Alterar usu�rio do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function alterarUsuario()
		{
			$model = new UsuarioBD();
					
			$pessoa = explode(";", $_POST['cpfPessoa']);
			
			$model->definirLoginUsuario($_POST['loginUsuario']);
			$model->definirCpfPessoa($pessoa[0]);
			$vetorDados = $this->buscarDados($_POST['loginUsuario']);
			$model->definirSenhaUsuario($vetorDados["senhaUsuario"]);
			$model->definirPermissaoUsuario($pessoa[1]);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_usuarios.php\">";
			
			if ($model->alterarUsuario())
				echo "<script language='JavaScript'> window.alert('Registro alterado com sucesso!') </script>";
			else
				echo "<script language='JavaScript'> window.alert('Erro na alteracao do registro!') </script>";
		}
		
		/*
		 * Fun��o: Alterar senha do usu�rio logado no sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function alterarSenhaUsuario()
		{
			$model = new UsuarioBD();
			
			$vetorDados = $this->buscarDados($_POST['loginUsuario']);
			$senha = $_POST['senhaAtual'];
			
			$model->definirLoginUsuario($vetorDados["loginUsuario"]);
			$model->definirCpfPessoa($vetorDados["cpfPessoa"]);
			$model->definirSenhaUsuario($_POST['senhaNova']);
			$model->definirPermissaoUsuario($vetorDados["permissaoUsuario"]);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/index.php\">";
			
			if ($vetorDados["senhaUsuario"] == $senha)
			{
				if ($model->alterarUsuario())
					echo "<script language='JavaScript'> window.alert('Senha alterada com sucesso!') </script>";
				else
					echo "<script language='JavaScript'> window.alert('Erro na alteracao da senha!') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro! Senha atual nao confere!!') </script>";
		}
		
		/*
		 * Fun��o: Excluir usu�rio do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function excluirUsuario()
		{
			$model = new UsuarioBD();
					
			$model->definirLoginUsuario($_GET['loginUsuario']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_usuarios.php\">";
			
			if ($model->excluirUsuario())
				echo "<script language='JavaScript'> window.alert('Registro excluido com sucesso!') </script>";
			else
				echo "<script language='JavaScript'> window.alert('Erro na exclusao do registro!') </script>";
		}
		
		/*
		 * Fun��o: Listar todos os usu�rios do sistema, possibilitando filtragem pelo nome do usu�rio
		 * Retorno: Lista com os usu�rios filtrados
		 */
		public function listarUsuarios()
		{
			//$result = UsuarioBD::pesquisarUsuario($_POST["loginUsuario"],$_POST["loginUsuario"]);
			$result = UsuarioBD::pesquisarUsuario($_GET['nomeUsuario'], $_GET['nomeUsuario']);
			
			if (mysql_num_rows($result) > 0)
			{
				while ($registro = mysql_fetch_array($result))
				{
					$loginUsuario = $registro["loginUsuario"];
					$nomePessoa = $registro["nomePessoa"];
					switch ($registro["permissaoUsuario"])
					{
						case 'C': $permissaoUsuario = "Coordenador"; break;
						case 'P': $permissaoUsuario = "Professor"; break;
						case 'F': $permissaoUsuario = "Funcionario Infra-Estrutura"; break;
					}
					
					if ($loginUsuario <> $_SESSION["usuario"])
					{
						echo "
							<div>
								<br class=\"clear\" />
								<hr />
								<br class=\"clear\" />
								<div style=\"float: right;\">
									<a class=\"botao\" href=\"cadastrar_usuario.php?loginUsuario=$loginUsuario\">
										<span>ALTERAR</span>
									</a>
									&nbsp;&nbsp;&nbsp;
									<a style=\"float: right;\" class=\"botao\" onclick=\"javascript:return confirma_exclusao()\" href=\"../control/UsuarioControle.php?opcaoUsuario=ExcluirUsuario&loginUsuario=$loginUsuario\">
										<span>EXCLUIR</span>
									</a>
								</div>
								<h1>$nomePessoa</h1>
								<span>$permissaoUsuario <br> Login: $loginUsuario</span>
							</div>
						";
					}
				}
			}
			else
			{
				echo "<h1>Nenhum resultado encontrado!</h1>";
			}
		}
		
		/*
		 * Fun��o: Buscar dados de um usu�rio espec�fico
		 * Par�metros
		 * $loginUsuario: Login do usu�rio desejado
		 * Retorno: Dados do usu�rio informado
		 */
		public function buscarDados($loginUsuario)
		{
			$result = UsuarioBD::pesquisarUsuario($loginUsuario, $loginUsuario);
			
			$vetor = mysql_fetch_array($result);
			
			return $vetor;
		}
		
		/*
		 * Fun��o: Validar usu�rio e criar uma sess�o para o sistema
		 * Retorno: Mensagem de erro ou sess�o nova criada
		 */
		public function logar()
		{
			$model = new UsuarioBD();
					
			$loginUsuario = $_POST["loginUsuario"];
			$senhaUsuario = $_POST["senhaUsuario"];
			
			$model->definirLoginUsuario($loginUsuario);
			$model->definirSenhaUsuario($senhaUsuario);
			
			if ($model->validarUsuario())
			{
				$vetorDados = $this->buscarDados($loginUsuario);
				
				session_start();
				
				$_SESSION["usuario"] = $loginUsuario;
				$_SESSION["nome"] = $vetorDados["nomePessoa"];
				$_SESSION["permissao"] = $vetorDados["permissaoUsuario"];
				
				$vetorDados = $this->buscarDados($loginUsuario);
				if ($loginUsuario == "admin")
				{
					$_SESSION["nome"] = "Administrador";
					$_SESSION["permissao"] = "S";
				}
				
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/index.php\">";
			}
			else
			{
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/login.php\">";
				echo "<script>alert(\"Usuario ou senha incorretos. Tente novamente!\");</script>";
			}
		}
		
		/*
		 * Fun��o: Destruir sess�o criada para o sistema
		 * Retorno: P�gina de Login
		 */
		public function deslogar()
		{
			session_start();
			if (isset($_SESSION["usuario"]))
				session_destroy();
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/login.php\">";
		}
	}
	
	$usuarioControle = new UsuarioControle();
?>