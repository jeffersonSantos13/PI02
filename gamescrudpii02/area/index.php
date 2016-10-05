<?php

require('../db/db.php');

$msg = '';

// Pesquisa 
if(isset($_GET['btnPesquisar'])) {
	if (!empty($_GET['txtPesquisa'])) {
			$pesquisa = $_GET['txtPesquisa'];
			// Criar um funзгo para evitar injection

			$query = odbc_exec($db, "SELECT 
										codArea, 
										descricao 
									FROM 
										area 
									WHERE descricao LIKE '%$pesquisa%'" ); 
	} else {
		$query = odbc_exec($db, 'SELECT * FROM Area');
	}
} else {
	// Valor default
	$query = odbc_exec($db, 'SELECT * FROM Area');
}

// Exibe na grade
while($result = odbc_fetch_array($query)){
	$areas[$result['codArea']] = utf8_encode($result['descricao']);
}

//DELETE
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
		//verifica se existe dependencia
		$descricao = odbc_exec($db,' SELECT descricao FROM Assunto WHERE codArea='.$_GET['dcod']);
		if(odbc_num_rows($descricao) > 0){
			$msg = "Nгo foi possнvel deletar.";
		}else{
			if(!odbc_exec($db, "DELETE FROM Area WHERE codArea =".$_GET['dcod'])){
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
if (isset($_GET['btnNovo'])) {
	include('templats/crudArea.php');
} 

// INSERT
if(isset($_POST['btnEnviar']) ){
	$area = $_POST['txtDescricao'];
	$area = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtDescricao']);
	if(!odbc_exec($db, "INSERT INTO Area (descricao) VALUES('$area');")){
		$msg = "Nгo foi possivel inserir";
	}else {
		header("Location: index.php");
	}
}

//EDITAR - Corrigir ****************************************
if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){
	$select = odbc_exec($db, "SELECT * FROM Area WHERE codArea = ".$_GET['ecod']);
	$result = odbc_fetch_array($select);
	include('templats/crudArea.php');
}

//UPDATE
if(isset($_POST['editar'])){
	if(is_numeric($_GET['campo'])){
		$area = $_POST['txtArea'];
		$area = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtArea']);
		if(odbc_exec($db,"UPDATE Area SET descricao = '$area' WHERE codArea = {$_GET['campo']}")){
			header("Location: index.php");
		}
	}else{
		$msg = "Nгo foi possнvel atualizar";
	}
}


include('templats/area.php');	

?>