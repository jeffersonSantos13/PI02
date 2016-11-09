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
		<div id="crudAssunto">
			<section id="form-content">
				<div id='crudAssunto'>
			<?php
				
				/* form de update ---------------------------------------------- */
				if(isset($_GET['ecod'])){
					echo "
						<h3>Editar Assunto </h3>
						<form id='frmaAssunto-crud' method='post' action='?ecod=".$result['codAssunto']."'>
							<label class='label-default'>Selecione a area do assunto:</label>
							<select id='slcCodArea' name='codArea'>";
							
								foreach($areas as $codigo => $area){
									if($result['codArea'] == $areas){
										echo "<option selected='selected' value='$codigo'>$area</option>";	
									}else{
										echo "<option value='$codigo' >$area</option>";	
									}
									
								}
					echo "		
							</select>
							<label class='label-default'>Descrição:</label>
							<input type='text' name='txtAssuntoUpdate'  class='style-input-default' value='".$result['assdescricao']."'/>
							
							<input type='submit' name='btnAssuntoUpdate' class='btArea' value='Enviar' />
							<a href='index.php'><input type='button' name='btnVolt' class='btArea' value='Cancelar'/></a>
						</form>";	
						
				}else{
				/* form de inserção ---------------------------------------------- */
					echo"
						<h3>Inserir Assunto </h3>
						<form id='frmaAssunto-crud' method='post'>
						<label class='label-default'>Selecione a area do assunto:</label>
						<select id='slcCodArea' name='codArea'>
							<option class='area' value='0'>Selecione o assunto</option>";
							foreach($areas as $codigo => $area){
								echo "<option class='area' value='$codigo'>$area</option>";							
							}
					echo "
						</select>
						<label class='label-default'>Descrição:</label>
						<input type='text' id='txtAssuntoDesc' name='txtInclude'  class='style-input-default' disabled />
						<input type='submit' name='btnInclude' class='btArea' value='Enviar' />
						<a href='index.php'><input type='button' name='btnVolt' class='btArea' value='Voltar'/></a>
					</form>	"; }?>
				</div>
				

		</div>
		<!--------- scripts------------------>
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>