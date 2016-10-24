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
			// include "../../menuCruds.php";
		?>

		<div id="frmarea">

			<section id="form-content">
				<!-- Mudar para passada de parametro  -->
				<h3>Cadastro de questão</h3>

				<form method='POST' action="../index.php">
					<label>Imagem<label>

					<label>Área</label>	
					<select class="select-default">
						<?php 

							foreach ($area as $codigo => $value) {
								echo " <option value='$codigo'> $value </option> ";	
							}

						?>
					</select>	

					<label>Assunto</label>
					<select class="select-default">
						<?php 
							foreach ($assunto as $codigo => $value) {
								echo " <option value='$codigo' name='optAssunto'> $value </option> ";	
							}						
						?>
					</select>	


					<label>Questão</label>	
					<textarea name='edtQuestao'>

					</textarea>
					<input type="button" value="+" name="acrescentar" />
					<input type="button" value="-" name="decremento" />

				</form>	
			</section><!-- form-content - Fim -->
		</div>
	</body>
</html>