<?php


require_once("edit_functions.php");

if(isset($_POST["update_place"])){
	//vajutas salvesta nuppu
	//number plate ja color tulevad vormist aga id aadressirealt
	
	updatePlace($_POST["id"],$_POST["location"],$_POST["condition"],$_POST["description"],$_POST["date_visited"]);
	}
	//aadressrireal on ?edit_id siis trükin välja selle väärtuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		//id oli aadressireal
		//tahaks Ã¼hte rida kÃµige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$car=getEditData($_GET["edit_id"]);
		var_dump($car);
		
		}else{
		//ei olnud aadressireal
		echo "Viga";
		//die - edasi lehte ei laeta
		//die();
		//header("Location:table.php");
	}

?>

<h2>Muuda kirjeid</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<label for="location">Asukoht</label><br>
	<input id="location" name="location" type="text"  value="<?php echo $location; ?>"><br><br>
	<label for="condition">Olukord</label><br>
	<input id="condition" name="condition" type="text" value="<?php echo $condition;?>"><br><br>
	<label for="descrption">Kirjeldus</label><br>
	<input id="description" name="description" type="text" value="<?php echo $description;?>"><br><br>
	<label for="date_visited">KÃ¼lastuse kuupÃ¤ev</label><br>
	<input id="date_visited" name="date_visited" type="date" value="<?php echo $date;?>"><br><br>
	<input name="update_place" type="submit" value="Salvesta">
</form>