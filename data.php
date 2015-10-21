<?php
	require_once("functions2.php");
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: newfile.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: newfile.php");
	}
	
	$pealkiri = $märkus = "";
	$pealkiri_error = $märkus_error = "";
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_pealkiri"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["pealkiri"]) ) {
			$pealkiri_error = "See väli on kohustuslik";
		}else{
			$pealkiri = cleanInput($_POST["pealkiri"]);
		}
		
		if ( empty($_POST["märkus"]) ) {
			$märkus_error = "See väli on kohustuslik";
		}else{
			$märkus = cleanInput($_POST["märkus"]);
		}
		
		// mõlemad on kohustuslikud
		if($märkus_error == "" && $pealkiri_error == ""){
			//salvestate ab'i fn kaudu addNote
			//message funktioonist
			$message = addNote($pealkiri, $märkus);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$pealkiri = "";
				$märkus = "";
				
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


<h2>Lisa märkuse</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="pealkiri" >Pealkiri</label><br>
	<input id="pealkiri" name="pealkiri" type="text" value="<?php echo $pealkiri; ?>"> <?php echo $pealkiri_error; ?><br><br>
	<label for="märkus">Märkus</label><br>
	<input id="märkus" name="märkus" type="text" value="<?php echo $märkus; ?>"> <?php echo $märkus_error; ?><br><br>
	<input type="submit" name="add_note" value="Salvesta">
</form>