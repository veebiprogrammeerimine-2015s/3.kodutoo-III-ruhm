<?php
	require_once("functions.php");
	// data.php
	
	// kui kasutaja ei ole sisseloginud,
	// siis suunan tagasi
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	// kasutaja tahab välja logima
	
	if(isset($_GET["logout"])){
		// aadressireal on olemas muutuja logout
		
		//kustutame kõik sessoni muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$teamname = $summa = "";
	$teamname_error = $summa_error = "";
	
	//keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_bet"])){
		// echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		// mõlemad on kohustuslikud
		// salvestatakse AB'i fn kaudu addCarPlate
		if ( empty($_POST["teamname"]) ) {
				$teamname_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$teamname = cleanInput($_POST["teamname"]);
			}
		if ( empty($_POST["summa"]) ) {
				$summa_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$summa = cleanInput($_POST["summa"]);
			}
		if(	$teamname_error == "" && $summa_error == ""){
					
					
					
					// kasutaja loomise funktsioon, failist functions.php
					// saadame kaasa muutujad
					$message = addBet($teamname, $summa);
					
					if($message != ""){
						// õnnestus, teeme inputi väljad tühjaks
						$number_plate = "";
						$color = "";
						
						echo $message;
						
					}
				}
	}
	

	
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1">logi välja<a>	
</p>

  <h2>Place your bets</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="teamname">Tiiminimi</label><br>
	<input id="teamname" name="teamname" type="text" value="<?php echo $teamname; ?>"> <?php echo $teamname_error; ?><br><br>
	<label for="summa">Summa</label><br>
  	<input id="summa" name="summa" type="float" value="<?php echo $summa; ?>"> <?php echo $summa_error; ?><br><br>
  	<input type="submit" name="add_bet" value="Salvesta">
  </form>