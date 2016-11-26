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

			include "../db/menuCruds.php";

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
				<form id="frma" method="get">
					<?php 
						if(isset($_GET['pesq'])) {
							if (!empty($_GET['pesq'])) {
								echo "<input type='text' name='pesq' id='pesq' value='".$pesquisa."'>";
								//$butt recebe o botão btnVoltar, botão cujo papel é dar refresh na pagina
								echo $butt;
							}else{
								echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar descriÃ§Ã£o ...">';
							}
						}else{
							echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar descriÃ§Ã£o ...">';
							
						}
					?>				
					<input type="submit" id="btnPesquisar" value="Pesquisar"/>
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
							<td class="cmdescricao"><strong>dificuldade</strong></td>
							<td colspan="2"><strong>A&ccedil;&otilde;es</strong></td>
						</tr>
					</thead>
					<tfoot>
					<?php 
						//Inserir paginação
						include ("../db/paginacao.php");
					?>
					</tfoot>
					<tbody>
						<?php 
							if (isset($questao)){
								
									foreach($questao as $campo => $value){
										echo "
											<tr>
												<td class='cmcodigo'>{$campo}</td>
												<td class='cmdescricao'>{$value['textoQuestao']}</td>
												<td class='cmdescricao'>{$value['descricao']}</td>";
											if($value['bitmapImagem'] != 0 || !empty($value['bitmapImagem'])){
												echo "<td class='cmdescricao'><img width='100%' src='data:image/jpeg;base64,".base64_encode($value['bitmapImagem'])."' /></td>";
											}else{
												echo "<td class='cmdescricao'></td>";
											}
											echo"<td class='cmdescricao'>{$value['nome']}</td>
												 <td class='cmdescricao'>{$value['dificult']}</td>";
											if($_SESSION['codProfessor'] == $value['codProfessor'] || $_SESSION['tipoProfessor'] == 'A'){
												echo "
													<td><a href='?dcod={$campo}' class='adel'>Desativar</a></td>
													<td><a href='?ecod={$campo}' class='aedit'>Editar</a></td>";
											}else{
												echo "<td colspan='2'><center>VocÃª nÃ£o tem acesso</center></td>";
											}
											echo "</tr>";
									}
							}else{
								echo " 	<tr>
											
											<td colspan='5'><center> :( Nenhum resultado encontrado.</center></td>
										</tr>";
							}
							
						?>
					</tbody>
				</table>
			</div><!---content - Fim -->
		</div>
	</body>
</html>