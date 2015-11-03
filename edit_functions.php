<?php

	require_once("../config_global.php");
	$database = "if15_helepuh_3";

//SEE OSA VEEL MUUTA
	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT animal, animal_name FROM animals WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($animal, $animal_name);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->animal=$animal;
			$review->animal_name=$animal_name;

			
		}else{
			header("Location:table.php");
		}
		return $review;
		$stmt->close();
		$mysqli->close();
		
	}
	
	function deleteAnimal($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE animals SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateAnimal($animal, $animal_name){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE animals SET animal=?, animal_name=? WHERE id=?");
		$stmt->bind_param("ssi", $animal, $animal_name);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
?>