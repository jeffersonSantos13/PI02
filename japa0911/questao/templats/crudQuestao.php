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

			<section id="form-content">
				<!-- Mudar para passada de parametro  -->
				<h3>Cadastro de questão</h3>

				<form method="POST" action="" name="frmUpload" enctype="multipart/form-data">
					<label>Imagem<label>
					<p>Selecione a imagem<input type="file" name="flArquivo" id="flArquivo" /></p>
					<output id="list"></output>	

					<label>Área</label>	
					<select class="select-default">
						<?php 
							foreach ($area as $codigo => $value) {
								echo " <option value='$codigo' name='optArea'> $value </option> ";	
							}
						?>
					</select>	

					<label>Assunto</label>
					<select class="select-default" name='optAssunto'>
						<?php 
							foreach ($assunto as $codigo => $value) {
								echo " <option value='$codigo' > $value </option> ";	
							}						
						?>
					</select>	


					<label>Questão</label>	
					<textarea name='edtQuestao'>
					</textarea>

					<input type="radio" name="dificult" value="F" />Facil
					<input type="radio" name="dificult" value="M" checked />Medio
					<input type="radio" name="dificult" value="D" />Dificil

					<table>
						<thead>
							<tr>
								<td colspan="3">Alternativas</td>
								<td>Correta</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3"><input type="text" id="txtAlt1" name="txtAlt1" /></td>
								<td><input type="radio" name="rdAlt" value="1"/></td>
							</tr>
							<tr>
								<td colspan="3"><input type="text" id="txtAlt2" name="txtAlt2" /></td>
								<td><input type="radio" name="rdAlt" value="2"/></td>
							</tr>
							<tr>
								<td colspan="3"><input type="text" id="txtAlt3" name="txtAlt3" /></td>
								<td><input type="radio" name="rdAlt" value="3"/></td>
							</tr>
							<tr>
								<td colspan="3"> <input type="text" id="txtAlt4" name="txtAlt4" /></td>
								<td><input type="radio" name="rdAlt" value="4"/></td>
							</tr>
						</tbody>
					</table>

					<input type="button" value="+" name="acrescentar" />

					<input type="submit" value="Inserir" name="btnQuestao"> 

				</form>	
			</section><!-- form-content - Fim -->
			<script type="text/javascript" src='templats/loadimage.js'></script>
		</div>
	</body>
</html>