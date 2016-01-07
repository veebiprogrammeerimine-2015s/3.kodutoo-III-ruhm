<?php 
	require_once("edit_functions.php");
	
	if(isset($_POST["update_post"])){
		// vajutas salvesta nuppu
		// numberplate ja color tulevad vormist
		// aga id varjatud väljast
		updateDream($_POST["id"], $_POST["blog_post"]);
		
	}

	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
	
		//id oli aadressireal
		
		$dream = getEditData($_GET["edit_id"]);
		var_dump($blog);
	
	
	}else{
		echo "VIGA";
			//die - edasi lehte ei laeta
		//die();
		
		//suuname kasutaja table.php öeheöe
		header("Location: table.php");
		}
?>

<h2>Muuda unenägu</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
	<label for="blog_post" >Unenäo kirjeldus</label><br>
	<input id="blog_post" name="blog_post" type="text" value="<?=$dream->blog_post;?>"> <br><br>
	<input type="submit" name="update_post" value="Salvesta">
</form>