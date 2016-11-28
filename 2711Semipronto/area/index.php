<?php

ini_set('default_charset', 'iso8859-1');	


require('../acesso.php');
require('../db/db.php');

$msg = '';
$result = '';

include ("../db/msg.php");
// ----------------------------------------------------------------------PAGINA ----------------------------------------------------------------------------
if(isset($_GET['pesq'])){
	$pesquisa = $_GET['pesq'];
	$query = odbc_exec($db, "SELECT 
								codArea,
								descricao
							FROM
								Area
							WHERE descricao LIKE '%$pesquisa%'
						");
}else{
	$query = odbc_exec($db, "SELECT 
								codArea,
								descricao
							FROM
								Area
							");

}
$num = odbc_num_rows($query);
$numPagina = ceil($num/10);
$i = 0;

if(!isset($_GET['pg']))$pagina = 1;else $pagina = intval($_GET['pg']);

$limite = (10 * $pagina); 

// --------------------------------------------------------------------Pesquisa --------------------------------------------------------------------
if(isset($_GET['pesq'])) {
	if (!empty($_GET['pesq'])) {
			$pesquisa = $_GET['pesq'];
			// Criar um fun��o para evitar injection

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

			$butt = "<button id='btnVoltar'><a href='index.php?pesq'>Voltar</a></button>";

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
	$areas[$result['codArea']]['descricao'] = $result['descricao'];
	$areas[$result['codArea']]['AssuntoArea'] = $result['AssuntoArea'];
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
			$msg = "N�o foi possivel deletar <br> A area possui dependencia com o(s) campo(s): ";
			while($pega = odbc_fetch_array($descricao)){
				$msg .= "".$pega['descricao'].", ";
			}
		}else{
			if(!odbc_exec($db, "DELETE FROM 
									Area 
								WHERE 
									codArea =".$_GET['dcod'])){
				$msg = "N�o foi possivel apagar o dado";
			}else{
				header("Location: index.php?dd");
			}
		}
	}else{
		$msg = "ERRO : ID n�o valido";
	}
}

// --------------------------------------------------------------------INSERT--------------------------------------------------------------------
if(isset($_POST['btnInclude'])) {
	$area = $_POST['txtInclude'];
	$verifica = odbc_exec($db, "SELECT codArea FROM Area WHERE descricao = '$area'");
	
	if(odbc_num_rows($verifica) > 0){
		$msg .= "Area j� cadastrada";
	}else{
		if(!empty($area)){
			$prepare = odbc_prepare($db, "INSERT INTO 
											Area (descricao) 
										  VALUES 
											(?)");
			
			if(!odbc_execute($prepare, array($area))){
									
				$msg .= "N�o foi possivel inserir";
			}else {
				header("Location: index.php?ic");
			}
		}else{
			$msg .= "N�o foi possivel inserir. Campo em branco.";
		}
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
		if(!empty($area)){
			$prepare = odbc_prepare($db, "UPDATE 
											Area 
										  SET 
											descricao = ? 
										  WHERE 
										   codArea = {$_GET['ecod']}");
			
			if(odbc_execute($prepare, array($area))){
				header("Location: index.php?uc");
			}else{
				$msg .= "N�o foi poss�vel atualizar";
			}
		}else{
			$msg .= "N�o � possivel atualizar para a descricao para em branco";
		}
	}
}

//-------------------------------------------------------------------- FIM UPDATE--------------------------------------------------------------------
$msg = utf8_encode($msg);
if(isset($_POST['btnNovo']) || isset($_GET['ecod']) ){
	include_once('templats/crudArea.php');	
} else {
	include_once('templats/area.php');	
}

?>