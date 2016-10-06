<?php

require('../db/db.php');

$msg = '';
$result = ' ';

// Pesquisa 
if(isset($_POST['btnPesquisar'])) {
	if (!empty($_POST['txtPesquisa'])) {
			$pesquisa = $_POST['txtPesquisa'];
			// Criar um funзгo para evitar injection

			$query = odbc_exec($db, "SELECT 
										codAssunto, 
										descricao 
									FROM 
										area 
									WHERE descricao LIKE '%$pesquisa%'" ); 
	} else {
		$query = odbc_exec($db, 'SELECT * FROM Assunto');
	}
} else {
	// Valor default
	$query = odbc_exec($db, 'SELECT * FROM Assunto');
}

// Exibe na grade
while($result = odbc_fetch_array($query)){
	$areas[$result['codAssunto']] = utf8_encode($result['descricao']);
}

//DELETE
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
		//verifica se existe dependencia
		// Corregir
		$descricao = odbc_exec($db,' SELECT descricao FROM Assunto WHERE codArea='.$_GET['dcod']);
		if(odbc_num_rows($descricao) > 0){
			$msg = "Nгo foi possнvel deletar.";
		}else{
			if(!odbc_exec($db, "DELETE FROM Assunto WHERE codAssunto =".$_GET['dcod'])){
				$msg = "Nгo foi possivel apagar o dado";
			}else{
				header("Location: index.php");
			}
		}
	}else{
		$msg = "ERRO : ID nгo valido";
	}
}

// Customizar depois - Augusto
if (isset($_POST['btnNovo'])) {
	include_once('templats/crudAssunto.php');
} 

// INSERT
if(isset($_POST['btnEnviar'])) {
	$assunto = $_POST['txtDescricao'];
	$assunto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtDescricao']);
	if(!odbc_exec($db, "INSERT INTO Assunto (descricao) VALUES('$assunto');")){
		$msg = "Nгo foi possivel inserir";
	}else {
		header("Location: index.php");
	}
}

//EDITAR
if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){
	$select = odbc_exec($db, "SELECT * FROM Assunto WHERE codArea = ".$_GET['ecod']);
	$result = odbc_fetch_array($select);
	include_once('templats/crudAssunto.php');
} else {
	$result = '';
}

//UPDATE
if(isset($_POST['btnAlterar']  )){
	if(is_numeric($_GET['ecod'])){
		$assunto = $_POST['txtDescricao'];
		$assunto = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtDescricao']);
		if(odbc_exec($db,"UPDATE Assunto SET descricao = '$assunto' WHERE codArea = {$_GET['ecod']}")){
			header("Location: index.php");
		}
	}else{
		$msg = "Nгo foi possнvel atualizar";
	}
}

include('templats/assunto.php');	

?>