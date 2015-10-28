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
