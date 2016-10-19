<head>
	<link rel="stylesheet" type="text/css" href="../../css/estilo.css">
</head>
<body>
	<div id="crudArea">
		<form id="frmarea-crud" method="post" <?php echo "action='?ecod=".$result['codArea']."'"?> >
			<label class="label-default">Descrição</label>
			<input type="text" name="txtDescricao" class="style-input-default" <?php echo "value='".$result['descricao']."'"?> />

			<input type="submit" name='btnAlterar' class="btArea" value="Enviar" />
		</form>	
	</div>
</body>