<?php
	require_once("functions.php");
	
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["delete"])){
		echo "kustutame id ".$_GET["delete"];
		
		
		deleteArmor($_GET["delete"]);
	}
	
	if(isset($_POST["save"])){
		
		updateArmor($_POST["id"], $_POST["armor_type"], $_POST["armor_race"], $_POST["armor_color"]);
	}
	
	$keyword= "";
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$armor_array = getArmorData($keyword);
		
	}else{
		$armor_array = getArmorData();
	}

?>
<h2>Tabel</h2>
<p>Soovita veel armoreid! <a href="data.php">Vajtua siia!</a></p>

<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?php echo $keyword;?>">
	<input type="submit">
</form>
<table border="1">
	<tr>
		<th>id</th>
		<th>user id</th>
		<th>armor type</th>
		<th>armor race</th>
		<th>armor color</th>
		<th>DELETE</th>
		<th>Edit</th>
	</tr>

	<?php
	
		for($i = 0; $i < count($armor_array); $i=$i+1){
			
			if(isset($_GET["edit"]) && $armor_array[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$armor_array[$i]->id."'>";
				echo "<td>".$armor_array[$i]->id."</td>";
				echo "<td>".$armor_array[$i]->user."</td>";
				echo "<td><input name='armor_type' value='".$armor_array[$i]->type."'></td>";
				echo "<td><input name='armor_race' value='".$armor_array[$i]->race."'></td>";
				echo "<td><input name='armor_color' value='".$armor_array[$i]->color."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save' value='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$armor_array[$i]->id."</td>";
				echo "<td>".$armor_array[$i]->user."</td>";
				echo "<td>".$armor_array[$i]->type."</td>";
				echo "<td>".$armor_array[$i]->race."</td>";
				echo "<td>".$armor_array[$i]->color."</td>";
				
				if($armor_array[$i]->user == $_SESSION["logged_in_user_id"]){
					echo "<td><a href='?delete=".$armor_array[$i]->id."'>X</a></td>";
					echo "<td><a href='edit.php?edit_id=".$armor_array[$i]->id."'>edit</a></td>";
				}
				echo "</tr>";
				
			}
		}
	
	?>

</table>