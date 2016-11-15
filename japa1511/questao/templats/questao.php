<?php 
	// if(empty($acesso)) header("Location: ../../login.php");
?>
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
			<div id="msg">
				<p>
					<!-- Log de mensagens  -->
					<?php if(isset($msg))echo $msg; ?>
				</p>
			</div>

			<section id="form-content">
				<h3>Cadastro de quest&atilde;o</h3>

				<!-- Campo de pesquisa -->	
				<form id="frma" method="post">
					<?php 
						if(isset($_POST['btnPesquisar'])) {
							if (!empty($_POST['txtPesquisa'])) {
								echo "<input type='text' name='txtPesquisa' id='txtPesquisa' value='".$pesquisa."'>";
							} else {
								echo '<input type="text" name="txtPesquisa" id="txtPesquisa" placeholder="Pesquisar quest&atilde;o ...">';
							}
						}else{
							echo '<input type="text" name="txtPesquisa" id="txtPesquisa" placeholder="Pesquisar quest&atilde;o ...">';
						}
					?>
				
					<input type="submit" name="btnPesquisar" id="btnPesquisar" value="Pesquisar"/>
				</form>
				<form id="frma" action="" method="post">
					<input type="submit" id="btnNovo" name="btnNovo" value="Incluir"> 
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
							<td colspan="2"><strong>A&ccedil;&otilde;es</strong></td>
						</tr>
					</thead>
					<tbody>
						<?php 
							if (isset($questao)){
								foreach($questao as $campo => $value){
									echo "
										<tr>
											<td class='cmcodigo'>{$campo}</td>
											<td class='cmdescricao'>{$value['textoQuestao']}</td>
											<td class='cmdescricao'>{$value['descricao']}</td>
											<td class='cmdescricao'>{$value['codImagem']}</td>
											<td class='cmdescricao'>{$value['nome']}</td>
											<td class='cmdescricao'>{$value['ativo']}</td>
											<td class='cmdescricao'>{$value['dificult']}</td>
											<td><a href='?dcod={$campo}' class='adel'>Deletar</a></td>
											<td><a href='?ecod={$campo}' class='aedit'>Editar</a></td>
										</tr>" ;
								}
							}
						?>
					</tbody>
				</table>
				<!--- paginação -->
				<?php 

					echo " <ul> ";
						do {
							$i++;
							  echo " <li style='list-style: none;'>
        
							        <a href='?pg=$i-?pg=$i'> Voltar</a>

							          <a href='?pg=$i'> $i </a>
							       
							          <a href='?pg=$i+'> Avançar </a>

							          </li>";					
						} while($i < $numPagina);
						
					echo "</ul>";
				?>
			</div><!---content - Fim -->
		</div>
	</body>
</html>