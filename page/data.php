<?php
require_once("functions.php");
$location = $condition = $description = $date_visited = "";
$location_error = "";
$condition_error = "";
$description_error = "";
$date_visited_error = "";
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
	
	
if(isset($_POST["add_place"])){
			
		if (empty($_POST["location"])){
			$location_error = "see väli on kohustulik";	
		} else {
			$location=test_input($_POST["location"]);
		}
		if (empty($_POST["condition"])){
			$condition_error = "see väli on kohustulik";
		} else {
			$condition=test_input($_POST["condition"]);
		}
		if (empty($_POST["description"])){
			$description_error = "see väli on kohustulik";	
		} else {
			$description=test_input($_POST["description"]);
		}
		if (empty($_POST["date_visited"])){
			$date_visited_error = "see väli on kohustulik";	
		} else {
			$date_visited=test_input($_POST["date_visited"]);
		}
		if ($location_error = "" && $color_error = "" && $description_error = "" && $date_visited_error = "");
		
		$message=addPlace($location,$condition,$description,$date_visited);
		
			if($message!=""){
				$location="";
				$condition="";
				$description="";
				$date_visited="";
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
<h2>Lisa huvitav koht mida külastada</h2>
<form action="data.php" method="post">
			<label for="location">Asukoht</label><br>
			<input id="location" name="location" type="text"  value="<?php echo $location; ?>"> <?php echo $location_error; ?><br><br>
			<label for="condition">Seisukord</label><br>
			<input id="condition" name="condition" type="text" value="<?php echo $condition;?>"> <?php echo $condition_error; ?> <br><br>
			<label for="descrption">Kirjeldus</label><br>
			<input id="description" name="description" type="text" value="<?php echo $description;?>"> <?php echo $description_error; ?> <br><br>
			<label for="date_visited">külastuse kuupäev</label><br>
			<input id="date_visited" name="date_visited" type="date" value="<?php echo $date_visited;?>"> <?php echo $date_visited_error; ?> <br><br>
			<input name="add_place" type="submit" value="Salvesta"> 
</form>