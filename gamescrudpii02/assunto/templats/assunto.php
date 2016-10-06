 <!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<meta html lang="pt-br">
		<meta charset='UTF-8'>
		<title>Estrutura - PI II</title>
	</head>
	
	<body>
		
		<?php // Cabeçalho
			include "../menu.php";
		?>

		<div id="frmarea">

			<!-- Campo das mensagem -->
			<div id="msg">
				<p>
					<!-- Corrigir depois	 -->
					<?php echo $msg; ?>
				</p>
			</div>

			<section id="form-content">
				<h3>Cadastro de assunto</h3>

				<!-- Campo de pesquisa -->	
				<form id="frma" action="" method="post">
					<input type="text" name="txtPesquisa" id="txtPesquisa" placeholder="Pesquisar descrição ...">
					<input type="submit" name="btnPesquisar" id="btnPesquisar" value="Pesquisar"/>

					<input type="submit" id="btnNovo" name="btnNovo" value="Incluir"> 
				</form>
			</section><!-- form-content - Fim -->

			<div id="area-content">
				<table>
					<thead>
						<tr>
							<td class="cmcodigo"><strong>Codigo</strong></td>
							<td class="cmdescricao"><strong>Descricao</strong></td>
							<td colspan="2"><strong>Ações</strong></td>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach($areas as $campo => $value){
								echo "
									<tr>
										<td class='cmcodigo'>{$campo}</td>
										<td class='cmdescricao'>{$value}</td>
										<td><a href='?dcod=$campo' class='adel'>Deletar</a></td>
										<td><a href='?ecod=$campo' class='aedit'>Editar</a></td>
									</tr>" ;
							}
						?>
					</tbody>
				</table>
			</div><!-- area-content - Fim -->
		</div><!-- frmarea - Fim -->
	</body>
</html>