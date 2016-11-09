<?php
	// Crud Questão

	require('../acesso.php');
	require('../db/db.php');

	$msg = '';
	$result = '';

	// ----------------------------------------------------------------------PAGINA ----------------------------------------------------------------------------
	$querypag = odbc_exec($db, "SELECT 
								codQuestao	
							FROM
								Questao");
	$num = odbc_num_rows($querypag);
	$numPagina = ceil($num/10);
	$i = 0;
	if(!isset($_GET['pg']))$pagina = 1;else $pagina = intval($_GET['pg']);
	$limite = (10 * $pagina); 

	// Query Questão 
	$queryQuestao = "SELECT 
					qs.codQuestao,
					qs.textoQuestao,
					qs.codAssunto,
					qs.codProfessor,
					qs.codImagem,
					qs.ativo,
					CASE 
						WHEN qs.dificuldade = 'F' THEN 'Fácil'
						WHEN qs.dificuldade = 'M' THEN 'Médio' 
						WHEN qs.dificuldade = 'D' THEN 'Díficil' 
					END AS dificuldade,
					ass.descricao,
					pro.nome
				 FROM Questao AS qs
				 LEFT JOIN Assunto as ass on ass.codAssunto = qs.codAssunto
				 LEFT JOIN Professor as pro on pro.codProfessor = qs.codProfessor";

	$orderpag = " ORDER BY 
				 	qs.codQuestao 
				 	OFFSET $limite-10 ROWS  
					FETCH NEXT 10 ROWS ONLY	";			 

	// Query Imagem			
	$queryImagem = "SELECT 
						codImagem,
						tituloImagem,
						bitmapImagem
					FROM
						Imagem ";		

	// Query Alternativa
	$queryAlternativa = "SELECT
							codQuestao,
							codAlternativa,
							textoAlternativa,
							correta
						FROM
							Alternativa";	
				
	// --------------------------------------------------------------------Pesquisa --------------------------------------------------------------------
	if(isset($_POST['btnPesquisar'])) {
		if (!empty($_POST['txtPesquisa'])) {
				$pesquisa = $_POST['txtPesquisa'];
					
				$query = odbc_exec($db, $queryQuestao . " WHERE qs.textoQuestao LIKE '%$pesquisa%'" . $orderpag);
				// $butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
		} else {
			// Bugando nessa linha de código 
			$query = odbc_exec($db, $queryQuestao . $orderpag);
		}
	} else {
		// Valor default
		$query = odbc_exec($db, $queryQuestao . $orderpag);
	}

	while ($result = odbc_fetch_array($query)) {
		$questao[$result['codQuestao']]['textoQuestao'] = utf8_encode($result['textoQuestao']);	
		$questao[$result['codQuestao']]['descricao'] = utf8_encode($result['descricao']);
		$questao[$result['codQuestao']]['nome'] = utf8_encode($result['nome']);
		$questao[$result['codQuestao']]['codImagem'] = utf8_encode($result['codImagem']);
		$questao[$result['codQuestao']]['ativo'] = utf8_encode($result['ativo']);
		$questao[$result['codQuestao']]['dificuldade'] = utf8_encode($result['dificuldade']);
	}

	//--------------------------------------------------------------------DELETE--------------------------------------------------------------------
	if (isset($_GET['dcod'])) {
		if (is_numeric($_GET['dcod'])) {
			// Verifica se existe dependências em outros bancos
			$queryAlternativa = odbc_exec($db, $queryAlternativa . " WHERE codQuestao = " . $_GET['dcod']);
			$queryImagem = odbc_exec($db, $queryImagem . " WHERE codImagem = " . $_GET['dcod']);
			if(odbc_num_rows($queryAlternativa) > 0) {
				$msg .= "Não foi possível deletar.";	
			}
			else if (odbc_num_rows($queryImagem) > 0) {
				$msg .= "Não foi possível deletar.";
			} else {

				if (!odbc_exec($db, "DELETE FROM questao WHERE codQuestao = ".$_GET['dcod'])) {
					$msg = 'Não foi possível deletar o registro N°' . $_GET['dcod'];  
				} else {
					header("Location: index.php");
				}
			}
		} else {
			$msg .= "ERRO : ID não valido";
		}
	}

	//--------------------------------------------------------------------INSERT--------------------------------------------------------------------

	if (isset($_POST['btnNovo'])) {
		
		$areaq = odbc_exec($db, "SELECT codArea, descricao FROM Area");

		while ($result = odbc_fetch_array($areaq)) {
			$area[$result['codArea']] = utf8_encode($result['descricao']);
		}	
							
		$assuntoq = odbc_exec($db, "SELECT codAssunto, codArea, descricao FROM Assunto");

		while ($result = odbc_fetch_array($assuntoq)) {
			$assunto[$result['codAssunto']] = utf8_encode($result['descricao']);
		}	
	}

	// INSERT	
	if (isset($_POST['btnQuestao'])) {

		$texto = $_POST['edtQuestao'];
		$assunto = intval($_POST['optAssunto']);
		$dificult = $_POST['dificult'];


		// Inclusão da imagem 
		include('loadimage.php');

		$questao = odbc_prepare($db, "INSERT INTO Questao 
										(textoQuestao, codAssunto, codTipoQuestao, codImagem, codProfessor, ativo, dificuldade)
										output inserted.codQuestao
									 VALUES
									  	(?,?,?,?,?,?,?) ");

		if($query = odbc_execute($questao, array($texto, $assunto, 'A', $inserirImage, 1, 1, $dificult))){		
			$msg = "Não foi possivel inserir";
		} 

		$codQuestao = odbc_fetch_array($questao);
		$inserirQuestao = $codQuestao['codQuestao'];

		$ntem = true;
		$i = 1;

		do {
			
			if(@$alternativa = $_POST['txtAlt'.$i]){

				$alterativainsert = odbc_prepare($db, "INSERT INTO Alternativa 
									 	(codQuestao, codAlternativa, textoAlternativa, correta)	
									 VALUES
		 							  	($inserirQuestao, ?, ?, ?)");

				if ($_POST['rdAlt'] == $i) $correta = 1; else $correta = 0; 
				
		 		if (!$query = odbc_execute($alterativainsert, array($i, $alternativa, $correta))) {
		 			$msg = "Não foi possivel inserir a alternativa";
		 		} else {
		 			$i++;
		 		}

			} else{
				$ntem = false;
			}

		} while($ntem);
	
	}

	// Updade
	if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){
	
		$select = odbc_exec($db, $queryQuestao.' WHERE qs.codQuestao = ' .$_GET['ecod']);
		
		$result = odbc_fetch_array($select);

	} else {
		$result = 'ERRO: ID inválido';
	}

	// --------------------------------------------------------------------------UPDATE-------------------------------------------------------------------
	// if(isset($_POST['btnAssuntoUpdate']  )){
	// 	if(is_numeric($_GET['ecod'])){
	// 		$assunto = $_POST['txtAssuntoUpdate'];
	// 		$assunto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtAssuntoUpdate']);
	// 		$codArea = intval($_POST['codArea']);
			
	// 		$prepare = odbc_prepare($db, "UPDATE
	// 										Assunto
	// 									SET
	// 										descricao = ?
	// 										codArea = $codArea
	// 									WHERE
	// 										codAssunto = {$_GET['ecod']}");
	// 		if(odbc_execute($prepare, array($assunto))){
	// 			header("Location: index.php");
	// 		}
	// 	}else{
	// 		$msg = "Não foi possível atualizar";
	// 	}
	// }
	// -------------------------------------------------------------------------- FIM UPDATE-------------------------------------------------------------------
	utf8_encode($msg);
	if(isset($_POST['btnNovo']) || isset($_POST['btnQuestao']) || isset($_GET['ecod'])) {
		include_once("templats/crudQuestao.php");
	} else {
		include_once("templats/questao.php");
	}

?>