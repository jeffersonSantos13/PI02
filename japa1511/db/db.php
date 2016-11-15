<?php 
$dbhost = 	"koo2dzw5dy.database.windows.net"; 
$db =		"SenaQuiz";
$user = 	"TSI@koo2dzw5dy.database.windows.net";
$password = "SistemasInternet123";
$dsn = 		"Driver={SQL SERVER};Server=$dbhost;Port=1433;Database=$db;";
$db = odbc_connect( $dsn, $user, $password);

?>