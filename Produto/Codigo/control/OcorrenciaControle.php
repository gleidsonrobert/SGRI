<?php
	include_once ("../model/OcorrenciaBD.php");
	
	/*
	 * Finalidade: Controlar as classes de ocorr�ncia atrav�s das informa��es fornecidas pela interface
	 * Autor: R�mulo de Oliveira Jorge
	 * Data: 01/06/2012
	 */
	class OcorrenciaControle
	{
		/*
		 * Construtora
		 * Fun��o: Instanciar o objeto de controle de ocorr�ncia
		 */
		public function OcorrenciaControle()
		{		
			/* Vari�vel recebe a op��o de a��o passada pelo formul�rio atrav�s da variavel opcaoOcorrencia do tipo hidden */
			$opcaoOcorrencia = $_REQUEST['opcaoOcorrencia'];
			
			/* Define as a��es de acordo com a op��o */
			switch ($opcaoOcorrencia)
			{
				case 'IncluirOcorrencia': $this->incluirOcorrencia(); break;
				case 'ExcluirOcorrencia':  $this->excluirOcorrencia(); break;
				case 'ListarOcorrencias': $this->listarOcorrencias(); break;
			}
		}
		
		/*
		 * Fun��o: Incluir ocorr�ncia no sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function incluirOcorrencia()
		{
			$model = new OcorrenciaBD();
			
			$model->definirDescricaoOcorrencia($_POST['descricaoOcorrencia']);
				$dataAux = explode("/", $_POST["dataOcorrencia"]);
			$dataOcorrencia = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
			$model->definirDataOcorrencia($dataOcorrencia);
			session_start();
			$model->definirLoginUsuario($_SESSION['usuario']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_ocorrencias.php\">";
			
			if ($model->incluirOcorrencia())
			{
				echo "<script language='JavaScript'> window.alert('Registro incluido com sucesso!') </script>";
			}
			else
				echo "<script language='JavaScript'> window.alert('Erro na inclusao do registro!') </script>";
		}
		
		/*
		 * Fun��o: Excluir ocorr�ncia do sistema
		 * Retorno: Mensagem de sucesso ou de erro
		 */
		public function excluirOcorrencia()
		{
			$model = new OcorrenciaBD();
			
			$model->definirIdOcorrencia($_GET['idOcorrencia']);
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=../view/gerenciar_ocorrencias.php\">";
			
			if ($model->excluirOcorrencia())
				echo "<script language='JavaScript'> window.alert('Registro excluido com sucesso!') </script>";
			else
				echo "<script language='JavaScript'> window.alert('Erro na exclusao do registro!') </script>";
		}
		
		/*
		 * Fun��o: Listar todas as ocorr�ncia do sistema, possibilitando filtragem
		 * Retorno: Lista com as ocorr�ncia filtradas
		 */
		public function listarOcorrencias()
		{
			if ($_GET["dataOcorrencia"] <> "")
			{
				$dataAux = explode("/", $_GET["dataOcorrencia"]);
				$data = $dataAux[2]."-".$dataAux[1]."-".$dataAux[0];
			}
			else
				$data = "";
			
			if ($_SESSION["permissao"] <> "S")
				$usuario = $_SESSION["usuario"];
			else
				$usuario = "";
			
			$result = OcorrenciaBD::pesquisarOcorrencia("", $_GET["descricaoOcorrencia"], $data, $usuario);
			
			if (mysql_num_rows($result) > 0)
			{
				while ($registro = mysql_fetch_array($result))
				{
					$idOcorrencia = $registro["idOcorrencia"];
					$descricaoOcorrencia = $registro["descricaoOcorrencia"];
						$dataAux = explode("-", $registro["dataOcorrencia"]);
					$dataOcorrencia = $dataAux[2]."/".$dataAux[1]."/".$dataAux[0];
					
					echo "
						<div>
							<br class=\"clear\" />
							<hr />
							<br class=\"clear\" />
							<div style=\"float: right;\">
								<a style=\"float: right;\" class=\"botao\" onclick=\"javascript:return confirma_exclusao()\" href=\"../control/OcorrenciaControle.php?opcaoOcorrencia=ExcluirOcorrencia&idOcorrencia=$idOcorrencia\">
									<span>EXCLUIR</span>
								</a>
							</div>
							<h1>[$dataOcorrencia]</h1>
							<span>
								$descricaoOcorrencia
							</span>
						</div>
					";
				}
			}
			else
			{
				echo "<h1>Nenhum resultado encontrado!</h1>";
			}
		}
	}
	
	$ocorrenciaControle = new OcorrenciaControle();
?>