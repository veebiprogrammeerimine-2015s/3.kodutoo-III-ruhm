<?php	

	// muutujad errorite jaoks
	$thread_error = "";
	$post_error = "";
	
	//muutujad andmebaasi väärtuste jaoks
	$thread = ""; $post = "";	

	
	
	// kontrollime et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//************************************************************
		//echo "keegi vajutas login nuppu";
		
		//vajutas login nuppu
		//************************************************************
		if(isset($_POST["create"])){
				
			if (empty($_POST["thread"]) ) {
				$thread_error = "This field is required";
			}else{
				// kõik korras
				// test_input eemaldab pahatahltikud osad
				$thread= cleanInput($_POST["thread"]);
				
				}
				
			if (empty($_POST["post"]) ) {
				$post_error = "This field is required";
				
			}else{
				
				$post = cleanInput($_POST["post"]);
				
				}
				
			if (empty($_POST["password"]) ) {
				$password_error = "This field is required";
			}else{
			
				$password = cleanInput($_POST["password"]);
				
			}
			// kontrollin et ei oleks ühtegi errorit
			if($thread_error == "" && $post_error == ""){
			
			// kasutaja loomise fn, failist functions.php
				addThread($thread, $post);
				
		
			}


	require_once("../functions.php");
	$page_title = "Threads";
	$page_file_name = "table.php";
	require_once("../header.php");

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


<html>
	<h2>Create thread</h2>
	
		<form action="table_user.php" method="post" >
			<input name="thread" type="text" placeholder="thread name"> * <?php echo $thread_error; ?><br> <br>
			<input name="post" type="email" placeholder="post"> * <?php echo $post_error; ?><br> <br>
			<input name="create" type="submit" value="Create"> <br> <br>
		</form>

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
</html>
<?php require_once("../footer.php"); ?>