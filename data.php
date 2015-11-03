<?php
	require_once("functions.php");
	// data.php
	
	// kui kasutaja ei ole sisseloginud,
	// siis suunan tagasi
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	$picture = "";
	$rating = "";
	$comment = "";
	$picture_error = "";
	$rating_error = "";
	$comment_error = "";
	
	
	//keegi vajutas nuppu
	if(isset($_POST["add_review"])){
		// echo $_SESSION["logged_in_user_id"];

		if ( empty($_POST["picture"]) ) {
				$picture_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$picture = cleanInput($_POST["picture"]);
			}
		if ( empty($_POST["rating"]) ) {
				$rating_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$rating = cleanInput($_POST["rating"]);
			}
		if ( empty($_POST["comment"]) ) {
				$comment_error = "See väli on kohustuslik";
			}else{
				
				$comment = cleanInput($_POST["comment"]);
				}
				
		if($picture_error == "" && $rating_error == "" && $comment_error == ""){
					
					
					
					// kasutaja loomise funktsioon, failist functions.php
					// saadame kaasa muutujad
					$message = addReview($picture, $rating, $comment);
					
					if($message != ""){
						// õnnestus, teeme inputi väljad tühjaks
						$picture = "";
						$rating = "";
						$comment = "";
						
						echo $message;
						
					}
				}
	}
		// kasutaja tahab välja logida
	
	if(isset($_GET["logout"])){
		// aadressireal on olemas muutuja logout
		
		//kustutame kõik sessoni muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1">logi välja<a>	
</p>

<h2>Lisa arvustus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<label for ="Picture">Mis on pildi nimi</label><br>
		<input id="picture" name="picture" type="text" value="<?php echo $picture; ?>" > <?php echo $picture_error; ?><br><br>
		<label for ="rating">Määra rating</label><br>
		
		<input id="rating" type="radio" value="1" name="rating"  > 1
		<input id="rating" type="radio" value="2" name="rating"  > 2
		<input id="rating" type="radio" value="3" name="rating"  > 3
		<input id="rating" type="radio" value="4" name="rating"  > 4
		<input id="rating" type="radio" value="5" name="rating"  > 5

		<br><br>
		<label for ="comment">Kirjuta kommentaar</label><br>
		<textarea id="comment" name="comment" col=40 rows=8 placeholder="Kirjuta siia oma kommentaar" value="<?php echo $comment; ?>"> <?php echo $comment_error; ?> </textarea><br><br>
		<input type="submit" name="add_review" value="Sisesta"><br>
		</form>	