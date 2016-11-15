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
					qs.dificuldade,
					CASE 
						WHEN qs.dificuldade = 'F' THEN 'Fácil'
						WHEN qs.dificuldade = 'M' THEN 'Médio' 
						WHEN qs.dificuldade = 'D' THEN 'Díficil' 
					END AS dificult,
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
		} else {
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
		$questao[$result['codQuestao']]['dificult'] = utf8_encode($result['dificult']);
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
					$msg .= 'Não foi possível deletar o registro N°' . $_GET['dcod'];  
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

		function load_area() {
			require('../db/db.php');
			$areaq = odbc_exec($db, "SELECT codArea, descricao FROM Area");
			$output = '';

			while ($result = odbc_fetch_array($areaq)) {
				$output .= '<option value="'.$result['codArea'].'" name="optArea">'. $result['descricao'] .'</option> ';
			}
			return $output;
		}
	}

	// INSERT	
	if (isset($_POST['btnQuestao'])) {

		$texto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['edtQuestao']);
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

		if (isset($ntem)) header("Location: index.php");
	}

	// --------------------------------------------------------------------------UPDATE-------------------------------------------------------------------
	if(isset($_GET['ecod'])) {
		if(!is_numeric($_GET['ecod']))$msg .= 'Código invalido.';

			$areaq = odbc_exec($db, "SELECT codArea, descricao FROM Area");

			while ($result = odbc_fetch_array($areaq)) {
				$area[$result['codArea']] = utf8_encode($result['descricao']);
			}	
								
			$assuntoq = odbc_exec($db, "SELECT codAssunto, codArea, descricao FROM Assunto");

			while ($result = odbc_fetch_array($assuntoq)) {
				$assunto[$result['codAssunto']] = utf8_encode($result['descricao']);
			}

			// Verifica a área da questão
			$assuntoquestao = odbc_exec($db, "SELECT 
												ar.codArea,
												ar.descricao
											FROM 
												Area AS ar 
											INNER JOIN Assunto AS ass ON ass.codArea = ar.codArea
											INNER JOIN Questao AS qs ON qs.codAssunto = ass.codAssunto
											WHERE 
												qs.codQuestao = ".$_GET['ecod']."");

			$assresult = odbc_fetch_array($assuntoquestao);
			$arearesult = $assresult['codArea']; 
			$arearesulta = $assresult['descricao']; 

			// Verifica as alternativas da questao
			$alt = odbc_exec($db, $queryAlternativa . " WHERE codQuestao = " . $_GET['ecod']);
			while ($altresult = odbc_fetch_array($alt)) {
			 	$alteranativas[$altresult['codAlternativa']]['textoAlternativa'] = utf8_encode($altresult['textoAlternativa']);
			 	$alteranativas[$altresult['codAlternativa']]['correta'] = utf8_encode($altresult['correta']);
			 } 

			// ----------------------------------------------- Realiza o UPDATE -------------------------------------------------
			$query = odbc_exec($db, $queryQuestao.' WHERE qs.codQuestao = ' .$_GET['ecod']);
			$result = odbc_fetch_array($query);
		
			if (isset($msg)) {
				if (isset($_POST['btnUpdate'])) {
					$texto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['edtQuestao']);
					$assunto = intval($_POST['optAssunto']);
					$dificult = $_POST['dificult'];

					// update da imagem 
					// include('loadimage.php');
					
					$questao = odbc_prepare($db, "UPDATE 
													Questao 
												SET  
													textoQuestao = ?, 
													codAssunto = ?,
													codTipoQuestao = ?,  
													codProfessor = ?,
													ativo = ?, 
													dificuldade = ? 
												WHERE 
													codQuestao = ".$_GET['ecod']."");

					if(!$query = odbc_execute($questao, array($texto, $assunto, 'A', 1, 1, $dificult))){		
						$msg .= "Não foi possivel atualiar a questão";
					} 

					$ntem = true;
					$i = 1;

					do {
					
						if(@$alternativa = $_POST['txtAlt'.$i]){

							$alterativaatualizar = odbc_prepare($db, "UPDATE 
																	 Alternativa 
																SET
																	textoAlternativa = ?, 
																	correta = ?	
																WHERE
																	codQuestao = ".$_GET['ecod']."
																	AND codAlternativa = ".$i." ");

							if ($_POST['rdAlt'] == $i) $correta = 1; else $correta = 0; 
							
					 		if (!$query = odbc_execute($alterativaatualizar, array($alternativa, $correta))) {
					 			$msg .= "Não foi possivel atualizar a alternativa";
					 		} else {
					 			$i++;
					 		}

						} else{
							$ntem = false;
						}

					} while($ntem);
				if (isset($ntem)) header("Location: index.php"); else $msg .= 'Não foi possível atualizar';
			}
		}
	}

	// -------------------------------------------------------------------------- FIM UPDATE-------------------------------------------------------------------
	utf8_encode($msg);
	if(isset($_POST['btnNovo']) || isset($_POST['btnQuestao']) || isset($_GET['ecod'])) {
		include_once("templats/crudQuestao.php");
	} else {
		include_once("templats/questao.php");
	}

?>