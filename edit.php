<?php


	require_once("edit_functions.php");
	
	//edit.php
	//aadressireal on ?edit_id siis trukin valja selle vaartuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		
		//id oli adressireal
		//tahaks uhte rida koige uuemaid andmeid kus id on $_GET["edit.php"]
		$note = getEditData($_GET["edit_id"]);
		var_dump($note);
		
	}else{
		//ei olnud adressireal
		echo "Viga";
		//die - edasi lehte ei laeta
		//die();
		
		//suuname kasutaja table.php lehele
		header("Location: table.php");
		
	}

	if(isset($_POST["update_note"])){
		//vajutas salvesta nuppu
		//number_plate ja color tulevad vormist
		//aga id aadresirealt
		
		updateNote($_POST["id"], $_POST["pealkiri"], $_POST["märkus"]);
		
		
	}

?>

<h2>Muuda märkuse</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?$_GET["edit_id"];?>">
	<label for="pealkiri" >Pealkiri</label><br>
	<input id="pealkiri" name="pealkiri" type="text" value="<?=$note->pealkiri;?>"><br><br>
	<label for="märkus">Märkus</label><br>
	<input id="märkus" name="märkus" type="text" value="<?=$note->märkus;?>"><br><br>
	<input type="submit" name="update_note" value="Salvesta">
</form>