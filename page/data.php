<?php
	require_once("functions.php");
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
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
	
	$location = $date = $feedback = $grade = "";
	$location_error = $date_error =  $feedback_error = $grade_error = "";
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_review"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["location"]) ) {
			$location_error = "See väli on kohustuslik";
		}else{
			$location = cleanInput($_POST["location"]);
		}
		
		if ( empty($_POST["date"]) ) {
			$date_error = "See väli on kohustuslik";
		}else{
			$date = cleanInput($_POST["date"]);
		}
		
			if ( empty($_POST["feedback"]) ) {
			$feedback_error = "See väli on kohustuslik";
		}else{
			$feedback = cleanInput($_POST["feedback"]);
		}
		
			if ( empty($_POST["grade"]) ) {
			$grade_error = "See väli on kohustuslik";
		}else{
			$grade = cleanInput($_POST["grade"]);
		}
		
		// mõlemad on kohustuslikud
		if($location_error == "" && $date_error == "" && $feedback_error == "" &&  $grade_error == ""){
			//salvestan ab
			// message funktsioonist
			$msg = addReview($location, $date, $feedback, $grade);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$location = "";
				$date = "";
				$feedback = "";
				$grade = "";
				
				echo $msg;
				
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
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>


<h2>Lisa arvustus</h2>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	
	<label for="location" >Koha või teenusenimi</label><br>
	<input id="location" name="location" type="text" value="<?php echo $location; ?>"> <?php echo $location_error; ?><br><br>
	
	<label for="date">Kuupäev, ei pea olema täpne</label><br>
	<input id="date" name="date" type="text" value="<?php echo $date; ?>"> <?php echo $date_error; ?><br><br>
	
	<label for="feedback">Teie tagasiside/kogemus</label><br>
	<input id="feedback" name="feedback" type="text" value="<?php echo $feedback; ?>"> <?php echo $feedback_error; ?><br><br>
	
	<label for="grade">Hinne 1-9</label><br>
	<input id="grade" name="grade" type="number" value="<?php echo $grade; ?>"> <?php echo $grade_error; ?><br><br>
	<input type="submit" name="add_review" value="Lisa">
</form>
<a href="table.php"><h2 style=text-align:center>Loe teisi arvustusi</h2></a>



