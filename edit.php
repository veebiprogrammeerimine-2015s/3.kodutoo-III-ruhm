<?php

require_once("edit_functions.php");
	$product = "";
	$product_material = "";

if(isset($_POST["update_product"])){
		//vajutas salvesta nuppu
		
		updateClient($_GET["id"],$_POST["product"], $_POST["product_material"]);
		
	}

if(isset($_GET["edit_id"])){
echo $_GET["edit_id"];


	$Client = getEditData($_GET["edit_id"]);
	var_dump($Client);
	
	
}else{
	
	//ei ole aadressireal
	echo "VIGA";
	//die - edasi lehte ei laeta
	//die();
	
	//suuname kasutaja table.php lehele
	header("Location: table.php");
}




?>

<h2>Lisa oma tellimus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>"
	<label for="product" >Toode</label><br>
	<input id="product" name="product" type="text" value="<?=$Client->product;?>"><br><br>
	<label for="product_material">Toote materjal</label><br>
	<input id="product_material" name="product_material" type="text" value="<?=$Client->product_material;?>"><br><br>
	<input type="submit" name="add_product" value="Salvesta">
</form>

