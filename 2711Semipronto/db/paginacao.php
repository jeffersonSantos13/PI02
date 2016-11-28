<?php	
echo " <ul id='tablet'> ";
do{
	$i++;
	if(@$_GET['pg'] == $i || $i == 1 && !isset($_GET['pg'])){
		$focusClass = 'style="background-color: #7AD3FC"';
	}else{
		$focusClass = '';
	}
	echo " <li>";
			if(isset($_GET['pesq'])){
				echo "<a href='?pg=$i&pesq=".$_GET['pesq']."' $focusClass>$i</a>";
			}else{
				echo "<a href='?pg=$i' $focusClass>$i</a>";
			}
	echo "</li>";					
}while($i < $numPagina);

echo "</ul>";
?>