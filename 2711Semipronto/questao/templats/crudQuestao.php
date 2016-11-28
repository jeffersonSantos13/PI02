<!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<link rel="stylesheet" type="text/css" href="../css/questao.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta html lang="pt-br">
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<title>Estrutura - PI II</title>
	</head>
	
	<body>
		
		<?php // Cabeçalho
			include "../db/menuCruds.php";
		?>

		<div id="frmquestao-crud">
			<div class='crud-questao'>
				<section id="form-content">
					<?php if(isset($msg))echo$msg;?>

					<?php
						/* FORM DE UPDATE ----------------------------------------------*/
						if (isset($_GET['ecod'])) {	?>

							<h3>Atualizar questão</h3>
							<form method="post"  action=<?php echo '?ecod='.$_GET['ecod'].''; ?> name="frmUpload" enctype="multipart/form-data">
								<div id='image'>
									<label class="label-default">Imagem</label>
									<p>Selecione a imagem...<input type="file" name="flArquivo" id="flArquivo" /></p>
									<output id="list">
										<?php
											echo "<img width='25%' height='25%' src='data:image/jpeg;base64,".base64_encode($result['bitmapImagem'])."' />"
										?>
									</output>
									<input type="checkbox" name="chkNoImg" value="Sem imagem" class="style-input-default" />
								</div>
								<br />
								<label class="label-default">&Aacute;rea</label>
								<select class="select-default" id='optarea'>
								<?php
									echo " <option value='". $arearesult. "'>". $arearesulta ."</option> " ;
									foreach ($area as $codigo => $value) {
										echo "<option value='$codigo' name='optArea'>".$value."</option>";
									}
								?>
								</select>

								<label class="label-default">Assunto</label>
								<select class="select-default" name="optAssunto" id='optAssunto'>
								<?php
									echo " <option value='". $result['codAssunto']. "'>".$result['descricao']."</option> " ;
									// foreach ($assunto as $codigo => $value) {
									//  	echo " <option value='$codigo'>".$value."</option> ";
									// }
								?>
								</select>

								<label class="label-default">Quest&atilde;o</label>
								<textarea name="edtQuestao"><?php echo $result['textoQuestao'] ?></textarea>

								<input type="radio" name="dificult" value="F" <?php if($result['dificuldade'] == 'F')echo "checked" ?> class="rdquestao" /><label class="label-default-questao">F&aacute;cil</label>
								<input type="radio" name="dificult" value="M" <?php if($result['dificuldade'] == 'M')echo "checked" ?> class="rdquestao" /><label class="label-default-questao">M&eacute;dio</label>
								<input type="radio" name="dificult" value="D" <?php if($result['dificuldade'] == 'D')echo "checked" ?> class="rdquestao" /><label class="label-default-questao">Dif&iacute;cíl</label>

								<?php
									$i = 1;
									foreach ($alteranativas as $campo => $value) {
										// Verifica qual alternativa está correta
										if ($value['correta'] == 1) $correta = 'checked'; else $correta = '';
										echo "
											<input type='text' name='txtAlt".$i."' value='{$value['textoAlternativa']}' class='style-input-default'/>
											<input type='radio' name='rdAlt' value='".$i."' $correta />
											";
										$i++;
									}
								?>

								<?php
									if(!isset($_GET['view'])){
								?>
									<input type="submit" name="btnUpdate" value="Atualizar" class="btArea">
									<a href="index.php"><input type="button" name="btnVolt" class="btArea" value="Cancelar"/></a>
								<?php
									}
								 ?>
							</form>
						<?php
						} else {
							?>
								<h3>Inserir questão</h3>
								<form method="post"  action="" name="frmUpload" enctype="multipart/form-data">
									<label class="label-default">Imagem</label>
									<input type="file" name="flArquivo" id="flArquivo" />
									<output id="list"></output>

									<label class="label-default">&Aacute;rea</label>
									<select class="select-default" name='optArea' id='optArea'>
									<?php
										echo " <option value='0'> Escolha uma área... </option> ";
										echo load_area();
									?>
									</select>

									<label class="label-default">Assunto</label>
									<select class="select-default" name="optAssunto" id='optAssunto'>
									<?php
										echo " <option value='0'> Escolha um assunto... </option> ";
									?>
									</select>

									<label class="label-default">Quest&atilde;o</label>
									<textarea name="edtQuestao"></textarea>

									<input type="radio" name="dificult" value="F" class="rdquestao"/><label class="label-default-questao">F&aacute;cil</label>
									<input type="radio" name="dificult" value="M" checked class="rdquestao" /><label class="label-default-questao">M&eacute;dio</label>
									<input type="radio" name="dificult" value="D" class="rdquestao" /><label class="label-default-questao">Dif&iacute;cil</label>

									<!-- Alternativas -->
									<input type="text" id="txtAlt1" name="txtAlt1" class="style-input-default"/>
									<input type="radio" name="rdAlt" value="1" checked />

									<input type="text" id="txtAlt2" name="txtAlt2" class="style-input-default"/></td>
									<input type="radio" name="rdAlt" value="2"/>

									<input type="text" id="txtAlt3" name="txtAlt3" class="style-input-default"/>
									<td><input type="radio" name="rdAlt" value="3"/></td>

									<input type="text" id="txtAlt4" name="txtAlt4" class="style-input-default"/>
									<td><input type="radio" name="rdAlt" value="4"/></td>

									<input type="submit" name="btnQuestao" class="btArea" value="Enviar">
									<a href="index.php"><input type="button" name="btnVolt" class="btArea" value="Cancelar"/></a>
								</form>
						<?php
							}
					 ?>
				</section><!-- form-content - Fim -->
			</div>
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