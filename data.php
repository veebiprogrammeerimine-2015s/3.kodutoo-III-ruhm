<?php
	require_once("functions.php");
	//data.php
	//siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud, siis suunan login.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
			//header("Location: login.php");
	}

	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
	session_destroy();
		
		header("Location: login.php");
	}
	
	$tweet = "";
	$tweet_error = "";
	
	if(isset($_POST["add_tweet"])){
		
		if(empty($_POST["tweet"]) ){
			$tweet_error = " See väli on kohustuslik.";
		}else{
			$tweet = cleanInput($_POST["tweet"]);
		}
		
		if(	$tweet_error == ""){
	
			$msg = addPost($tweet);
			
			if($msg != ""){
				$tweet = "";
				echo "$msg";
				
			}
			
		}	
	}	
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	
?>
<p>	Tere,  <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja</a> 
</p> 
	
	
<h2>Lisa säuts</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<label for="tweet">Säuts</label><br>
	<input name="tweet" id="tweet" type="text"  value="<?php echo $tweet; ?>">* <?php echo $tweet_error; ?> <br><br>
	<input name="add_tweet" type="submit" value="Salvesta">
	<input name="change_tweet" type="submit" value="Muuda" onclick="window.open('table.php')">
</form>

<h2>Säutsud</h2>

<?php
	require_once("functions.php");
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id".$_GET["delete"];
		deletePost($_GET["delete"]);	
	}
	
	if(isset($_POST["save"])){
		
		updatePost($_POST["id"],$_POST["tweet"]);
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		
		$keyword = ($_GET["keyword"]); 
		$array_of_tweets = getPostData($keyword);
	}else{
		
		$array_of_tweets = getPostData();
	}
?>
<table border="1">
	<tr>
		<th>Kasutaja Id</th>
		<th>Säuts</th>

	</tr>
	
	<?php
		for($i = 0; $i < count($array_of_tweets); $i++){

			
			if(isset($_GET["edit"]) && $array_of_tweets[$i]->id == $_GET["edit"]){
				
				echo"<tr>";
				echo"<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_tweets[$i]->id."'>";
				echo "<td>".$array_of_tweets[$i]->user_id."</td>";
				echo "<td><input name='tweet' value='".$array_of_tweets[$i]->tweet."'></td>";
				echo"</form>";
				echo"</tr>";
				
			}else{
				echo"<tr>";
				echo "<td>".$array_of_tweets[$i]->user_id."</td>";
				echo "<td>".$array_of_tweets[$i]->tweet."</td>";
				echo"</tr>";
			
			}
				
		}
	
	?>
</table>