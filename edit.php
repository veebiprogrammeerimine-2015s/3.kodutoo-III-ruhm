<?php
	
	require_once("edit_functions.php");
	
	
	if(isset($_POST["update_plate"])){
		
		updateCar($_POST["id"], $_POST["number_plate"], $_POST["color"]);
		
	}
	
	//edit.php
	// aadressireal on ?edit_id siis trükin välja selle väärtuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		
		// id oli aadressireal
		// tahaks ühte rida kõige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$car = getEditData($_GET["edit_id"]);
		var_dump($car);
		
		
	}else{
		// ei olnud aadressireal 
		echo "VIGA";
		// die - edasi lehte ei laeta
		//die();
		
		//suuname kasutaja table.php lehele
		header("Location: table.php");
		
	}
	
	
	
?>

<h2>Muuda autonumbrimärkki</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
	<label for="number_plate" >Auto numbrimärk</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?=$car->number_plate;?>"><br><br>
	<label for="color">Värv</label><br>
	<input id="color" name="color" type="text" value="<?=$car->color;?>"><br><br>
	<input type="submit" name="update_plate" value="Salvesta">
</form>