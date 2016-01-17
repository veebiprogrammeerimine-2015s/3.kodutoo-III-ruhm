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
 	
 	$boot_brand = "";
	$model = "";
	
	$boot_brand_error = "";
	$model_error = "";
 	
 	// keegi vajutas nuppu numbrimärgi lisamiseks
 	if(isset($_POST["add_boot"])){
 		
 		//echo $_SESSION["logged_in_user_id"];
 		
 		// valideerite väljad
 		if ( empty($_POST["boot_brand"]) ) {
 			$boot_brand_error = "This field is obligatory!";
 		}else{
 			$boot_brand = cleanInput($_POST["boot_brand"]);
 		}
 		
 		if ( empty($_POST["model"]) ) {
 			$model_error = "This field is obligatory!";
 		}else{
 			$model = cleanInput($_POST["model"]);
 		}
 		
 		// mõlemad on kohustuslikud
 		if($model_error == "" && $boot_brand_error == ""){
 			//salvestate ab'i fn kaudu addBoot
 			// message funktsioonist
 			$msg = addBoot($boot_brand, $model);
 			
 			if($msg != ""){
 				//õnnestus, teeme inputi väljad tühjaks
 				$boot_brand = "";
 				$model = "";
 				
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
 	Welcome, <?=$_SESSION["logged_in_user_email"];?> 
 	<a href="?logout=1"> Log out <a> 
 </p>
 
 <h2>Add your boot</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="boot_brand" >Boot brand</label><br>
	<input id="boot_brand" name="boot_brand" type="text" value="<?php echo $boot_brand; ?>"> <?php echo $boot_brand_error; ?><br><br>
	<label for="model">Model</label><br>
	<input id="model" name="model" type="text" value="<?php echo $model; ?>"> <?php echo $model_error; ?><br><br>
	<input name="add boot" type="submit" value="Save">
</form>

<a href="table.php">Look and Change Boots</a>