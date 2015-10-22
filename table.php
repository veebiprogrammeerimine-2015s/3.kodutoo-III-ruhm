<?php
	require_once("functions.php");
	
	
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteNote($_GET["delete"]);
		
	}
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		var_dump($_POST);
		updateNote($_POST["id"], $_POST["pealkiri"], $_POST["märkus"]);
	}
	
		$keywod = "";
	//aadressireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$array_of_notes = getNoteData($keyword);
		
	}else{
		
		//kusin koik andmed
	
	
	//käivitan funktsiooni
	$array_of_notes = getNoteData();
	
?>

<h2>Tabel</h2>

<form action="table.php" method="get" >
	<input type="search" name="keyword" >
	<input type="submit" >
</form>

<table border=1 >
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>pealkiri</th>
		<th>märkus</th>
		<th>X</th>
		<th>edit</th>
		<th></th>
	</tr>
	
	<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_notes); $i++){
			//echo $array_of_notes[$i]->id;
			
			//kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_notes[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_notes[$i]->id."'>";
				echo "<td>".$array_of_notes[$i]->id."</td>";
				echo "<td>".$array_of_notes[$i]->user_id."</td>";
				echo "<td><input name='pealkiri' value='".$array_of_notes[$i]->pealkiri."'></td>";
				echo "<td><input name='märkus' value='".$array_of_notes[$i]->märkus."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$array_of_notes[$i]->id."</td>";
				echo "<td>".$array_of_notes[$i]->user_id."</td>";
				echo "<td>".$array_of_notes[$i]->pealkiri."</td>";
				echo "<td>".$array_of_notes[$i]->märkus."</td>";
				echo "<td><a href='?delete=".$array_of_notes[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_notes[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$array_of_notes[$i]->id."'>edit.php</a></td>";
				echo "</tr>";
				
			}
			
		}
	
	
	?>
</table>
