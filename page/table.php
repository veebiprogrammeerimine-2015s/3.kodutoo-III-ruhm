<?php	

	require_once("functions.php");
	
	// kas kustutame midagi ??
	// ?delete=vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		
		echo "Deletingid".$_GET["delete"];
		// käivitan funktsiooni, saadan kaasa id !!
		deleteThread($_GET["delete"]);
	}
	
	// salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateThread($_POST["id"], $_POST["thread"], $_POST["post"]);
	}

		$keyword = "";
	
	//aadressireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$array_of_threads = getThreadData($keyword);
		
	}else{
		
		//küsin kõik andmed
		
		//käivitan funktsiooni
		$array_of_threads = getThreadData();
	}
	
	
	//echo $array_of_threads[0]->id." ".$array_of_threads[0]->thread;
?>

<h2>Threads</h2>

<form action="table.php" method="get" >
	<input type="search" name="keyword" value="<?=$keyword;?>" >
	<input type="submit" >
</form>

<table border=1 >
	<tr>
		<th>id</th>
		<th>user id</th>
		<th>Title</th>
		<th>Post</th>
		<th>Delete</th>
		<th>Edit</th>
	</tr>
	
	<?php
		// Trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_threads); $i++){
			//echo $array_of_threads[$i]->id;
			
			// kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_threads[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action= 'table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_threads[$i]->id."'>";
				echo "<td>".$array_of_threads[$i]->id."</td>";
				echo "<td>".$array_of_threads[$i]->user_id."</td>";
				echo "<td><input name='plate_number' value='".$array_of_threads[$i]->thread."'></td>";
				echo "<td><input name='color'value='".$array_of_threads[$i]->post."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
					
				echo "<tr>";
				echo "<td>".$array_of_threads[$i]->id."</td>";
				echo "<td>".$array_of_threads[$i]->user_id."</td>";
				echo "<td>".$array_of_threads[$i]->thread."</td>";
				echo "<td>".$array_of_threads[$i]->post."</td>";
				echo "<td><a href='?delete=".$array_of_threads[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_threads[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$array_of_threads[$i]->id."'>edit</a></td>";
				echo "</tr>";
			}
			
		}
	
	?>

</table>