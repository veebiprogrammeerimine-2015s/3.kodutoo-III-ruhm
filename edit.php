<?php 
	require_once("edit_functions.php");

	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
	
		//id oli aadressireal
		
		$car = getEditData($_GET["edit_id"]);
		var_dump($car);
	
	
	}else{
		echo "VIGA";
			//die - edasi lehte ei laeta
		//die();
		
		//suuname kasutaja table.php öeheöe
		header("Location: table.php");
		}
	if(isset($_POST["update_plate"])){
		//vajutas salvesta nuppu
		//number_plate ja color tulevad vormist, aga id aadressirealt
		updateCar($_POST["id"],$POST["number_plate"], $_POST["color"]);
		
	}

?>

<h2>Muuda autonumbrimärkki</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label type="hidden" name="id" value="<?=$_GET["edit_id"];?>>
	<label for="number_plate" >Auto numbrimärk</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?=$car->number_plate;?>"> <br><br>
	<label for="color">Värv</label><br>
	<input id="color" name="color" type="text" value=""> <br><br>
	<input type="submit" name="update_plate" value="Salvesta">
</form>