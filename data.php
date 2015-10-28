<?php
	require_once("functions.php");
	//data
	//siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja on sisse loginud
	//siis suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kusutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$title = $media = "";
	$title_error = $media_error = "";
	
	
	if(isset($_POST["postMedia"])){
		echo "vajutati nuppu";
		if ( empty($_POST["title"]) ) {
				$title_error = "See väli on kohustuslik";
			}else{
				$title = cleanInput($_POST["title"]);
			}

			if ( empty($_POST["media"]) ) {
				$media_error = "See väli on kohustuslik";
			} else {
				
				$media = cleanInput($_POST["media"]);
				
			}
		if(	$title_error == "" && $media_error == ""){
			
			echo "Sisestatud!";
				
				
				postMedia($title, $media);
			
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
	Tere, <?=$_SESSION["logged_in_user_id"];?>
	<a href="?logout=1">Logi välja<a>
</p>


<h2>Lisa postitus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="title" >Tiitel</label><br>
  	<input name="title" id="title" type="text"  value="<?php echo $title; ?>"> <?php echo $title_error; ?><br><br>
	<label for="media" >Meedia</label><br>
  	<input name="media" type="text"  value="<?php echo $media; ?>"> <?php echo $media_error; ?><br><br>
  	<input type="submit" name="postMedia" value="Salvesta">
  </form>
  
  <a href="table.php">Vaata/Muuda postitusi</a>