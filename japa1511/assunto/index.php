<?php
require('../acesso.php');
require('../db/db.php');

$msg = '';
$result = ' ';
// ----------------------------------------------------------------------PAGINA ----------------------------------------------------------------------------
$query = odbc_exec($db, "SELECT 
								codAssunto
							FROM
								Assunto
							");
$num = odbc_num_rows($query);
$numPagina = ceil($num/10);
$i = 0;
if(!isset($_GET['pg']))$pagina = 1;else $pagina = intval($_GET['pg']);
$limite = (10 * $pagina); 
// --------------------------------------------------------------------------Pesquisa --------------------------------------------------------------------------
if(isset($_GET['pesq'])) {
	if (!empty($_GET['pesq'])) {
			$pesquisa = $_GET['pesq'];
			// Criar um função para evitar injection

			$query = odbc_exec($db, "SELECT 
											ass.codAssunto, 
											ass.descricao as assdescricao,
											ass.codArea ,
											ar.descricao as ardescricao,
											count(*) as 'qtd'
										FROM 
											assunto as ass
										LEFT JOIN
											area as ar 
										ON ar.codArea = ass.codArea
										LEFT JOIN
											questao as q
										ON 
											ass.codAssunto = q.codAssunto
										WHERE ass.descricao LIKE '%$pesquisa%' or ar.descricao LIKE '%$pesquisa%'
										GROUP BY
											ass.codAssunto,
											ass.codArea ,
											ar.descricao,
											ass.descricao
										ORDER BY codAssunto
											OFFSET $limite-10 ROWS  
											FETCH NEXT 10 ROWS ONLY"); 
			$butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
			
			
			
			
	} else {
			$query = odbc_exec($db, "SELECT 
											ass.codAssunto, 
											ass.descricao as assdescricao,
											ass.codArea ,
											ar.descricao as ardescricao,
											count(*) as 'qtd'
										FROM 
											assunto as ass
										LEFT JOIN
											area as ar 
										ON ar.codArea = ass.codArea
										LEFT JOIN
											questao as q
										ON 
											ass.codAssunto = q.codAssunto
										GROUP BY
											ass.codAssunto,
											ass.codArea ,
											ar.descricao,
											ass.descricao
										ORDER BY codAssunto
											OFFSET $limite-10 ROWS  
											FETCH NEXT 10 ROWS ONLY");
	}
} else {
	// Valor default
				$query = odbc_exec($db, "SELECT 
											ass.codAssunto, 
											ass.descricao as assdescricao,
											ass.codArea ,
											ar.descricao as ardescricao,
											count(*) as 'qtd'
										FROM 
											assunto as ass
										LEFT JOIN
											area as ar 
										ON ar.codArea = ass.codArea
										LEFT JOIN
											questao as q
										ON 
											ass.codAssunto = q.codAssunto
										GROUP BY
											ass.codAssunto,
											ass.codArea ,
											ar.descricao,
											ass.descricao
										ORDER BY codAssunto
											OFFSET $limite-10 ROWS  
											FETCH NEXT 10 ROWS ONLY");
}

// ---------------------------------------------------------- GRADES ---------------------------------------------------------------------
//AREA

$num = odbc_num_rows($query);
while($result = odbc_fetch_array($query)){
	$assuntos[$result['codAssunto']]['assdescricao'] = utf8_encode($result['assdescricao']);
	$assuntos[$result['codAssunto']]['codArea'] = $result['codArea'];
	$assuntos[$result['codAssunto']]['ardescricao'] = utf8_encode($result['ardescricao']);
	$assuntos[$result['codAssunto']]['qtd'] = $result['qtd'];
}

// --------------------------------------------------------------------------DELETE--------------------------------------------------------------------------
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
		//verifica se existe dependencia
		
		if(!odbc_exec($db, "DELETE FROM 
								Assunto
							WHERE 
								codAssunto =".$_GET['dcod'])){
			$msg = "Não foi possível deletar.";
		}else{
			header("Location: index.php");
		}
		
	}else{
		$msg = "ERRO : ID não valido";
	}
}

// -------------------------------------------------------------------------------INSERT ------------------------------------------------------------------------
if(isset($_POST['btnInclude'])) {
	$assunto = $_POST['txtInclude'];
	$assunto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtInclude']);
	$codArea = intval($_POST['codArea']);

	$prepare = odbc_prepare($db, "INSERT INTO 
									Assunto (descricao, codArea) 
								VALUES 
									(?, $codArea)");
	if(!odbc_execute($prepare, array($assunto))){
		$msg = "Não foi possivel inserir";

	}else {
		header("Location: index.php");
	}
}

//-------------------------------------------------------------------------------EDITAR--------------------------------------------------------------------------
if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){
	$select = odbc_exec($db, "SELECT 
								ass.codAssunto, 
								ass.descricao as assdescricao,
								ass.codArea ,
								ar.descricao as ardescricao
							FROM 
								assunto as ass
							LEFT JOIN
								area as ar ON ar.codArea = ass.codArea
							WHERE 
								ass.codAssunto = ".$_GET['ecod']);
	$result = odbc_fetch_array($select);
} else {
	$result = '';
}

// --------------------------------------------------------------------------UPDATE-------------------------------------------------------------------
if(isset($_POST['btnAssuntoUpdate']  )){
	if(is_numeric($_GET['ecod'])){
		$assunto = $_POST['txtAssuntoUpdate'];
		$assunto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtAssuntoUpdate']);
		$codArea = intval($_POST['codArea']);
		
		$prepare = odbc_prepare($db, "UPDATE
										Assunto
									SET
										descricao = ?
										codArea = $codArea
									WHERE
										codAssunto = {$_GET['ecod']}");
		if(odbc_execute($prepare, array($assunto))){
			header("Location: index.php");
		}
	}else{
		$msg = "Não foi possível atualizar";
	}
}

// -------------------------------------------------------------------------- FIM UPDATE-------------------------------------------------------------------
$msg = utf8_encode($msg);
if(isset($_POST['btnNovo']) || isset($_GET['ecod']) ){
	include_once("templats/crudAssunto.php");
}else{
	include("templats/assunto.php");	
}

?>