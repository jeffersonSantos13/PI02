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
		
		<?php // CabeÁalho
			include "../menuCruds.php";
		?>
		<div id="frmarea">
			<section id="form-content">
					<h3>Cadastro de professores</h3>

					<!-- Campo de pesquisa -->	
					<form id="frma" action=""  method="post">
								<!--- caso uma pesquisa seja feita, o bot„o de voltar ser· habilitado -->
						<?php 
							if(isset($_POST['btnPesquisar'])) {
								if (!empty($_POST['txtPesquisa'])) {
									echo "<input type='text' name='txtPesquisa' id='txtPesquisa' value='".$pesquisa."'>";
									//$butt recebe o bot„o btnVoltar, bot„o cujo papel È dar refresh na pagina
									echo $butt;
								}
							}else{
								echo '<input type="text" name="txtPesquisa" id="txtPesquisa" placeholder="Pesquisar descri√ß√£o ...">';
								
							}
						?>
					
						<input type="submit" name="btnPesquisar" id="btnPesquisar" value="Pesquisar"/>
						<input type="button" class="lightbox" id="btnNovo" class="btnNovo" name="btnNovo" value="Incluir" /> 
					</form>
					<!--- campo de inclus„o -->
				</section><!-- form-content - Fim -->
				<!----------- COME«O DO LIGHTBOX -------------------->
				<div class="background"></div>
				<div class="box">
				<div><img src="../img/close.png" class="close" width="30" height="30"></div>
					<div id="crudArea">
						<h3>Cadastro de professores </h3>
						<form id="frmarea-crud" method="post">
							<label class="label-default">Descri√ß√£o</label>
							<input type="text" name="txtInclude"  class="style-input-default" />
							<input type="submit" name="btnInclude" class="btArea" value="Enviar" />
						</form>	
					</div>
				</div>
				<!---------------------------- FIM LIGHTBOX---------------->
				<div id="area-content">
					<table>
						<thead>
							<tr>
								<td class="cmcodigo"><strong>Codigo</strong></td>
								<td class="cmNome"><strong>Nome</strong></td>
								<td class="cmEmail"><strong>Email</strong></td>
								<td class="cmID"><strong>ID</strong></td>
								<td class="cmTipo"><strong>Tipo</strong></td>
								<td colspan="2"><strong>A√ß√µes</strong></td>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($prof as $campo => $value){
									echo "
										<tr>
											<td class='cmcodigo'>{$campo}</td>
											<td class='cmNome'>{$value['nome']}</td>
											<td class='cmEmail'>{$value['email']}</td>
											<td class='cmID'>{$value['idSenac']}</td>
											<td class='cmTipo'>{$value['tipo']}</td>
											<td><a href='?dcod={$campo}' class='adel'>Deletar</a></td>
											<td><a href='?ecod={$campo}' class='aedit'>Editar</a></td>
										</tr>" ;
								}
							?>
						</tbody>
					</table>
				</div><!-- area-content - Fim -->
		</div><!-- frmarea - Fim -->
		<!---- scripts ---->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>