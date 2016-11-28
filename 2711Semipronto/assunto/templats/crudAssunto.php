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

		<div id="frmaAssunto-crud">
			<div class='crud-cad'>
				<section id="form-content">
					<?php

						/* form de update ---------------------------------------------- */
						if(isset($_GET['ecod'])){
							echo "
								<h3>Editar Assunto</h3>
								<form id='frmaAssunto-crud' method='post' action='?ecod=".$result['codAssunto']."'>
									<label class='label-default'>Selecione a &aacute;rea do assunto:</label>
									<select id='slcCodArea' name='codArea'>";

										foreach($areas as $codigo => $area){
											if($result['codArea'] == $areas){
												echo "<option class='area' selected value='$codigo'>$area</option>";
											}else{
												echo "<option class='area' value='$codigo' >$area</option>";
											}

										}
							echo "
									</select>

									<label class='label-default'>Descri&ccedil;&atilde;o:</label>
									<input type='text' id='txtAssuntoDesc' name='txtAssuntoUpdate'  class='style-input-default' value='".$result['assdescricao']."' />

									<input type='submit' name='btnAssuntoUpdate' class='btArea' value='Enviar' />
									<a href='index.php'><input type='button' name='btnVolt' class='btArea' value='Cancelar'/></a>
								</form> ";

						} else {
						/* form de inserção ---------------------------------------------- */
							echo"
								<h3>Inserir Assunto </h3>
								<form id='frmaAssunto-crud' method='post'>
								<label class='label-default'>Selecione a &aacute;rea do assunto:</label>
								<select id='slcCodArea' name='codArea'>
									<option class='area' value='0'>Selecione o assunto</option>";
									foreach($areas as $codigo => $area){
										echo "<option class='area' value='$codigo'>$area</option>";
									}
							echo "
								</select>
								<label class='label-default'>Descri&ccedil;&atilde;o:</label>
								<input type='text' id='txtAssuntoDesc' name='txtInclude'  class='style-input-default' disabled />

								<input type='submit' name='btnInclude' class='btArea' value='Enviar' />
								<a href='index.php'><input type='button' name='btnVolt' class='btArea' value='Cancelar'/></a>
							</form>	"; }
						?>
				</section>
			</div>
		</div>
		<!--- scripts -->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>