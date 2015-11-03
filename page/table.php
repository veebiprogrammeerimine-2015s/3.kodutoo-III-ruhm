<?php
	require_once("functions.php");
	
	//kas kustutame
	//?delete=vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		echo "kustutame id ".$_GET["delete"];
		//käivitan funktsiooni,saadan kaasa id
		deletePlace($_GET["delete"]);
	}
	
	//salvestan andmebaasi
	if(isset($_POST["salvesta"])){
		updatePlace($_POST["id"],$_POST["location"],$_POST["condition"],$_POST["description"],$_POST["date_visited"]);
		
	}
	$keyword="";
	if(isset($_GET["keyword"])){
		$keyword=$_GET["keyword"];
		$array_of_places = getPlaceData($keyword);
	}else{
		//k媶itan funktsiooni
	$array_of_places = getPlaceData(); 
	//tr𫩮 v孪a esimese auto
	//echo $array_of_places[0]->id." ".$array_of_places[0]->plate;
	}
	
?>

<h2>Tabel</h2>

<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="submit">
</form>
<table>
	<tr>
		<th>id</th>
		<th>Kasutaja id</th>
		<th>Asukoht</th>
		<th>Konditsioon</th>
		<th>Kirjeldus</th>
		<th>Külastusaeg</th>
		<th>Kustuta</th>
		<th>Redigeeri</th>
		<th>midagi</th>
	</tr>
	<?php
		//tr�kime v�lja read
		//massiivi pikkus count()
		for($i=0;$i<count($array_of_places);$i++){
			
			
			if(isset($_GET["edit"])&&$array_of_places[$i]->id==$_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_places[$i]->id."'>";
				echo "<td>".$array_of_places[$i]->id."</td>";
				echo "<td>".$array_of_places[$i]->user_id."</td>";
				echo "<td><input name='plate_number' value='".$array_of_places[$i]->location."'></td>";
				echo "<td><input name='color' value='".$array_of_places[$i]->condition."'></td>";
				echo "<td><input name='color' value='".$array_of_places[$i]->description."'></td>";
				echo "<td><input name='color' value='".$array_of_places[$i]->date_visited."'></td>";
				echo "<td><a href='table.php'>Cancel</a></td>";
				echo "<td><input type='submit' name='salvesta'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
			
				echo "<tr>";
				echo "<td>".$array_of_places[$i]->id."</td>";
				echo "<td>".$array_of_places[$i]->user_id."</td>";
				echo "<td>".$array_of_places[$i]->location."</td>";
				echo "<td>".$array_of_places[$i]->condition."</td>";
				echo "<td>".$array_of_places[$i]->description."</td>";
				echo "<td>".$array_of_places[$i]->date_visited."</td>";
				echo "<td><a href='?delete=".$array_of_cars[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_cars[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$array_of_cars[$i]->id."'>edit.php</a></td>";
				echo "</tr>";
			}
		}
		
	?>	
</table>
