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
		<div id="frmarea-crud">
			<section id="form-content">
				<?php if(isset($_GET['ecod'])){
				echo "
					<h3>Edição de areas</h3>	
					<form method='post' action='?ecod=".$result['codArea']."'>
						<label class='label-default'>Descrição</label>
						<input type='text' name='txtDescricao' class='style-input-default' value='".$result['descricao']."' />

						<input type='submit' name='btnAlterar' class='btArea' value='Enviar' />
						<a href='index.php'><input type='button' name='btnVolt' class='btArea' value='Cancelar'/></a>
					</form>	";
				}else{
					echo"
					<h3>Cadastro de areas</h3>	
					<form method='post'>
						<label class='label-default'>Descrição</label>
						<input type='text' name='txtInclude' class='style-input-default' placeholder='Digite a area' />

						<input type='submit' name='btnInclude' class='btArea' value='Enviar' />
						<a href='index.php'><input type='button' name='btnVolt' class='btArea' value='Voltar'/></a>
					</form>	";
				
				}?>
			</section>
		</div>
		<!---- scripts ---->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>