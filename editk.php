<?php

	require_once("edit_functionsk.php");
	
	if(isset($_POST["update_review"])){
		//vajuta Salvesta nuppu
		//numberplate ja color tulevad vormist, aga id aadressirealt
		//aga id varjatud väljast
		updateReview($_POST["id"], $_POST["raviminimi"], $_POST["hinnang"], $_POST["kommentaar"]);
	}
	
	//aadressireal on=edit_id siis trükin välja selle väärtuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		
		//id oli aadressireal
		//tahaks ühte rida kõige uuemaid andmeid, kus id on $_GET["edit_id"]
		
		$review = getEditData($_GET["edit_id"]);
		var_dump($review);
		
	}else{
		//ei olnud aadressireal
		echo "VIGA";
		header("Location:tablek.php");
		
	}
	
	

?>

<h2>Muuda ravimi hinnagut</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
		<label for ="raviminimi">Ravimi nimi</label><br>
		<input id="raviminimi" name="raviminimi" type="text" value="<?=$review->raviminimi;?>"><br><br>
		<label for ="hinnang">Hinnang</label><br>
		<input id="hinnang" name="hinnang" type="text" value="<?=$review->hinnang;?>"> <br><br>
		<label for ="kommentaar">Kommentaar</label><br>
		<input id="kommentaar" name="kommentaar" type="text" value="<?=$review->kommentaar;?>"> <br><br>
		<input type="submit" name="update_review" value="Salvesta"><br>
		</form>	