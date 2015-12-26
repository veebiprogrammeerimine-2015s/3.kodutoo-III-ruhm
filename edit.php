<?php

	require_once("functions.php");
	
	if(isset($_POST["update_post"])){
		//vajutas salvesta nuppu
		//numberplate ja color tulevad vormist, aga id varjatud väljas
		updatePost($_POST["id"], $_POST["tweet"]);
		
	}
	
	//edit.php
	//aadressireal on ?edit_id siis trükin välja selle väärtuse
	if(isset($_GET["edit_id"])){
			echo $_GET["edit_id"];
		
		//id oli aadressireal
		//tahaks ühte rida kõige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$post = getEditData($_GET["edit_id"]);
		var_dump($post);
		
	}else{
		//ei olnud aadressireal
		echo"Viga";
		//die - edasi lehte ei laeta
		//die();
		
		//suuname kasutaja table.php lehele
		header("Location: table.php");
	}
	
?>

<h2>Muuda postitusi</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
	<label for="tweet">Tweet:</label><br>
	<input name="tweet" id="tweet" type="text" value="<?$post->tweet;?>"> <br><br>
	<input name="update_tweet" type="submit" value="Salvesta"> 
</form>
