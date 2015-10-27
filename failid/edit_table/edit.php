<?php

	require_once("edit_functions.php");
	
	if(isset($_POST["update_plate"])){
		
		updateCar($_POST["id"],$_POST["number_plate"], $_POST["color"]);
		
	}
	
	if(isset($_GET["edit_id"])){
		
		echo $_GET["edit_id"];
		
		$car = getEditData($_GET["edit_id"]);
		var_dump($car);
		
	}else{
		
		echo "Viga";
		//die(); <- edasi lehte ei lae
		header("Location: table.php");
		
	}
?>

<h2>Muuda autonumbrimärkki.</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?php echo $_GET["edit_id"]?>">
	<label for="number_plate">Auto numbrimärk</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?=$car->plate;?>"><br><br>
	<label for="color">Värv</label><br>
	<input id="color" name="color" type="text" value="<?=$car->color;?>"><br><br>
	<input type="submit" name="update_plate" value="Salvesta">
</form>