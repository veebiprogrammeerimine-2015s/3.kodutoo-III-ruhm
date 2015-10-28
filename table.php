<?php 
	require_once("functions.php");

	//kas kustutame
	//?delete = vastav id mida kustutada
	if(isset($_GET["delete"])){
	
		echo "Kustutame id".$_GET["delete"];
		deleteCar($_GET["delete"]);
	
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$array_of_dreams = getDreamData($_GET["keyword"]);
	}else{
	
	
	//käivitan funktsiooni
	$array_of_dreams = getDreamData();
	}
	//trükin välja esimese auto
	//echo $array_of_cars[0]->id. " ".$array_of_cars[0]->plate;

?>

<h2>Tabel</h2>

<form action="table.php" method="get">

<input type="search" name="keyword" value="<?=$keyword;?>">
<input type="submit">

</form>


<table border=1>
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>unenägu</th>
		<th>X</th>
		<th>edit</th>
		<th>O</th>
	</tr>
	<?php
		//trükime välja read
		//
		for($i = 0; $i < count($array_of_dreams); $i++){
			//echo $array_of_dreams[$i]->id;
			
			if(isset($_GET["edit"]) && $array_of_dreams[$i]->id == $_GET["edit"]){
			
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_dreams[$i]->id."'>";
				echo "<td>".$array_of_dreams[$i]->id."</td>";
				echo "<td>".$array_of_dreams[$i]->user_id."</td>";
				echo "<td><input name='post_dream' value='".$array_of_dreams[$i]->dream."'></td>";
				echo "<td><a href='table.php'>candel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				
				echo "</tr>";
			
			}else{
			
			echo "<tr>";
			echo "<td>".$array_of_dreams[$i]->id."</td>";
			echo "<td>".$array_of_dreams[$i]->user_id."</td>";
			echo "<td>".$array_of_dreams[$i]->dream."</td>";
			echo "<td><a href='?delete=".$array_of_dreams[$i]->id."'>X</a></td>";
			echo "<td><a href='?edit=".$array_of_dreams[$i]->id."'>edit</a></td>";
			echo "<td><a href='edit.php?edit_id=".$array_of_dreams[$i]->id."'>edit.php</a></td>"; //enne ? tuleb kirjutada see kuhu me tahame et ta andme kirjutaks, siis suunab edasi teise faili
			echo "</tr>";
			}
		}
	?>