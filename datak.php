<?php
	require_once("functionsk2.php");

	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$medicine ="";
	$rating = "";
	$comment = "";
	$medicine_error = "";
	$rating_error = "";
	$comment_error = "";

		
	if(isset($_POST["add_review"])){
		if ( empty($_POST["medicine"]) ) {
				$medicine_error = "See väli on kohustuslik";
			}else{
				//kõik korras, test_input eemaldab pahatahtlikud osad
				$medicine = test_input($_POST["medicine"]);
				}
	

		if ( empty($_POST["rating"]) ) {
				$rating_error = "See väli on kohustuslik";
			}else{
				//kõik korras, test_input eemaldab pahatahtlikud osad
				$rating = test_input($_POST["rating"]);
				}
				
		if ( empty($_POST["comment"]) ) {
				$comment_error = "See väli on kohustuslik";
			}else{
				//kõik korras, test_input eemaldab pahatahtlikud osad
				$comment = test_input($_POST["comment"]);
				}
				
		//kõik on kohustuslikud
		if($medicine_error == "" && $rating_error == "" && $comment_error == ""){
			//salvestate ab'i fn kaudu addReview
			//message funktsioonist
			
			$message = addReview($medicine, $rating, $comment);
			if($message != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$medicine = "";
				$rating = "";
				$comment = "";
				
				echo $message;
			}
		}
	}
	if(isset($_GET["logout"])){
		//sessiooni peatus
		session_destroy();
		
		header("Location: login.php");
	}
	
	function test_input($data) {	
		$data = trim($data);	//võtab ära tühikud,enterid,tabid
		$data = stripslashes($data);  //võtab ära tagurpidi kaldkriipsud
		$data = htmlspecialchars($data);	//teeb htmli tekstiks, nt < läheb &lt
		return $data;
	}
?>

<p>Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja <a>
</p>
<link rel="stylesheet" type="text/css" href="minukujundus.css">	
<h2>Lisa arvustus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<label for ="medicine">Kirjuta ravimi nimi</label><br>
		<input id="medicine" name="medicine" type="text" value="<?php echo $medicine; ?>" > <?php echo $medicine_error; ?><br><br>
		<label for ="rating">Määra rating</label><br>
		
		<input id="rating" type="radio" value="1" name="rating"  > 1
		<input id="rating" type="radio" value="2" name="rating"  > 2
		<input id="rating" type="radio" value="3" name="rating"  > 3
		<input id="rating" type="radio" value="4" name="rating"  > 4
		<input id="rating" type="radio" value="5" name="rating"  > 5

		<br><br>
		<label for ="comment">Kirjuta comment</label><br>
		<textarea id="comment" name="comment" col=40 rows=8 placeholder="Kirjuta siia oma comment" value="<?php echo $comment; ?>"> <?php echo $comment_error; ?> </textarea><br><br>
		<input type="submit" name="add_review" value="Sisesta"><br>
		</form>	