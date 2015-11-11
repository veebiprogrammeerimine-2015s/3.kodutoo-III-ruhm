<?php
require_once("functions.php");

	//kui kasutaja on sisse loginud siis suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	
	
	//kasutaja tahav välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutjua logout
		
		//kustutame kõik session muutjuad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	
	$product = $product_material = "";
	$product_error = $product_material_error = "";
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_product"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["product"]) ) {
			$product_error = "See väli on kohustuslik";
		}else{
			$product = cleanInput($_POST["product"]);
		}
		
		if ( empty($_POST["product_material"]) ) {
			$product_material_error = "See väli on kohustuslik";
		}else{
			$product_material = cleanInput($_POST["product_material"]);
		}
		
		// mõlemad on kohustuslikud
		if($product_material_error == "" && $product_error == ""){
			//salvestate ab'i fn kaudu addCarPlate
			// message funktsioonist
			$msg = addClient($product, $product_material);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$product = "";
				$product_material = "";
				
				echo $msg;
				
			}
			
		}
		
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>


<h2>Lisa oma tellimus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="product" >Toode</label><br>
	<input id="product" name="product" type="text" value="<?php echo $product; ?>"> <?php echo $product_error; ?><br><br>
	<label for="product_material">Toote materjal</label><br>
	<input id="product_material" name="product_material" type="text" value="<?php echo $product_material; ?>"> <?php echo $product_material_error; ?><br><br>
	<input type="submit" name="add_product" value="Salvesta">
</form>