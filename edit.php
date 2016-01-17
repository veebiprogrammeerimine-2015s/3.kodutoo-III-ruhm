<?php
	require_once("edit_functions.php");

	
	if(isset($_POST["update_review"])){
		updateboot($_POST["id"], $_POST["boot_brand"], $_POST["model"]);
	}
	
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		

		
		$footyboots = getEditData($_GET["edit_id"]);
		var_dump($footyboots);
		
	}else{
		//ei olnud aadressireal
		echo "VIGA";
		header("Location:table.php");
		
	}
	
	
?>

<h2>Change Boot</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>" > 
  	<label for="boot_brand" >Boot brand</label><br>
	<input id="boot_brand" name="boot_brand" type="text" value="<?php echo $footyboots->boot_brand;?>" ><br><br>
  	<label for="model" >Model</label><br>
	<input id="model" name="model" type="text" value="<?=$footyboots->model;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>