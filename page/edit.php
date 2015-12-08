<?php


require_once("edit_functions.php");

if(isset($_POST["update_place"])){
	
	
	updatePlace($_POST["id"],$_POST["location"],$_POST["condition"],$_POST["description"],$_POST["date_visited"]);
	}
	//aadressrireal on ?edit_id siis tr�kin v�lja selle v��rtuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		//id oli aadressireal
		//tahaks ühte rida kõige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$place=getEditData($_GET["edit_id"]);
		var_dump($place);
		
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
	<label for="date_visited">Külastuse kuupäev</label><br>
	<input id="date_visited" name="date_visited" type="date" value="<?php echo $date_visited;?>"><br><br>
	<input name="update_place" type="submit" value="Salvesta">
</form>