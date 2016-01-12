<?php

	require_once("../config_global.php");
	$database = "if15_mkoinc_3";

function getEditData($edit_id){
	
	
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT product, product_material FROM Orders WHERE id=? AND deleted IS NULL");
	$stmt->bind_param("i", $edit_id);
	$stmt->bind_result($product, $product_material);
	$stmt->execute();
	
	$Client = new StdClass();
	
	//kas sain ühe rea andmeid kätte
	if($stmt->fetch()){
		//sain
		$Client->product = $product;
		$Client->product_material = $product_material;
		
		
	}else{
		//ei saanud

		header("Location: table.php");
		
	}
		return $Client;
		$stmt->close();
		$mysqli->close();

}


function updateOrders($id, $product, $product_material){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE Orders SET product=?, product_material=? WHERE id=?");
		$stmt->bind_param("ssi", $product, $product_material, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
}

?>