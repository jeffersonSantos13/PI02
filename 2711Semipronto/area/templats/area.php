 <!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<meta html lang="pt-br">
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
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
				<h3>Cadastro da &aacute;rea</h3>

				<!-- Campo de pesquisa -->	
				<form id="frma" action="" method="get">
					<!--- caso uma pesquisa seja feita, o botão de voltar será habilitado -->
					<?php 
						if(isset($_GET['pesq'])) {
							if (!empty($_GET['pesq'])) {
								echo "<input type='text' name='pesq' id='pesq' value='".$pesquisa."'>";
								echo $butt;
							}else{
								echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar &aacute;rea...">';
							}
						}else{
							echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar &aacute;rea...">';
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
							<td class="cmcodigo"><strong>C&oacute;digo</strong></td>
							<td class="cmdescricao"><strong>&Aacute;rea</strong></td>
							<td class="cmdescricao"><strong>Qtd. Assuntos</strong></td>
							<?php
								if($_SESSION['tipoProfessor'] == 'A'){
									echo'<td colspan="2"><strong>A&ccedil;&otilde;es</strong></td>';
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
						$zebra = 0;
						if($num > 0){
							foreach($areas as $campo => $value){
								if($zebra % 2 == 0) {
									$cor = '#BCE3F5';
								} else {
									$cor = '#fff';
								}
								echo "
									<tr>
										<td class='cmcodigo' style='background-color: $cor;'>{$campo}</td>
										<td class='cmdescricao1' style='background-color: $cor;' >{$value['descricao']}</td>
										<td class='cmdescricao2' style='background-color: $cor;'><a href='../assunto/?pesq={$value['descricao']}'>{$value['AssuntoArea']}</a></td>";
									if($_SESSION['tipoProfessor'] == 'A'){
									echo "
										<td style='background-color: $cor;' class='delet'><a href='?dcod={$campo}' class='adel'>Deletar</a></td>
										<td style='background-color: $cor;' class='edit' ><a href='?ecod={$campo}' class='aedit' class='lightbox'>Editar</a></td>";
									}
									echo "</tr>";
								$zebra++;
							}
						}else{
							echo " 	<tr>
										<td colspan='5'><center> Nenhum resultado encontrado :( </center></td>
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