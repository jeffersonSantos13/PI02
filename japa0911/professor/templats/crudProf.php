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
			<section id="form-content">
				<?php if(isset($msg))echo$msg;?>
				<div id="crudProf">
					
						<?php 
						/* FORM DE UPDATE ----------------------------------------------*/
						if(isset($_GET['ecod'])){
							echo '
								<h3>Atualizar cadastro de professor</h3>
								<form id="frmProf-crud" method="post" action="?ecod='.$_GET["ecod"].'">
									<label class="label-default">Nome:</label>
									<input type="text" name="txtNomeProf" id="txtNomeProf"  class="style-input-default" required="required" value="'.$result['nome'].'" />
									
									<label class="label-default">Email:</label>
									<input type="email" name="txtEmailProf" id="txtEmailProf"  class="style-input-default" required="required" value="'.$result['email'].'" />
									
									<label class="label-default">ID:</label>
									<input type="text" name="txtIDProf" id="txtIDProf"  class="style-input-default" maxlength="6" required="required" value="'.$result['idSenac'].'" />
									
									<label class="label-default">Tipo:</label>';
									if($result['tipo'] == "P"){
										echo '
											<input type="radio" name="rdTipo" value="P"  class="style-input-default" checked />Professor
											<input type="radio" name="rdTipo" value="A"  class="style-input-default" />Admin';
									}else{
										echo '
											<input type="radio" name="rdTipo" value="P"  class="style-input-default" />Professor
											<input type="radio" name="rdTipo" value="A"  class="style-input-default" checked/>Admin';
									}
							echo ' <input type="submit" name="btnUpdate" class="btArea" value="Atualizar" />
									<a href="index.php"><input type="button" name="btnVolt" class="btArea" value="Voltar"/></a>
								</form>';
						}else{
						
						/* FORM DE INSERT ----------------------------------------------*/
							echo '
								<h3>Cadastro de professor</h3>
								<form id="frmProf-crud" method="post" >
									<label class="label-default">Nome:</label>
									<input type="text" name="txtNomeProf" id="txtNomeProf"  class="style-input-default" placeholder="Nome" required="required" value="'.@$nome.'" />
									
									<label class="label-default">Email:</label>
									<input type="email" name="txtEmailProf" id="txtEmailProf"  class="style-input-default" placeholder="email@email.com.br" required="required" value="'.@$email.'" />
									
									<label class="label-default">Senha:</label>
									<input type="password" name="txtSenhaProf" id="txtSenhaProf"  class="style-input-default" placeholder="*****" required="required" />
									
									<label class="label-default">Confirmar senha:</label>
									<input type="password" name="txtConfSenhaProf" id="txtConfSenhaProf"  class="style-input-default" placeholder="*****" required="required" />
									
									<label class="label-default">ID:</label>
									<input type="text" name="txtIDProf" id="txtIDProf"  class="style-input-default" placeholder="666666" maxlength="6" required="required" value="'.@$id.'" />
									
									<label class="label-default">Tipo:</label>
									<input type="radio" name="rdTipo" value="P"  class="style-input-default" checked />Professor
									<input type="radio" name="rdTipo" value="A"  class="style-input-default" />Admin
									<input type="submit" name="btnInclude" class="btArea" value="Enviar" />
									<a href="index.php"><input type="button" name="btnVolt" class="btArea" value="Voltar" /></a>
								</form>';
						}
					?>
				</div>
			</section>
		</div>
		<!---- scripts ---->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>