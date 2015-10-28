<?php
require_once("functions.php");
$location = $condition = "";
$location_error = "";
$condition_error = "";
if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik sessiooni muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	
if(isset($_POST["add_plate"])){
			
		if (empty($_POST["location"])){
			$location_error = "see väli on kohustulik";	
		} else {
			$location=test_input($_POST["location"]);
		}
		if (empty($_POST["color"])){
			$condition_error = "see väli on kohustulik";
		} else {
			$condition=test_input($_POST["color"]);
		}
		if ($location_error = "" && $color_error = "" );
		
		$message=addCarPlate($location,$condition);
		
			if($message!=""){
				$location="";
				$condition="";
				echo $message;
		}
		
		
		
}
	
function test_input($data) {
	//võtab ära tühikud,enterid jne
	$data = trim($data);
	//võtab ära tagurpidi kaldkriipsud
	$data = stripslashes($data);
	//teeb html-i tekstiks
	$data = htmlspecialchars($data);
	return $data;
	}
	
?>
<p>
	Tere,<?php echo $_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja <a>
</p>
<h2>Lisa huvitav asukoht mida külastada</h2>
<form action="data.php" method="post">
			<label for="Location">Asukoht</label><br>
			<input id="Location" name="Location" type="text"  value="<?php echo $location; ?>"> <?php echo $location_error; ?><br><br>
			<label for="condition">Olukord</label><br>
			<input id="condition" name="condition" type="text" value="<?php echo $condition;?>"> <?php echo $condition_error; ?> <br><br>
			<label for="color">Värv</label><br>
			<input id="color" name="color" type="text" value="<?php echo $color;?>"> <?php echo $color_error; ?> <br><br>
			<input name="add_plate" type="submit" value="Salvesta"> 
		</form>