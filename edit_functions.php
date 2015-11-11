<?php

function getEditData($edit_id){
	
	
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT product, color FROM addClient WHERE id=? AND deleted IS NULL");
	$stmt->bind_param("i", $edit_id);
	$stmt->bind_result($product, $product_material);
	$stmt->execute();
	
	$car = new StdClass();
	
	//kas sain ühe rea andmeid kätte
	if($stmt->fetch()){
		//sain
		$car->product = $product;
		$car->product_material = $product_material;
		
		
	}else{
		//ei saanud
		//id ei olnud olemas, näiteks- id=123456
		//rida on kustutatud, deleted ei ole NULL
		header("Location: table.php");
		
	}
}


function updateClient($id, $product, $product_material){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
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