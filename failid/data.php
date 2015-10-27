 <?php
 
	require_once("functions.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
	$armor_type=$armor_race=$armor_color="";
	$armor_type_error=$armor_race_error=$armor_color_error="";
	
	if(isset($_POST["add_armor"])){
		if ( empty($_POST["armor_type"]) ) {
				$armor_type_error = "Sa ei kirjutanud armori tüüpi.";
			}else{
				$armor_type = cleanInput($_POST["armor_type"]);
			}
			
			if ( empty($_POST["armor_race"]) ) {
				$armor_race_error = "Sa ei kirjutanud mis rassile pakutud armor sobiks.";
			}else{
				$armor_race = cleanInput($_POST["armor_race"]);
			}
			
			if ( empty($_POST["armor_color"]) ) {
				$armor_color_error = "Sa ei kirjutanud armori värvi sisse.";
			}else{
				$armor_color = cleanInput($_POST["armor_color"]);
			}

			if($armor_type_error == "" && $armor_race_error=="" && $armor_color_error == ""){
				echo "Panen kirja armori tüübi, ".$armor_type.", rassi, ".$armor_race.", millele see armor sobiks ja armori värvi ".$armor_color.". ";
				
				$message = addArmor($_SESSION["logged_in_user_id"], $armor_type, $armor_race, $armor_color);
				
				if($message != ""){
					$armor_type = "";
					$armor_race = "";
					$armor_color = "";
					
					echo $message;
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
 <html>
 <p>Tere, <?php echo $_SESSION["logged_in_user_email"];?> <a href="?logout=1">Logi välja<a>.</p>
 
 <h2>Soovita uus armor.</h2>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="armor_type">Armori tüüp</label><br>
  	<input id="armor_type" name="armor_type" type="text" value="<?php echo $armor_type; ?>"> <?php echo $armor_type_error; ?><br><br>
	<label for="armor_race">Armori kandja rass</label><br>
  	<input id="armor_race" name="armor_race" type="text" value="<?php echo $armor_race; ?>"> <?php echo $armor_race_error; ?><br><br>
	<label for="armor_color">Armori värv</label><br>
  	<input id="armor_color" name="armor_color" type="text" value="<?php echo $armor_color; ?>"> <?php echo $armor_color_error; ?><br><br>
  	<input type="submit" name="add_armor" value="Salvesta">
 </form>
 </html>