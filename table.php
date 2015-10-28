<?php
	require_once("functions.php");
	
	
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressireal
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteContent($_GET["delete"]);
		
	}
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateContent($_POST["id"], $_POST["title"], $_POST["media"]);
	}
	
	
	$keyword = "";
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$array_of_content = getPosts($keyword);
		
	}else{
		
		//käivitan funktsiooni
	$array_of_content = getPosts();
	}
	
	
	

	
?>

<h2>Tabel</h2>

<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="submit" value="Otsi">
</form>

<table >
	<tr>
		
		<th>tiitel</th>
		<th>meedia</th>
		<th>X</th>
		<th>edit</th>
		<th></th>
	</tr>
	
	<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_content); $i++){
			//echo $array_of_content[$i]->id;
			
			//kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_content[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_content[$i]->id."'>";
				
				echo "<td><input name='title' value='".$array_of_content[$i]->title."'></td>";
				echo "<td><input name='media' value='".$array_of_content[$i]->media."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				
				echo "<td>".$array_of_content[$i]->title."</td>";
				echo "<td><img src='".$array_of_content[$i]->media."' width='200px'></td>";
				echo "<td><a href='?delete=".$array_of_content[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_content[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
			}
			
		}
	
	
	?>
</table>