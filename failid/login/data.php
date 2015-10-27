 <?php
 
	require_once("functions.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
	$number_plate=$color="";
	$number_plate_error=$color_error="";
	
	if(isset($_POST["add_plate"])){
		if ( empty($_POST["number_plate"]) ) {
				$number_plate_error = "Sa ei kirjutanud auto numbrit.";
			}else{
				$number_plate = cleanInput($_POST["number_plate"]);
			}
			
			if ( empty($_POST["color"]) ) {
				$color_error = "Sa ei kirjutanud värvi sisse.";
			}else{
				$color = cleanInput($_POST["color"]);
			}

			if($number_plate_error == "" && $color_error == ""){
				echo "Panen kirja numbri, ".$number_plate.", ja värvi ".$color.". ";
				
				$message = addCarPlate($_SESSION["logged_in_user_id"], $number_plate, $color);
				
				if($message != ""){
					$number_plate = "";
					$color = "";
					
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
 
 <h2>Lisa autonumbri märk.</h2>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="number_plate">Auto numbrimärk</label><br>
  	<input id="number_plate" name="number_plate" type="text" value="<?php echo $number_plate; ?>"> <?php echo $number_plate_error; ?><br><br>
	<label for="color">Värv</label><br>
  	<input id="color" name="color" type="text" value="<?php echo $color; ?>"> <?php echo $color_error; ?><br><br>
  	<input type="submit" name="add_plate" value="Salvesta">
 </form>
 </html>