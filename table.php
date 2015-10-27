<?php

	require_once("functions.php");
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressi real
	if(isset($_GET["delete"])) {
		
		echo "Kustutame id "  .$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deletecar($_GET["delete"]);
	}
	
	if(isset($_POST["save"])) {
		
		updateCar($_POST["id"],$_POST["plate_number"], $_POST["color"]);
		
		
	}
	
	
	$keyword = ""; 
	// adressireal on keyword
	if(isset($_GET["keyword"])) {
		//otsin
		
		$keyword = $_GET["keyword"];
		$array_of_cars = getCarData($keyword);
		
	}else{
		//küsin kõik andmed
		
		//käivitan funktsiooni
		$array_of_cars = getCarData();
	}
	
	
	
	
	
	
	//trükin välja esimese auto
	
	//echo $array_of_cars[1] -> id. " ".$array_of_cars[1]->plate;
?>

<h2>Tabel</h2>

<form action="table.php" method="get" >
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="submit" value="Otsi">
</form>




<table border=1>
	<tr>
		<th>ID</th>
		<th>Numbrimärk</th>
		<th>Värv</th>
		<th>Kasutaja</th>
		<th>Kustuta</th>
		<th>VanaMuuda</th>
		<th>Muuda</th>
		

	</tr>
	
<?php
		// trükime välja read
		//massiivi pikkus count()
		for($i=0; $i<count($array_of_cars);$i++) {
			//echo $array_of_cars[$i]->id;
			//kasutaja tahab muuta rida
			if(isset($_GET["edit"]) && $array_of_cars[$i]->id == $_GET["edit"]) {
				
			echo "<tr>";
			echo "<form action='table.php' method='post'>";
			echo "<input type='hidden' name='id' value='".$array_of_cars[$i]->id."'>";
			echo "<td>".$array_of_cars[$i]->id."</td>";
			echo "<td><input name='plate_number' value='".$array_of_cars[$i]->plate."'></td>";
			echo "<td><input name='color' value='".$array_of_cars[$i]->color."'></td>";
			echo "<td>".$array_of_cars[$i]->user."</td>";
			echo "<td><a href='table.php'>Tühista</a></td>"; 
			echo "<td><input type='submit' name='Muuda'></td>"; 
			echo "</form>";
			echo "</tr>";	
				
				
		}else{
			echo "<tr>";
			echo "<td>".$array_of_cars[$i]->id."</td>";
			echo "<td>".$array_of_cars[$i]->plate."</td>";
			echo "<td>".$array_of_cars[$i]->color."</td>";
			echo "<td>".$array_of_cars[$i]->user."</td>";
			echo "<td><a href='?delete=".$array_of_cars[$i]->id."'>xXx</a>"; 
			echo "<td><a href='?edit=".$array_of_cars[$i]->id."'>Vana muutmine</a>";
			echo "<td><a href='edit.php?edit_id=".$array_of_cars[$i]->id."'>Muutmine</a>"; 
		
			echo "</tr>";
			
			
			
		}
		}
	
?>