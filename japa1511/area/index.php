<?php
require('../acesso.php');
require('../db/db.php');

$msg = '';
$result = '';
// ----------------------------------------------------------------------PAGINA ----------------------------------------------------------------------------
$query = odbc_exec($db, "SELECT 
								codArea,
								descricao
							FROM
								Area
							");
$num = odbc_num_rows($query);
$numPagina = ceil($num/10);
$i = 0;

if(!isset($_GET['pg']))$pagina = 1;else $pagina = intval($_GET['pg']);

$limite = (10 * $pagina); 

// --------------------------------------------------------------------Pesquisa --------------------------------------------------------------------
if(isset($_GET['pesq'])) {
	if (!empty($_GET['pesq'])) {
			$pesquisa = $_GET['pesq'];
			// Criar um função para evitar injection

			$query = odbc_exec($db, "SELECT
								area.codArea,
								area.descricao,		
								count(*) as 'AssuntoArea'
							FROM 
								Area
							LEFT OUTER JOIN
								Assunto
							ON 
								area.codArea = assunto.codArea
							WHERE area.descricao LIKE '%$pesquisa%'
							GROUP BY
								area.descricao,	
								area.codArea
							ORDER BY area.codArea
								OFFSET $limite - 10 ROWS  
								FETCH NEXT 10 ROWS ONLY" ); 
			$butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
	} else {
		$query = odbc_exec($db, "SELECT
									area.codArea,
									area.descricao,		
									count(*) as 'AssuntoArea'
								FROM 
									Area
								LEFT OUTER JOIN
									Assunto
								ON 
									area.codArea = assunto.codArea
								GROUP BY
									area.descricao,	
									area.codArea
								ORDER BY area.codArea
									OFFSET $limite - 10 ROWS  
									FETCH NEXT 10 ROWS ONLY");
		}
} else {
	// Valor default
	$query = odbc_exec($db, "SELECT
								area.codArea,
								area.descricao,		
								count(*) as 'AssuntoArea'
							FROM 
								Area
							LEFT OUTER JOIN
								Assunto
							ON 
								area.codArea = assunto.codArea
							GROUP BY
								area.descricao,	
								area.codArea
							ORDER BY area.codArea
								OFFSET $limite - 10 ROWS  
								FETCH NEXT 10 ROWS ONLY
							");
}

//-------------------------------------------------------------------- Exibe na grade--------------------------------------------------------------------


$num = odbc_num_rows($query);
while($result = odbc_fetch_array($query)){
	$areas[$result['codArea']]['descricao'] = utf8_encode($result['descricao']);
	$areas[$result['codArea']]['AssuntoArea'] = utf8_encode($result['AssuntoArea']);
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
		$numDec = odbc_num_rows($descricao);
		if($numDec > 0){
			$msg = "Não foi possivel deletar <br> A area possui dependencia com o(s) campo(s): ";
			while($pega = odbc_fetch_array($descricao)){
				$msg .= "".$pega['descricao'].", ";
			}
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

//-------------------------------------------------------------------- COMEÇO DOS CRUDS--------------------------------------------------------------------
// --------------------------------------------------------------------INSERT--------------------------------------------------------------------
if(isset($_POST['btnInclude'])) {
	$area = $_POST['txtInclude'];
	$area = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtInclude']);
	
	$prepare = odbc_prepare($db, "INSERT INTO 
									Area (descricao) 
								  VALUES 
									(?)");
	
	if(!odbc_execute($prepare, array($area))){
							
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
		
		$prepare = odbc_prepare($db, "UPDATE 
										Area 
									  SET 
										descricao = ? 
									  WHERE 
									   codArea = {$_GET['ecod']}");
		
		if(odbc_execute($prepare, array($area))){
			header("Location: index.php");
		}
	}else{
		$msg = "Não foi possível atualizar";
	}
}

//-------------------------------------------------------------------- FIM UPDATE--------------------------------------------------------------------
$msg = utf8_encode($msg);
if(isset($_POST['btnNovo']) || isset($_GET['ecod']) ){
	include_once('templats/crudArea.php');	
}else{
	include_once('templats/area.php');	
}
?>