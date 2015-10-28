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
	
	$blog_post = "";
	$blog_post_error = "";
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_post"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["blog_post"]) ) {
			$blog_post_error = "See väli on kohustuslik";
		}else{
			$blog_post = cleanInput($_POST["blog_post"]);
		}
		
		
		
		// mõlemad on kohustuslikud
		if($blog_post_error == ""){
			//salvestate ab'i fn kaudu addCarPlate
			$msg = addDream($blog_post);
			
			if($msg != ""){
				//õnnestus
				$blog_post = "";
				
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


<h2>Unenägude blogi</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="blog_post" >Kirjuta siia oma unenäost!</label><br>
	<input id="blog_post" name="blog_post" type="text" value="<?php echo $blog_post; ?>"> <?php echo $blog_post_error; ?><br><br>
	
	<input type="submit" name="add_post" value="Salvesta">
</form>