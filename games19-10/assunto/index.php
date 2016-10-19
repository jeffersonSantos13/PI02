<?php

require('../db/db.php');

$msg = '';
$result = ' ';

// --------------------------------------------------------------------------Pesquisa --------------------------------------------------------------------------
if(isset($_POST['btnPesquisar'])) {
	if (!empty($_POST['txtPesquisa'])) {
			$pesquisa = $_POST['txtPesquisa'];
			// Criar um função para evitar injection

			$query = odbc_exec($db, "SELECT 
										ass.codAssunto, 
										ass.descricao as assdescricao,
										ass.codArea ,
										ar.descricao as ardescricao
									FROM 
										assunto as ass
									LEFT JOIN
										area as ar ON ar.codArea = ass.codArea
									WHERE descricao LIKE '%$pesquisa%'" ); 
			$butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
	} else {
			$query = odbc_exec($db, "SELECT 
										ass.codAssunto, 
										ass.descricao as assdescricao,
										ass.codArea ,
										ar.descricao as ardescricao
									FROM 
										assunto as ass
									LEFT JOIN
										area as ar ON ar.codArea = ass.codArea");
	}
} else {
	// Valor default
				$query = odbc_exec($db, "SELECT 
										ass.codAssunto, 
										ass.descricao as assdescricao,
										ass.codArea ,
										ar.descricao as ardescricao
									FROM 
										assunto as ass
									LEFT JOIN
										area as ar ON ar.codArea = ass.codArea");
}

// ---------------------------------------------------------- GRADES ---------------------------------------------------------------------
//AREA
$queryArea = odbc_exec($db, "SELECT
								codArea,
								descricao
							FROM
								Area");
while($resultArea = odbc_fetch_array($queryArea)){
	$areas[$resultArea['codArea']] = utf8_encode($resultArea['descricao']);
}

while($result = odbc_fetch_array($query)){
	$assuntos[$result['codAssunto']]['assdescricao'] = utf8_encode($result['assdescricao']);
	$assuntos[$result['codAssunto']]['codArea'] = $result['codArea'];
	$assuntos[$result['codAssunto']]['ardescricao'] = utf8_encode($result['ardescricao']);
}
// --------------------------------------------------------------------------DELETE--------------------------------------------------------------------------
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
		//verifica se existe dependencia
		// Corregir
		$descricao = odbc_exec($db,' SELECT 
										descricao 
									 FROM 
										Assunto 
									WHERE codArea='.$_GET['dcod']);
		if(odbc_num_rows($descricao) > 0){
			$msg = "NÃ£o foi possÃ­vel deletar.";
		}else{
			if(!odbc_exec($db, "DELETE FROM 
									Assunto
								WHERE 
									codAssunto =".$_GET['dcod'])){
				$msg = "NÃ£o foi possivel apagar o dado";
			}else{
				header("Location: index.php");
			}
		}
	}else{
		$msg = "ERRO : ID nÃ£o valido";
	}
}

// Customizar depois - Augusto
if (isset($_POST['btnNovo'])) {
	include_once('templats/crudAssunto.php');
} 

// -------------------------------------------------------------------------------INSERT ------------------------------------------------------------------------
if(isset($_POST['btnInclude'])) {
	$assunto = $_POST['txtInclude'];
	$assunto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtInclude']);
	$codArea = intval($_POST['codArea']);
	echo $codArea;
	if(!odbc_exec($db, "INSERT INTO 
							Assunto(descricao, codArea) 
						VALUES
							('$assunto', $codArea)" )){
		$msg = "Não foi possivel inserir";

	}else {
		header("Location: index.php");
	}
}

//-------------------------------------------------------------------------------EDITAR--------------------------------------------------------------------------
if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){
	$select = odbc_exec($db, "SELECT 
								codAssunto,
								descricao,
								codArea
							 FROM 
								Assunto 
							WHERE codArea = ".$_GET['ecod']);
	$result = odbc_fetch_array($select);
	include_once('templats/crudAssunto.php');
} else {
	$result = '';
}

// --------------------------------------------------------------------------UPDATE-------------------------------------------------------------------
if(isset($_POST['btnAssuntoUpdate']  )){
	if(is_numeric($_GET['ecod'])){
		$assunto = $_POST['txtAssuntoUpdate'];
		$assunto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtAssuntoUpdate']);
		$codArea = intval($_POST['codArea']);
		if(odbc_exec($db,"UPDATE 
							Assunto 
						SET 
						   descricao = '$assunto', 
						   codArea = $codArea
						WHERE codAssunto = {$_GET['ecod']}")){
			header("Location: index.php");
		}
	}else{
		$msg = "Não foi possível atualizar";
	}
}

include('templats/assunto.php');	

?>