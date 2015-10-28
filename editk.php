<?php

	require_once("edit_functionsk.php");
	$rating = "";
	$comment = "";
	$comment_error = "";
	
	if(isset($_POST["update_review"])){
		//vajuta Salvesta nuppu
		//numberplate ja color tulevad vormist, aga id aadressirealt
		//aga id varjatud väljast
		updateReview($_POST["id"], $_POST["medicine"], $_POST["rating"], $_POST["comment"]);
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
		<label for ="medicine">Ravimi nimi</label><br>
		<input id="medicine" name="medicine" type="text" value="<?=$review->medicine;?>"><br><br>
		<label for ="rating"> Määra rating</label><br>
		<?php if($rating == 1) { ?>
			<input id="rating" type="radio" value="1" name="rating" checked >1
		<?php }else { ?>
			<input id="rating" type="radio" value="1"  name="rating" >1
		<?php } ?>
		
		<?php if($rating == 2) { ?>
			<input id="rating" type="radio" value="2" name="rating" checked >2
		<?php }else { ?>
			<input id="rating" type="radio" value="2"  name="rating" >2
		<?php } ?>
		
		<?php if($rating == 1) { ?>
			<input id="rating" type="radio" value="3" name="rating" checked >3
		<?php }else { ?>
			<input id="rating" type="radio" value="3"  name="rating" >3
		<?php } ?>
		
		<?php if($rating == 2) { ?>
			<input id="rating" type="radio" value="4" name="rating" checked >4
		<?php }else { ?>
			<input id="rating" type="radio" value="4"  name="rating" >4
		<?php } ?>
		
		<?php if($rating == 1) { ?>
			<input id="rating" type="radio" value="5" name="rating" checked >5
		<?php }else { ?>
			<input id="rating" type="radio" value="5"  name="rating" >5
		<?php } ?>
		

		<br><br>
		<label for ="comment">Kirjuta comment</label><br>
		<textarea id="comment" name="comment" col=40 rows=8 placeholder="Kirjuta siia oma comment" value="<?php echo $comment; ?>"> <?php echo $comment_error; ?> </textarea><br><br>
		<input type="submit" name="add_review" value="Sisesta"><br>
		</form>	