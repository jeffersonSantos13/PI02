 <!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<meta html lang="pt-br">
		<meta charset='UTF-8'>
		<title>Estrutura - PI II</title>
	</head>
	
	<body>
		
		<?php // Cabeçalho
			include "../db/menuCruds.php";
		?>

		<div id="frmarea">
			<!-- Campo das mensagem -->
			<div id="msg">
				<p>
					<?php echo $msg; ?>
				</p>
			</div>

			<section id="form-content">
				<h3>Cadastro da área</h3>

				<!-- Campo de pesquisa -->	
				<form id="frma" action="" method="get">
					<!--- caso uma pesquisa seja feita, o botão de voltar será habilitado -->
					<?php 
						if(isset($_GET['pesq'])) {
							if (!empty($_GET['pesq'])) {
								echo "<input type='text' name='pesq' id='pesq' value='".$pesquisa."'>";
								echo $butt;
							}else{
								echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar descrição ...">';
							}
						}else{
							echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar descrição ...">';	
						}
					?>
					<input type="submit" id="btnPesquisar" value="Pesquisar"/>
				</form>
				<form id="frma" action="?sm"  method="post">
					<input type="submit" id="btnNovo" class="btnNovo" name="btnNovo" value="Incluir" /> 
				</form>
				
			<!--- campo de inclusão -->
			</section><!-- form-content - Fim -->
			<div id="area-content">
				<table>
					<thead>
						<tr>
							<td class="cmcodigo"><strong>Código</strong></td>
							<td class="cmdescricao"><strong>Área</strong></td>
							<td class="cmdescricao"><strong>Qtd. Assuntos</strong></td>
							<?php
								if($_SESSION['tipoProfessor'] == 'A'){
									echo'<td colspan="2"><strong>Ações</strong></td>';
								}
							?>
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
						if($num > 0){
							foreach($areas as $campo => $value){
								echo "
									<tr>
										<td class='cmcodigo'>{$campo}</td>
										<td class='cmdescricao1'>{$value['descricao']}</td>
										<td class='cmdescricao2'><a href='../assunto/?pesq={$value['descricao']}'>{$value['AssuntoArea']}</a></td>";
									if($_SESSION['tipoProfessor'] == 'A'){
									echo "
										<td><a href='?dcod={$campo}' class='adel'>Deletar</a></td>
										<td><a href='?ecod={$campo}' class='aedit' class='lightbox'>Editar</a></td>";
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
			</div> <!-- area-content - Fim -->
		</div><!-- frmarea - Fim -->

		<!-- scripts -->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>