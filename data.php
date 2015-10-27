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
	
	$title = $note = "";
	$title_error = $note_error = "";
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_title"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["title"]) ) {
			$title_error = "See väli on kohustuslik";
		}else{
			$title = cleanInput($_POST["title"]);
		}
		
		if ( empty($_POST["note"]) ) {
			$note_error = "See väli on kohustuslik";
		}else{
			$note = cleanInput($_POST["note"]);
		}
		
		// mõlemad on kohustuslikud
		if($note_error == "" && $title_error == ""){
			//salvestate ab'i fn kaudu addNote
			//message funktioonist
			$message = addNote($title, $note);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$title = "";
				$note = "";
				
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
	<label for="title" >Pealkiri</label><br>
	<input id="title" name="title" type="text" value="<?php echo $title; ?>"> <?php echo $title_error; ?><br><br>
	<label for="note">Märkus</label><br>
	<input id="note" name="note" type="text" value="<?php echo $note; ?>"> <?php echo $note_error; ?><br><br>
	<input type="submit" name="add_note" value="Salvesta">
</form>