<?php 
	// Controle de acesso 
	
	// Iniciar a sessão
	session_start();
	
	$_SESSION['codProfessor'] = 123;
	$_SESSION['tipoProfessor'] = 'A';

	// Quando colocado no servidor, deixar como false
	$_SESSION['showMenu'] = TRUE;

	//INTEGRAÇÃO
	include('../integracao/loginFunc.php');
	lidaBasicAuthentication ('../../../portal/naoautorizado.php');

	if (!isset($_SESSION['codProfessor']) || @!is_numeric($_SESSION['codProfessor'])) {
		$acesso = 0;
		// header("Location: ../login.php");
		echo "Acesso negado";
		exit();
	}  else $acesso = 1;
?>
