<?php

	require_once("../config_global.php");
	$database = "if15_raoulk";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT boot_brand, model FROM football WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($number_plate, $color);
		$stmt->execute();
		
		$boot = new StdClass();
		
		//kas sain he rea andmeid kätte
		//stmt->fetch annab ühe rea andmeid
		if($stmt->fetch()){
			//sain
			$boot->boot_brand = $boot_brand;
			$boot->model = $model;
			
		}else{
			//ei saanud
			//id ei olnud olemas, id=1231231231
			//rida on kustutatud, deleted ei ole NULL
			header("Location:table.php");
		}
		
		return $boot;
		
	
		$stmt->close();
		$mysqli->close();
		
		
	}
	
	function updateCar($id, $boot_brand, $model){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE football SET boot_brand=?, model=? WHERE id=?");
		$stmt->bind_param("ssi", $boot_brand, $model, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
?>