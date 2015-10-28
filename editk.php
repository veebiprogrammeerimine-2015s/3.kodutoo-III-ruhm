<?php

	require_once("edit_functionsk.php");
	$hinnang = "";
	$kommentaar = "";
	$kommentaar_error = "";
	
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
		<label for ="hinnang"> Määra hinnang</label><br>
		<?php if($hinnang == 1) { ?>
			<input id="hinnang" type="radio" value="1" name="hinnang" checked >1
		<?php }else { ?>
			<input id="hinnang" type="radio" value="1"  name="hinnang" >1
		<?php } ?>
		
		<?php if($hinnang == 2) { ?>
			<input id="hinnang" type="radio" value="2" name="hinnang" checked >2
		<?php }else { ?>
			<input id="hinnang" type="radio" value="2"  name="hinnang" >2
		<?php } ?>
		
		<?php if($hinnang == 1) { ?>
			<input id="hinnang" type="radio" value="3" name="hinnang" checked >3
		<?php }else { ?>
			<input id="hinnang" type="radio" value="3"  name="hinnang" >3
		<?php } ?>
		
		<?php if($hinnang == 2) { ?>
			<input id="hinnang" type="radio" value="4" name="hinnang" checked >4
		<?php }else { ?>
			<input id="hinnang" type="radio" value="4"  name="hinnang" >4
		<?php } ?>
		
		<?php if($hinnang == 1) { ?>
			<input id="hinnang" type="radio" value="5" name="hinnang" checked >5
		<?php }else { ?>
			<input id="hinnang" type="radio" value="5"  name="hinnang" >5
		<?php } ?>
		

		<br><br>
		<label for ="kommentaar">Kirjuta kommentaar</label><br>
		<textarea id="kommentaar" name="kommentaar" col=40 rows=8 placeholder="Kirjuta siia oma kommentaar" value="<?php echo $kommentaar; ?>"> <?php echo $kommentaar_error; ?> </textarea><br><br>
		<input type="submit" name="add_review" value="Sisesta"><br>
		</form>	