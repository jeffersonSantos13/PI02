 <!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<meta html lang="pt-br">
		<meta charset='utf-8'>
		<title>Estrutura - PI II</title>
	</head>
	
	<body>
		
		<?php // Cabeçalho
			include "../menuCruds.php";
		?>

		<div id="frmarea">

			<!-- Campo das mensagem -->
			<div id="msg">
				<p>
					<!-- Corrigir depois	 -->
					<?php echo $msg; ?>
				</p>
			</div>

			<section id="form-content">
				<h3>Cadastro de questão</h3>

				<!-- Campo de pesquisa -->	
				<form id="frma" action=""  method="post">
							<!--- caso uma pesquisa seja feita, o botão de voltar será habilitado -->
					<?php 
						if(isset($_POST['btnPesquisar'])) {
							if (!empty($_POST['txtPesquisa'])) {
								echo "<input type='text' name='txtPesquisa' id='txtPesquisa' value='".$pesquisa."'>";
								//$butt recebe o botão btnVoltar, botão cujo papel é dar refresh na pagina
								// echo $butt;
							}
						}else{
							echo '<input type="text" name="txtPesquisa" id="txtPesquisa" placeholder="Pesquisar descriÃ§Ã£o ...">';
							
						}
					?>
				
					<input type="submit" name="btnPesquisar" id="btnPesquisar" value="Pesquisar"/>
					<input type="button" class="lightbox" id="btnNovo" class="btnNovo" name="btnNovo" value="Incluir" /> 
				</form>
				<!--- campo de inclusão -->
			</section><!-- form-content - Fim -->

			<div id="content">
				<table>
					<thead>
						<tr>
							<td class="cmcodigo"><strong>Codigo</strong></td>
							<td class="cmdescricao"><strong>Questao</strong></td>
							<td class="cmdescricao"><strong>Assunto</strong></td>
							<td class="cmdescricao"><strong>Imagem</strong></td>
							<td class="cmdescricao"><strong>Professor</strong></td>
							<td class="cmdescricao"><strong>Ativo</strong></td>
							<td class="cmdescricao"><strong>dificuldade</strong></td>
							<td colspan="2"><strong>Ações</strong></td>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach($questao as $campo => $value){
								echo "
									<tr>
										<td class='cmcodigo'>{$campo}</td>
										<td class='cmdescricao'>{$value['textoQuestao']}</td>
										<td class='cmdescricao'>{$value['descricao']}</td>
										<td class='cmdescricao'>{$value['codImagem']}</td>
										<td class='cmdescricao'>{$value['nome']}</td>
										<td class='cmdescricao'>{$value['ativo']}</td>
										<td class='cmdescricao'>{$value['dificuldade']}</td>
										<td><a href='?dcod={$campo}' class='adel'>Deletar</a></td>
										<td><a href='?ecod={$campo}' class='aedit'>Editar</a></td>
									</tr>" ;
							}
						?>
					</tbody>
				</table>
			</div><!---content - Fim -->


		</div>
	</body>
</html>