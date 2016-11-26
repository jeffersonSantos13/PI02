<?php 
	require('../../db/db.php');
	$assuntoq = odbc_exec($db, "SELECT codAssunto, descricao FROM Assunto WHERE codArea = ". $_POST['codArea']."");

	$output = '';
	if (odbc_num_rows($assuntoq) > 0 ) {
		while ($result = odbc_fetch_array($assuntoq)) {
			$output .= '<option value="'.$result['codAssunto'].'" name="optArea">'. $result['descricao'] .'</option> ';
		}	
	} else {
		if ($_POST['codArea'] == 0) {
			$output = " <option value='0'> Escolha um assunto... </option> ";		
		} else {
			$output = " <option></option> ";		
		}
	}

	echo $output;
?>