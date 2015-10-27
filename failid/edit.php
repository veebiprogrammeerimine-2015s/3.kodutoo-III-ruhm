<?php

	require_once("functions.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isset($_POST["update_armor"])){
		
		updateArmor($_POST["id"], $_POST["armor_type"], $_POST["armor_race"], $_POST["armor_color"]);
		
	}
	
	if(isset($_GET["edit_id"])){
		
		echo $_GET["edit_id"];
		
		$armor = getEditData($_GET["edit_id"]);
		
	}else{
		
		echo "Viga";

		header("Location: table.php");
		
	}
?>

<h2>Muuda armori soovitust.</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?php echo $_GET["edit_id"]?>">
	<label for="armor_type">Armori tüüp</label><br>
	<input id="armor_type" name="armor_type" type="text" value="<?=$armor->type;?>"><br><br>
	<label for="armor_race">Armorit kandev rass</label><br>
	<input id="armor_race" name="armor_race" type="text" value="<?=$armor->race;?>"><br><br>
	<label for="armor_color">Armori värv</label><br>
	<input id="armor_color" name="armor_color" type="text" value="<?=$armor->color;?>"><br><br>
	<input type="submit" name="update_armor" value="Salvesta">
</form>
