<?php 
	if (@$_SESSION['showMenu']) {
?>
<header>
	<nav id="menu">
		<ul>
		  <li><a href="../index.php" class="nav-item">Home</a></li>
		  <li><a href="../area/index.php" class="nav-item">&Aacute;rea</a></li>
		  <li><a href="../assunto/index.php" class="nav-item">Assunto</a></li>
		  <li><a href="../questao/index.php" class="nav-item">Quest&atilde;o</a></li>
		  <li><a href="../professor/index.php" class="nav-item">Professor</a></li>
		</ul>
	</nav>
</header>	

<?php
	}
?>

