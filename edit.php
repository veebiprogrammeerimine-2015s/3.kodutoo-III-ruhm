<?php
		
		require_once("edit_functions.php");
		
		//edit.php
		// adressi real on ?edit_id siis trükin välja selle väärtuse?!
		if(isSet($_GET["edit_id"])) {
			
		echo $_GET["edit_id"] ;
		
		// id oli aadressireal
		// tahaks ühte rida kõige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$review = getEditData($_GET["edit_id"]);
		//var_dump($car);
		
		}else{
			
			//ei olnud aadressireal
			echo "Viga";
			// ****edasi lehte ei laeta
			// die();
			//suuname kasutaja table.php lehele
			header("Location: table.php");
			
		}
		
		if(isSet($_POST["update_review"])) {
			// vajutas muuda nuppu
			// plate ja color tulevad vormist, id tuleb adressirealt
			updateReview($_POST["id"], $_POST["location"], $_POST["date"], $_POST["feedback"], $_POST["grade"]);
			
		}


?>

<body style="background-color:#0074D9; text-align:center">
<h2 style=color:#F8F8FF>Muuda arvustust</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>
	
	<label for="location">Koht/Teenus</label><br>
	<input id="location" name="location" type="text" value="<?=$review->location;?>"> <br><br>
	
	<label for="date">Kuupäev</label><br>
	<input id="date" name="date" type="text" value="<?=$review->date;?>"> <br><br>
	
	<label for="feedback">Tagasiside</label><br>
	<input id="feedback" name="feedback" type="text" value="<?=$review->feedback;?>"> <br><br>
	
	<label for="grade">Hinne 1-9</label><br>
	<input id="grade" name="grade" type="number" value="<?=$review->grade;?>"> <br><br>
	
	<input type="submit" name="update_review" value="Muuda">

	
	
	
	
	
</form>

</body>
