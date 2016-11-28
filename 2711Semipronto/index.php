<!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<meta html lang="pt-br">
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<title>SENAQUIZ - HOME</title>
	</head>
	
	<body>
		<header>
			<nav id="menu">
				<ul>
				  <li><a href="index.php" class="nav-item">Home</a></li>
				  <li><a href="area/index.php" class="nav-item">Area</a></li>
				  <li><a href="assunto/index.php" class="nav-item">Assunto</a></li>
				  <li><a href="questao/index.php" class="nav-item">Questao</a></li>
				  <li><a href="questao/index.php" class="nav-item">Professor</a></li>
				</ul>
			</nav>
		</header>	
		<div id="section">
			<div id="textos">
				<div id="txt1" class="visivel">Bem vindo! Aqui você poderá realizar alterações de dados referente ao SENAQUIZ. Selecione um item abaixo para realizar alterações.</div>

				<div id="txt2" class="invisivel">	Para realizar alterações referente as Àreas, <a href="area/index.php">clique aqui.</a> </div>

				<div id="txt3" class="invisivel">	Caso queira cadastrar, editar ou excluir algum assunto registrado, <a href="assunto/index.php">clique aqui.</a> </div>

				<div id="txt4" class="invisivel">	Quer cadastrar alguma pergunta? Se sim, <a href="questao/index.php">clique aqui.</a> </div>

				<div id="txt5" class="invisivel">	Gostaria de registrar um professor? Caso queira, <a href="professor/index.php">clique aqui.</a></div>
			</div>
		</div>

		<div id="container">
			<input type="radio" id="foto1" name="grupo" checked>
			<label for="foto1"><img id="box1-img" class="gatilho" data-target="#txt1" src="img/logo.png"></label>

			<input type="radio" id="foto2" name="grupo">
			<label for="foto2"><img id="box2-img" class="gatilho" data-target="#txt2"  src="img/area.png"></label>

			<input type="radio" id="foto3" name="grupo">
			<label for="foto3"><img  id="box3-img" class="gatilho" data-target="#txt3"  src="img/assunto.png"></label>

			<input type="radio" id="foto4" name="grupo">
			<label for="foto4"><img id="box4-img" class="gatilho" data-target="#txt4" src="img/questao.png"></label>

			<input type="radio" id="foto5" name="grupo">
			<label for="foto5"><img id="box5-img" class="gatilho" data-target="#txt5"  src="img/professor.png"></label>

			<div class="principal">
				<div class="slide">
					<img src="img/logo.png" width="480" height="350" >
					<img src="img/area.png" width="480" height="400" >	
					<img src="img/assunto.png" width="480" height="300">
					<img src="img/questao.png" width="480" height="350">
					<img src="img/professor.png" width="480" height="400">
				</div>
			</div>
		</div>

		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript"> 
			$(function(){
			      
			  $('img.gatilho').click(function(event){

			  ajustarObjetos(this);    
			  });
			  
			});

			function ajustarObjetos(el)
			{	  
			  var id = $(el).data('target');      
			  if ($(id).hasClass('invisivel') === false) return;
			  
			  $(id).toggleClass('invisivel', 'visivel');
			  
			  var resultado = $('img').not(el);
			  
			  $.each(resultado, function(index, item){
			  	var target = $(item).data('target');
			    $(target).removeClass('visivel').addClass('invisivel');
			  });    
			}
		</script>
	</body>
</html>