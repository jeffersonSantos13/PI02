<head>
	<link rel="stylesheet" type="text/css" href="../../css/estilo.css">
</head>
<body>
	<div id="crudAssunto" style="margin-top:50px">
		<form id="frmaAssunto-crud" method="post" <?php echo "action='?ecod=".$result['codAssunto']."'"?>>
			<label class="label-default">Selecione a area do assunto:</label>
			<select name="codArea">
				<?php 
				foreach($areas as $codigo => $area){
					echo "<option value='$codigo'>$area</option>";							
				}
				?>
			</select>
			<label class="label-default">Descrição:</label>
			<input type="text" name="txtAssuntoUpdate"  class="style-input-default" <?php echo "value='".$result['descricao']."'"?>/>
			<input type="submit" name="btnAssuntoUpdate" class="btArea" value="Enviar" />
		</form>	
	</div>
</body>