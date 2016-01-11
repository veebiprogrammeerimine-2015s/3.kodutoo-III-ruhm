<?php
	require_once("functions2.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$product = "";

	//kas kustutame
	//vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
	
		echo "Kustutame id ".$_GET["delete"];
		deleteOrders($_GET["delete"]);
		
	}
	
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateOrders($_POST["id"], $_POST["product"], $_POST["product_material"]);
		
		
	}
	
	$keyword = "";
	
	//aadessireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$Orders_array = getOrdersData($keyword);
	
	}else{
		
		//küsin kõik andmed
		
	}
	
//käivitan funktsiooni
	$Orders_array = getOrdersData();

?>

<html>
<link>
<body><h2>Tabel</h2>

<form action="table.php" method="get">
	<input type="search" name="keyword">
	<input type="submit">
</form>

<table border="1">
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>Toode</th>
		<th>Toote materjal</th>
		<th>X</th>
		<th>edit</th>
		<th></th>
	</tr>
	
</body>
</html>
	<?php
	//trükime välja read
	//
	for($i = 0; $i < count($Orders_array); $i++){
		
		
		if(isset($_GET["edit"]) && $Orders_array[$i]->id == $_GET["edit"]){
			
			echo"<tr>";
			echo"<form action='table.php' method='post'>";
			echo"<input type='hidden' name='id' value='".$Orders_array[$i]->id."'>";
			echo"<td>".$Orders_array[$i]->id."</td>";
			echo"<td>".$Orders_array[$i]->user_id."</td>";
			echo"<td><input name='product' value='".$Orders_array[$i]->product."’></td>";
			echo"<td><input name='product_material'>value='".$Orders_array[$i]->product_material."’</td>";
			echo "<td><a href='table.php'>cancel</a></td>";
			echo "<td><input type='submit' name='save'></td>";
			echo"</form>";
			echo"</tr>";
			
			
		}else{
		
		
			echo"<tr>";
			echo"<td>".$Orders_array[$i]->id."</td>";
			echo"<td>".$Orders_array[$i]->user_id."</td>";
			echo"<td>".$Orders_array[$i]->product."</td>";
			echo"<td>".$Orders_array[$i]->product_material."</td>";
			echo "<td><a href='?delete=".$Orders_array[$i]->id."'>X</a></td>";
			echo "<td><a href='?edit=".$Orders_array[$i]->id."'>edit</a></td>";
			echo "<td><a href='edit.php?edit_id=".$Orders_array[$i]->id."'>edit.php</a></td>";
			echo "</tr>";			}
		
		}
		

	
	?>
</table>