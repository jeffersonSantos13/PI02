<?php

	require('../db/db.php');

	$msg = '';
	$result = '';

	// Query default 
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
				 LEFT JOIN Professor as pro on pro.codProfessor = qs.codProfessor
				";

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





	include("templats/questao.php");
?>