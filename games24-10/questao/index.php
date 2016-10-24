<?php

	require('../db/db.php');

	$msg = '';
	$result = '';

	// Query Questão 
	$queryQuestao = "SELECT TOP 10
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
				 LEFT JOIN Professor as pro on pro.codProfessor = qs.codProfessor
				";

	// Query Imagem			
	$queryImagem = "SELECT TOP 10
						codImagem,
						tituloImagem,
						bitmapImagem
					FROM
						Imagem ";		

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
					
				$query = odbc_exec($db, $queryQuestao . " WHERE qs.textoQuestao LIKE '%$pesquisa%'");
				// $butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
		} else {
			$query = odbc_exec($db, $queryQuestao);
		}
	} else {
		// Valor default
		$query = odbc_exec($db, $queryQuestao);
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
			if(odbc_num_rows($queryAlternativa) > 0) {

				$msg = "Não foi possível deletar.";	

			} else {

				if (!odbc_exec($db, "DELETE FROM questao WHERE codQuestao = ".$_GET['dcod'])) {
					$msg = 'Não foi possível deletar o registro N°' . $_GET['dcod'];  
				} else {
					header("Location: index.php");
				}
			}	
		} else {
			$msg = "ERRO : ID não valido";
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

	if(isset($_POST['btnNovo']) || isset($_GET['dcod'])) {
		include_once("templats/crudQuestao.php");
	} else {
		include_once("templats/questao.php");
	}

?>