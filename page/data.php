<?php 
	require_once("../functions.php");
	//kui kasutaja on sisseloginud, suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$thread = $post = "";
	$thread_error = $post_error = "";
	
	if(isset($_POST["save"])){
		
		updateThread($_POST["id"], $_POST["thread"], $_POST["post"]);
	}
	
	if(isset($_POST["add_thread"])){
				
		if (empty($_POST["thread"]) ) {
			$thread_error = "This field is required";
		}else{
			$thread = cleanInput($_POST["thread"]);	
		}
		
		if (empty($_POST["post"]) ) {
			$post_error = "This field is required";		
		}else{
			$post = cleanInput($_POST["post"]);
		}
		
		if(	$thread_error == "" && $post_error == ""){
			$message = addThread($thread, $post);
			
			if($message != ""){
				//õnnestus
				// inputi väljad tühjaks
				$thread = "";
				$post = "";
				
				echo $message;
			}
			
			
		}
	}	
?>	
<p>
	Hello, <?php echo $_SESSION["logged_in_user_username"];?>
	<a href="?logout=1"> Log out <a>
</p>


<?php 	function cleanInput($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		// tagurpidi kaldkriipsud
		$data = stripslashes($data);
		// teeb htm'li tekstiks 
		$data = htmlspecialchars($data);
		return $data;
}?>


<h2>Add new thread</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="thread" >Thread title</label><br>
	<input id="thread" name="thread" type="text" value="<?php echo $thread; ?>"> <?php echo $thread_error; ?><br><br>
	<label for="post">Thread post</label><br>
	<input id="post" name="post" type="text" value="<?php echo $post; ?>"> <?php echo $post_error; ?><br><br>
	<input type="submit" name="add_thread" value="Submit">
</form>


<?php	

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
			
			if(isset($_GET["edit"]) && $array_of_threads[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action= 'data.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_threads[$i]->id."'>";
				echo "<td>".$array_of_threads[$i]->id."</td>";
				echo "<td>".$array_of_threads[$i]->user_id."</td>";
				echo "<td><input name='post'value='".$array_of_threads[$i]->post."'></td>";
				echo "<td><a href='data.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
								
				echo "<tr>";
				echo "<td>".$array_of_threads[$i]->id."</td>";
				echo "<td>".$array_of_threads[$i]->user_id."</td>";
				echo "<td>".$array_of_threads[$i]->thread."</td>";
				echo "<td>".$array_of_threads[$i]->post."</td>";
				echo "<td><a href='edit.php?edit_id=".$array_of_threads[$i]->id."'>edit</a></td>";
				echo "</tr>";
			

			}
		}
			
	
	?>

</table>

<?php require_once("../footer.php"); ?>