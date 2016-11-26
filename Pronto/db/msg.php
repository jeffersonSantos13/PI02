<?php
	if(isset($_GET['dc'])){
		$msg .= "Desativada com sucesso.<br>";
	}
	if(isset($_GET['ic'])){
		$msg .= "Inserido com sucesso.<br>";
	}
	if(isset($_GET['uc'])){
		$msg .= "Atualizado com sucesso.<br>";
	}
	if(isset($_GET['dd'])){
		$msg .= "Deletado com sucesso.<br>";
	}
?>