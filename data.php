<?php
	require_once("functions.php");
	require_once("table.php");
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
	
	$animal = $animal_name = "";
	$animal_error = $animal_name_error = "";
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_animal"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["animal"]) ) {
			$animal_error = "See väli on kohustuslik";
		}else{
			$animal = cleanInput($_POST["animal"]);
		}
		
		if ( empty($_POST["animal_name"]) ) {
			$animal_name_error = "See väli on kohustuslik";
		}else{
			$animal_name = cleanInput($_POST["animal_name"]);
		}
		
		// mõlemad on kohustuslikud
		if($animal_name_error == "" && $animal_error == ""){
			//salvestate ab'i fn kaudu addAnimal
			// message funktsioonist
			$msg = addAnimal($animal, $animal_name);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$animal = "";
				$animal_name = "";
				
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


<h2>Lisa loom</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="animal" >Liik</label><br>
	<input id="animal" name="animal" type="text" value="<?php echo $animal; ?>"> <?php echo $animal_error; ?><br><br>
	<label for="name">Nimi</label><br>
	<input id="animal_name" name="animal_name" type="text" value="<?php echo $animal_name; ?>"> <?php echo $animal_name_error; ?><br><br>
	<input type="submit" name="add_animal" value="Salvesta">
</form>
