<?php
	
	require_once("edit_functions.php");
	
	
	if(isset($_POST["update_plate"])){
		
		updateContent($_POST["id"], $_POST["title"], $_POST["media"]);
		
	}
	
	//edit.php
	// aadressireal on ?edit_id siis trükin välja selle väärtuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		
		// id oli aadressireal
		// tahaks ühte rida kõige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$content = getEditData($_GET["edit_id"]);
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

<h2>Muuda postitust</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
	<label for="title" >Tiitel</label><br>
	<input id="title" name="title" type="text" value="<?=$car->title;?>"><br><br>
	<label for="media">Meedia</label><br>
	<input id="media" name="media" type="text" value="<?=$car->media;?>"><br><br>
	<input type="submit" name="update_plate" value="Salvesta">
</form>