<?php
	require_once("functions.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$rating = "";

	//kas kustutame
	//vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
	
		echo "Kustutame id ".$_GET["delete"];
		deleteCar($_GET["delete"]);
		
	}
	
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateCar($_POST["id"], $_POST[“product”], $_POST[“product_material”]);
		
		
	}
	
	$keyword = "";
	
	//aadessireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$Cleint_array = getClientData($keyword);
	
	}else{
		
		//küsin kõik andmed
		
	}
	
//käivitan funktsiooni
	$Cleint_array = getClientData();

?>

<html>
<link rel="stylesheet" type="text/css" href="minukujundus.css">
<body><h2>Tabel</h2>

<form action="table.php" method="get">
	<input type="search" name="keyword">
	<input type="submit">
</form>

<table>
	<tr>
		<th>id</th>
		<th>User id</th>
		<th>product</th>
		<th>product_material</th>
		<th>X</th>
		<th>edit</th>
		<th></th>
	</tr>
	
</body>
</html>
	<?php
	//trükime välja read
	//
	for($i = 0; $i < count($Cleint_array); $i++){
		
		
		if(isset($_GET["edit"]) && $Cleint_array[$i]->id == $_GET["edit"]){
			
			echo"<tr>";
			echo"<from action='table.php' method='post'>";
			echo"<input type='hidden' name='id' value='".$Cleint_array[$i]->id."'>";
			echo"<td>".$Cleint_array[$i]->id."</td>";
			echo"<td>".$Cleint_array[$i]->user_id."</td>";
			echo"<td><input name='product' value='".$Cleint_array[$i]->product.”’></td>";
			echo"<td><input name='product_material'>value='".$Cleint_array[$i]->product_material.”’</td>";
			echo "<td><a href='table.php'>cancel</a></td>";
			echo "<td><input type='submit' name='save'></td>";
			echo"</form>";
			echo"</tr>";
			
			
		}else{
		
		//echo $Cleint_array[$i]->id;
			echo"<tr>";
			echo"<td>".$Cleint_array[$i]->id."</td>";
			echo"<td>".$Cleint_array[$i]->ptoduct.”</td>";
			echo"<td>".$Cleint_array[$i]->user_id."</td>";
			echo"<td>".$Cleint_array[$i]->product_material.”</td>";
			echo "<td><a href='?delete=".$array_of_cars[$i]->id."'>X</a></td>";
			echo "<td><a href='?edit=".$Cleint_array[$i]->id."'>edit</a></td>";
			echo "<td><a href='?edit.php?edit_id=3".$Cleint_array[$i]->id."'>edit</a></td>";
			echo"</tr>";
			}
		
		}
		

	
	?>
</table>