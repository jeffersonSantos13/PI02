<!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<link rel="stylesheet" type="text/css" href="../css/questao.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
				<?php if(isset($msg))echo$msg;?>

				<div id="crudQuestao">
				
				<?php 
					/* FORM DE UPDATE ----------------------------------------------*/
					if (isset($_GET['ecod'])) {	?>
							
						<h3>Atualizar questão</h3>
						<form method="post"  action=<?php echo '?ecod='.$_GET['ecod'].''; ?> name="frmUpload" enctype="multipart/form-data">
							<div id='image'>
								<label>Imagem</label>	
								<p>Selecione a imagem...<input type="file" name="flArquivo" id="flArquivo" /></p>
								<output id="list"></output>
							</div>
							<br />
							<label>Área</label>
							<select class="select-default" id='optarea'> 
							<?php 
								echo " <option value='". $arearesult. "'>". $arearesulta ."</option> " ;
								echo $resulta['descricao'];	
								foreach ($area as $codigo => $value) {
									echo "<option value='$codigo' name='optArea'>".$value."</option>"; 	
								}
							?>
							</select>	

							<label>Assunto</label>
							<select class="select-default" name="optAssunto" id='optassunto'>
							<?php
								echo " <option value='". $result['codAssunto']. "'>".utf8_encode($result['descricao'])."</option> " ;	
								foreach ($assunto as $codigo => $value) {
									echo " <option value='$codigo'>".$value."</option> ";	
								}
							?>						
							</select>	

							<label>Questão</label>	
							<textarea name="edtQuestao">
								<?php echo utf8_encode($result['textoQuestao']) ?>	
							</textarea>

							<input type="radio" name="dificult" value="F" <?php if($result['dificuldade'] == 'F')echo "checked" ?> />Facil
							<input type="radio" name="dificult" value="M" <?php if($result['dificuldade'] == 'M')echo "checked" ?> />Médio
							<input type="radio" name="dificult" value="D" <?php if($result['dificuldade'] == 'D')echo "checked" ?> />Dificíl

							<table id="alternativa">
								<thead>
									<tr>
										<td colspan="3">Alternativas</td>
										<td>Correta</td>
									</tr>
								</thead>
								<tbody>
								<?php 
									foreach ($alteranativas as $campo => $value) {	

										// Verifica qual alternativa está correta
										if ($value['correta'] == 1) $correta = 'checked'; else $correta = ''; 

										$i = 1;
										echo "
											<tr>
												<td colspan='3'><input type='text' name='txtAlt".$i."' value='{$value['textoAlternativa']}' /></td>
												<td><input type='radio' name='rdAlt' value='".$i."' $correta /></td>
											</tr>";
									}
								?>
								</tbody>
							</table>

							<input type="button" value="+" name="acrescentar" />

							<input type="submit" value="Atualizar" name="btnUpdate"> 
						</form>	
					<?php
				 	} else {
				 		?>
				 			<h3>Inserir questão</h3>
							<form method="post"  action="" name="frmUpload" enctype="multipart/form-data">
								<label>Imagem</label>
								<p>Selecione a imagem<input type="file" name="flArquivo" id="flArquivo" /></p>
								<output id="list"></output>	

								<label>Área</label>
								
								<select class="select-default" name='optArea' id='optArea'>
								<?php 
									echo " <option value='0'> Escolha uma área... </option> ";
									echo load_area();
								?>
								</select>	

								<label>Assunto</label>
								<select class="select-default" name="optAssunto" id='optAssunto'>
								<?php
									echo " <option value='0'> Escolha um assunto... </option> ";	
								?>						
								</select>	
								
								<label>Questão</label>	
								<textarea name="edtQuestao">
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
				 	<?php 
				 		}
				 ?>
				</div>
			</section><!-- form-content - Fim -->
			<script type="text/javascript" src='templats/loadimage.js'></script>
			<script type="text/javascript">
				 $(document).ready(function(){  
				      $('#optArea').change(function(){  
				           var area = $(this).val();  
				           $.ajax({  
				                url:"templats/processa.php",  
				                method:"POST",  
				                data:{codArea:area},  
				                dataType:"text",  
				                success:function(data)  
				                {  
				                     $('#optAssunto').html(data);  
				                }  
				           });  
				      });  
				 });  		
			</script>
		</div>
	</body>
</html>