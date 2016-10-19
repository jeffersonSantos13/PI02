<?php
require("../db/db.php");

	$msg = "Em produção";
	
// ------------------------------------------------- SELECT GRADE PROF -------------------------------

$query = odbc_exec($db, "SELECT codProfessor,
								nome,	
								email,
								senha,
								idSenac,
								tipo
							FROM
								Professor");
while($result = odbc_fetch_array($query)){
		
	$prof[$result['codProfessor']]['nome'] = utf8_encode($result['nome']);	
	$prof[$result['codProfessor']]['email'] = utf8_encode($result['email']);	
	$prof[$result['codProfessor']]['senha'] = utf8_encode($result['senha']);	
	$prof[$result['codProfessor']]['idSenac'] = $result['idSenac'];	
	$prof[$result['codProfessor']]['tipo'] = $result['tipo'];	
	

}
// -------------------------------------------------------- DELETE -------------------------------------------------
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
			if(!odbc_exec($db, "DELETE FROM 
									Professor 
								WHERE 
									codProfessor =".$_GET['dcod'])){
				$msg = "Não foi possivel apagar o dado";
			}else{
				header("Location: index.php");
			}
	}else{
		$msg = "ERRO : ID não valido";
	}
}
// ---------------------------------------- FIM DELETE ---------------------------------------------------------------

	include("templats/prof.php");
?>