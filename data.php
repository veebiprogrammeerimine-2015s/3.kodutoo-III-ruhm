<?php
	require_once("function.php");
	//data.php
	//siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud, siis suunan login.php lehele
	//kui kasutaja on sisseloginud; siis suunan data.php lehele
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
		
	$number_plate = $color = "";
	$number_plate_error = $color_error = "";
	
		if(isset($_POST["add_plate"])){
			
			if(empty($_POST["number_plate"]) ){
				$number_plate_error = " See väli on kohustuslik.";
			}else{
				$number_plate = cleanInput($_POST["number_plate"]);
			}
				
			if(empty($_POST["color"]) ){
				$color_error = " See väli on kohustuslik.";
			}else{
				$color = cleanInput($_POST["color"]);
			}
			
			if(	$number_plate_error == "" && $color_error == ""){
		
				$msg = addCarPlate($number_plate, $color);
				
				if($msg != ""){
					$number_plate = "";
					$color = "";
					echo "$msg";
					
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
<p>Tere,  <?php echo $_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja</a> 
	</p> 
	
	
<h2>Lisa pilt</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<label for="number_plate">Auto numbrimärk</label><br>
	<input name="number_plate" id="number_plate" type="text"  value="<?php echo $number_plate; ?>">* <?php echo $number_plate_error; ?> <br><br>
	<label for="color">Värv</label><br>
	<input name="color" type="text"  value="<?php echo $color; ?>">* <?php echo $color_error; ?> <br><br>
	<input name="add_plate" type="submit" value="Salvesta"> 
</form>
<?php
	// vaja väärtusi juurde lisada ning panna muudatused toimima
	// vaja salvestada muudatused andmebaasi
?>
<h2> Muuda andmeid</h2>
<form>
	<input name="user_email" type="email" placeholder="E-post"> <br><br>
	<input name="user_password" type="password" placeholder="Parool"> <br><br>
	<input name="lastname" type="text" placeholder="Perekonnanimi"> <br><br>
	<input name="firstname" type="text" placeholder="Eesnimi"> <br><br>
	<input name="update_user" type="submit" value="Salvesta"> <br><br>
 </form>



