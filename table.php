<?php
	require_once("functions.php");
	require_once("edit_functions.php");
	
	
	if(!isset($_SESSION["logged_in_user_id"])){
	header("Location: login.php");
	}
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteAnimal($_GET["delete"]);
		
	}
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateAnimal($_POST["id"], $_POST["animal"], $_POST["animal_name"]);
	}
	
	
	//käivitan funktsiooni
	$array_of_animals = getEditData($edit_id);
	
	//trükin välja esimese looma
	//echo $array_of_animals[0]->id." ".$array_of_animals[0]->animal;
	
?>

<h2>Tabel</h2>
<table border=1 >
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>Looma liik</th>
		<th>Looma nimi</th>
		<th>X</th>
		<th>edit</th>
	</tr>
	
	<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_animals); $i++){
			//echo $array_of_animals[$i]->id;
			
			//kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_animals[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_animals[$i]->id."'>";
				echo "<td>".$array_of_animals[$i]->id."</td>";
				echo "<td>".$array_of_animals[$i]->user_id."</td>";
				echo "<td><input name='animal' value='".$array_of_animals[$i]->animal."'></td>";
				echo "<td><input name='animal_name' value='".$array_of_animals[$i]->animal_name."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$array_of_animals[$i]->id."</td>";
				echo "<td>".$array_of_animals[$i]->user_id."</td>";
				echo "<td>".$array_of_animals[$i]->animal."</td>";
				echo "<td>".$array_of_animals[$i]->animal_name."</td>";
				echo "<td><a href='?delete=".$array_of_animals[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_animals[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
			}
			
		}
	
	?>
</table>