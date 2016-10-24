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
				<h3>Cadastro de assunto</h3>

				<!-- Campo de pesquisa -->	
				<form id="frma" action="" method="post">
					<!--- caso uma pesquisa seja feita, o botão de voltar será habilitado -->
					<?php 
						if(isset($_POST['btnPesquisar'])) {
							if (!empty($_POST['txtPesquisa'])) {
								echo "<input type='text' name='txtPesquisa' id='txtPesquisa' value='".$pesquisa."'>";
								//$butt recebe o botão btnVoltar, botão cujo papel é dar refresh na pagina
								echo $butt;
							}
						}else{
							echo '<input type="text" name="txtPesquisa" id="txtPesquisa" placeholder="Pesquisar descrição ...">';
							
						}
					?>
					<input type="submit" name="btnPesquisar" id="btnPesquisar" value="Pesquisar"/>
					<input type="button" class="lightbox" id="btnNovo" name="btnNovo" value="Incluir"> 
				</form>
			</section><!-- form-content - Fim -->
			<!----- COMEÇO DO LIGHTBOX ------------------->
			<div class="background"></div>
			<div class="box">
			<div><img src="../img/close.png" class="close" width="30" height="30"></div>
				<div id="crudAssunto">
					<h3>Inserir Assunto </h3>
					<form id="frmaAssunto-crud" method="post">
						<label class="label-default">Selecione a area do assunto:</label>
						<select id="slcCodArea" name="codArea">
							<option class="area" value="0">Selecione o assunto</option>
							<?php 
							
							foreach($areas as $codigo => $area){
								echo "<option class='area' value='$codigo'>$area</option>";							
							}
							?>
						</select>
						<label class="label-default">Descrição:</label>
						<input type="text" id="txtAssuntoDesc" name="txtInclude"  class="style-input-default" disabled />
						<input type="submit" name="btnInclude" class="btArea" value="Enviar" />
					</form>	
				</div>
			</div>
			<!---------------------------- FIM LIGHTBOX---------------->
			<div id="area-content">
				<table>
					<thead>
						<tr>
							<td class="cmcodigo"><strong>Codigo</strong></td>
							<td class="cmdescricao"><strong>Assunto</strong></td>
							<td class="cmdescricao"><strong>Area</strong></td>
							<td colspan="2"><strong>Ações</strong></td>
						</tr>
					</thead>
					<tbody>
						<?php 
								foreach($assuntos as $campo => $valor){
								echo "
									<tr>
										<td class='cmcodigo'>{$campo}</td>
										<td class='cmdescricao1'>".$valor['assdescricao']."</td>
										<td class='cmdescricao2'>".$valor['ardescricao']."</td>
										<td><a href='?dcod={$campo}' class='adel'>Deletar</a></td>
										<td><a href='?ecod={$campo}' class='aedit'>Editar</a></td>
									</tr>";
							}
						?>
					</tbody>
				</table>
			</div><!-- area-content - Fim -->
		</div><!-- frmarea - Fim -->
		<!------------ script ---->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>