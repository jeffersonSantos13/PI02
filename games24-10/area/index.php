<?php

require('../db/db.php');

$msg = '';
$result = '';

// --------------------------------------------------------------------Pesquisa --------------------------------------------------------------------
if(isset($_POST['btnPesquisar'])) {
	if (!empty($_POST['txtPesquisa'])) {
			$pesquisa = $_POST['txtPesquisa'];
			// Criar um função para evitar injection

			$query = odbc_exec($db, "SELECT 
										codArea, 
										descricao 
									FROM 
										area
									WHERE descricao LIKE '%$pesquisa%'" ); 
			$butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
	} else {
		$query = odbc_exec($db, 'SELECT
									codArea,
									descricao
								FROM 
									Area');
	}
} else {
	// Valor default
	$query = odbc_exec($db, 'SELECT
								codArea,
								descricao
							FROM 
								Area');
}

//-------------------------------------------------------------------- Exibe na grade--------------------------------------------------------------------
while($result = odbc_fetch_array($query)){
	$areas[$result['codArea']] = utf8_encode($result['descricao']);
}

//--------------------------------------------------------------------DELETE--------------------------------------------------------------------
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
		//verifica se existe dependencia
		$descricao = odbc_exec($db,' SELECT 
										descricao 
									FROM 
										Assunto 
									WHERE codArea='.$_GET['dcod']);
		if(odbc_num_rows($descricao) > 0){
			$msg = "Não foi possível deletar.";
		}else{
			if(!odbc_exec($db, "DELETE FROM 
									Area 
								WHERE 
									codArea =".$_GET['dcod'])){
				$msg = "Não foi possivel apagar o dado";
			}else{
				header("Location: index.php");
			}
		}
	}else{
		$msg = "ERRO : ID não valido";
	}
}

// --------------------------------------------------------------------Customizar depois - Augusto--------------------------------------------------------------------
/*if (isset($_POST['btnNovo'])) {
	include_once('templats/crudArea.php');
} */


//-------------------------------------------------------------------- COMEÇO DOS CRUDS--------------------------------------------------------------------
// --------------------------------------------------------------------INSERT--------------------------------------------------------------------
if(isset($_POST['btnInclude'])) {
	$area = $_POST['txtInclude'];
	$area = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtInclude']);

	if(!odbc_exec($db, "INSERT INTO 
							Area (descricao) 
						VALUES
							('$area')")){
		$msg = "Não foi possivel inserir";
	}else {
		header("Location: index.php");
	}
}

//--------------------------------------------------------------------EDITAR--------------------------------------------------------------------
if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){
	$select = odbc_exec($db, "SELECT 
								codArea, 
								descricao 
							FROM 
								Area 
							WHERE codArea = ".$_GET['ecod']);
	$result = odbc_fetch_array($select);
	include_once('templats/crudArea.php');
} else {
	$result = '';
}

//--------------------------------------------------------------------UPDATE--------------------------------------------------------------------
if(isset($_POST['btnAlterar']  )){
	if(is_numeric($_GET['ecod'])){
		$area = $_POST['txtDescricao'];
		$area = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtDescricao']);
	
		if(odbc_exec($db,"UPDATE 
							Area 
						SET 
							descricao = '$area' 
						WHERE codArea = {$_GET['ecod']}")){
			header("Location: index.php");
		}
	}else{
		$msg = "Não foi possível atualizar";
	}
}


include('templats/area.php');	

?>