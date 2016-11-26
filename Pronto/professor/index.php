<?php
require("../acesso.php");
require("../db/db.php");
$msg = '';
include ("../db/msg.php");
$result = ' ';
// ----------------------------------------------------------------------PAGINA ----------------------------------------------------------------------------
if(isset($_GET['pesq'])){
	$pesquisa = $_GET['pesq'];
	$query = odbc_exec($db, "SELECT 
								codProfessor	
							FROM
								Professor
							WHERE descricao LIKE '%$pesquisa%'
						");
}else{
	$query = odbc_exec($db, "SELECT 
								codProfessor	
							FROM
								Professor");
}

$num = odbc_num_rows($query);
$numPagina = ceil($num/10);
$i = 0;
if(!isset($_GET['pg']))$pagina = 1;else $pagina = intval($_GET['pg']);
$limite = (10 * $pagina); 
	
// ------------------------------------------------- (PESQUISA)SELECT GRADE PROF -------------------------------
if(isset($_GET['pesq'])){
	if(!empty($_GET['pesq'])){
		// $campo = $_POST['slcPesquisa'];
		$pesquisa = $_POST['txtPesquisa'];

		$query = odbc_exec($db, "SELECT codProfessor,
										nome,	
										email,
										senha,
										idSenac,
										tipo
									FROM
										Professor
									WHERE nome LIKE '%$pesquisa%' or email LIKE '%$pesquisa%'
									ORDER BY codProfessor
											OFFSET $limite-10 ROWS  
											FETCH NEXT 10 ROWS ONLY");

		$butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
	}else{
	$query = odbc_exec($db, "SELECT codProfessor,
								nome,	
								email,
								senha,
								idSenac,
								tipo
							FROM
								Professor
							ORDER BY codProfessor
										OFFSET $limite-10 ROWS  
										FETCH NEXT 10 ROWS ONLY");	
	}
}else{
	$query = odbc_exec($db, "SELECT codProfessor,
								nome,	
								email,
								senha,
								idSenac,
								tipo
							FROM
								Professor
							ORDER BY codProfessor
							OFFSET $limite-10 ROWS  
							FETCH NEXT 10 ROWS ONLY");
}	
$num = odbc_num_rows($query);							
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
			// VERIFICA SE EXISTE PENDÊNCIA 
			$questao = odbc_exec($db, 'SELECT 
											codProfessor
										FROM 
											Questao as prof
										WHERE 
											codProfessor = ' . $_GET['ecod']);
			
			if(odbc_num_rows($questao) > 0) {
				$msg .= 'Professor em dependência em questões';
			}else{
				if(!odbc_exec($db, "DELETE FROM 
										Professor 
									WHERE 
										codProfessor =".$_GET['dcod'])){
					$msg .= "Não foi possível apagar o dado";
				}else{
					header("Location: index.php?dd");
				}
			}
	}else{
		$msg .= "ERRO : ID não válido";
	}
}
// ---------------------------------------- FIM DELETE ---------------------------------------------------------------
// ---------------------------------------- INSERT PROFESSOR ----------------------------------------------------------

if(isset($_POST['btnInclude'])) {

	$nome = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtNomeProf']);
	$email = $_POST['txtEmailProf'];
	$senha = $_POST['txtSenhaProf'];
	$Csenha = $_POST['txtConfSenhaProf'];
	$id = $_POST['txtIDProf'];
	$tipo = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['rdTipo']);
	
	//Verifica se os dados entrados estão corretos
	$selectEmail = odbc_exec($db, "SELECT email FROM Professor WHERE email = '$email'");
	$selectid = odbc_exec($db, "SELECT idSenac FROM Professor WHERE idSenac = '$id'");
	
	if(odbc_num_rows($selectEmail) > 0)@$msg .= "Email já cadastrado <br>";	
	if(odbc_num_rows($selectod) > 0)@$msg .= "ID já cadastrado <br>";	
	if(!is_numeric($id))@$msg .= "ID inserido não é numerico <br>";
	if(strlen($id) <> 6)@$msg .= "ID inserido não contem exatos 6 digitos <br>";
	if($tipo <> 'A' && $tipo <> 'P')@$msg .= "Tipo inserido não é valido <br>";
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))@$msg .= "Email não é valido <br>";
	if ($senha <> $Csenha) @$msg.= "As senhas não conferem <br>";
	
	// Verifica se algum erro foi encontrado para então fazer a inserção
	if(!isset($msg)){
		$prepare = odbc_prepare($db, "INSERT INTO
										Professor (nome, email, senha, idSenac, tipo)
									 VALUES
										(?, ?, ?, ?, ?)");

		if(!odbc_execute($prepare, array("$nome", "$email", "HASHBYTES('SHA1', $senha)", "$id", "$tipo"))){
			$msg .= "Não foi possivel inserir";
		}else {
			header("Location: index.php?ic");
		}
	}else{
		include_once("templats/crudProf.php");
	}	
}
// ---------------------------------------- FIM INSERT PROF ---------------------------------------------------------------
// ------------------------------------------------- COMEÇO UPDATE ----------------------------------------------------------
//Consulta do ID
if(isset($_GET['ecod'])){
	if(!is_numeric($_GET['ecod']))$msg .= 'Código invalido.';
	if(!isset($msg)){
		$query = odbc_exec($db, "SELECT 
							codProfessor,
							nome,	
							email,
							senha,
							idSenac,
							tipo
						FROM
							Professor
						WHERE
							codProfessor = ".$_GET['ecod']."");
		$result = odbc_fetch_array($query);
	}
	if(isset($_POST['btnUpdate'])){
		$nome = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtNomeProf']);
		$email = $_POST['txtEmailProf'];
		$senha = $_POST['txtSenhaProf'];
		$id = $_POST['txtIDProf'];
		$tipo = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['rdTipo']);
		//Verifica se os dados entrados estão corretos
		
		$selectEmail = odbc_exec($db, "SELECT email FROM Professor WHERE email = '$email'");
		$selectid = odbc_exec($db, "SELECT idSenac FROM Professor WHERE idSenac = '$id'");

		if(odbc_num_rows($selectEmail) > 0)@$msg .= "Email já cadastrado <br>";	
		if(odbc_num_rows($selectod) > 0)@$msg .= "ID já cadastrado <br>";	
		if(!is_numeric($id))@$msg .= "ID inserido não é numerico <br>";
		if(strlen($id) <> 6)@$msg .= "ID inserido não contem exatos 6 digitos <br>";
		if($tipo <> 'A' && $tipo <> 'P')@$msg .= "Tipo inserido não é valido <br>";
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))$msg .= "Email não é valido <br>";
		
		// Verifica se algum erro foi encontrado para então fazer a inserção
		if(!isset($msg)){
			$prepare = odbc_prepare($db, "UPDATE
											Professor
										SET
											nome = ?,
											email = ?,
											idSenac = ?,
											tipo = ?
										WHERE
											codProfessor = ".$_GET['ecod']."");
											
			if($query = odbc_execute($prepare, array($nome,$email,$id,$tipo))){
				header("Location: index.php?uc");
			}else{
				$msg .= "Não foi possivel atualizar";
			}
		
		}
	}
}
//-------------------------------------------------------- FIM UPDATE ------------------------------------------
if(isset($_POST['btnNovo']) || isset($_GET['ecod']) || isset($_POST['btnInclude'])){
	include_once("templats/crudProf.php");
}else{
	include_once("templats/prof.php");	
}

?>