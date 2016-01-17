<?php

	require_once("../config_global.php");
	$database = "if15_raoulk";



	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT boot_brand, model FROM footyboots WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($boot_brand, $model);
		$stmt->execute();
		
		$footyboots = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$footyboots->boot_brand = $boot_brand;
			$footyboots->model= $model;

			
		}else{
			header("Location:table.php");
		}
		
		return $footyboots;
		
		
		$stmt->close();
		$mysqli->close();
		

	}
	
	
	function updateboot($boot_brand, $model, $id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE footyboots SET boot_brand=?, model=? WHERE id=?");
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
