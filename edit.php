<?php
		
		require_once("edit_functions.php");
		
		//edit.php
		// adressi real on ?edit_id siis trükin välja selle väärtuse?!
		if(isSet($_GET["edit_id"])) {
			
		echo $_GET["edit_id"] ;
		
		// id oli aadressireal
		// tahaks ühte rida kõige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$car = getEditData($_GET["edit_id"]);
		//var_dump($car);
		
		}else{
			
			//ei olnud aadressireal
			echo "Viga";
			// ****edasi lehte ei laeta
			// die();
			//suuname kasutaja table.php lehele
			header("Location: table.php");
			
		}
		
		if(isSet($_POST["update_plate"])) {
			// vajutas muuda nuppu
			// plate ja color tulevad vormist, id tuleb adressirealt
			updateCar($_POST["id"], $_POST["number_plate"], $_POST["color"]);
			
		}


?>


<h2>Lisa autonumbrimärki</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>
	<label for="number_plate" >Auto numbrimärk</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?=$car->number_plate;?>"> <br><br>
	<label for="color">Värv</label><br>
	<input id="color" name="color" type="text" value="<?=$car->color;?>"> <br><br>
	<input type="submit" name="update_plate" value="Muuda">
</form>