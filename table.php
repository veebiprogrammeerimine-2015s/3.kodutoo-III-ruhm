<?php
	require_once("functions.php");
	
	
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteboot($_GET["delete"]);
		
	}
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateboot($_POST["id"], $_POST["boot_brand"], $_POST["model"]);
	}
	
	$keyword = "";
	
	//aadressireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$array_of_boots = getAllData($keyword);
		
	}else{
		
		// küsin kõik andmed
		
		//käivitan funktsiooni
		$array_of_boots = getAllData();
	}
	
	//trükin välja esimese auto
	//echo $array_of_cars[0]->id." ".$array_of_cars[0]->plate;
	
?>

<h2>Tabel</h2>
<table border=1 >
	<tr>
		<th>Id</th>
		<th>User id</th>
		<th>Boot brand</th>
		<th>Model</th>
		<th>X</th>
		<th>Edit</th>
	</tr>
	
	<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_boots); $i++){
			//echo $array_of_boots[$i]->id;
			
			//kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_boots[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_boots[$i]->id."'>";
				echo "<td>".$array_of_boots[$i]->id."</td>";
				echo "<td>".$array_of_boots[$i]->user_id."</td>";
				echo "<td><input name='boot_brand' value='".$array_of_boots[$i]->boot_brand."'></td>";
				echo "<td><input name='model' value='".$array_of_boots[$i]->model."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$array_of_boots[$i]->id."</td>";
				echo "<td>".$array_of_boots[$i]->user_id."</td>";
				echo "<td>".$array_of_boots[$i]->boot_brand."</td>";
				echo "<td>".$array_of_boots[$i]->model."</td>";
				echo "<td><a href='?delete=".$array_of_boots[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_boots[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
			}
			
		}
	
	?>
</table> 
