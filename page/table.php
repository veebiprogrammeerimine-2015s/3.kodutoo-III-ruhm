<?php	

	require_once("../functions.php");
	$page_title = "Threads";
	$page_file_name = "table.php";
	require_once("../header.php");

	// salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateThread($_POST["id"], $_POST["thread"], $_POST["post"]);
	}

		$thread = "";
	
	//aadressireal on keyword
	if(isset($_GET["thread"])){
		
		//otsin
		$thread= $_GET["thread"];
		$array_of_threads = getThreadData($thread);
		
	}else{
		
		//küsin kõik andmed
		
		//käivitan funktsiooni
		$array_of_threads = getThreadData();
	}
	
	
	//echo $array_of_threads[0]->id." ".$array_of_threads[0]->thread;
?>

<h2>Threads</h2>

<form action="table.php" method="get" >
	<input type="search" name="thread" placeholder="find post" value="<?=$thread;?>" >
	<input type="submit" >
</form>

<table border=1 >
	<tr>
		<th>id</th>
		<th>user id</th>
		<th>Title</th>
		<th>Post</th>
	</tr>
	
	<?php
		// Trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_threads); $i++){
								
				echo "<tr>";
				echo "<td>".$array_of_threads[$i]->id."</td>";
				echo "<td>".$array_of_threads[$i]->user_id."</td>";
				echo "<td>".$array_of_threads[$i]->thread."</td>";
				echo "<td>".$array_of_threads[$i]->post."</td>";
				echo "</tr>";
			

			}
			
	
	?>

</table>

<?php require_once("../footer.php"); ?>