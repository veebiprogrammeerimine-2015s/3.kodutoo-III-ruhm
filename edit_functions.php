<?php 

	require_once("../config_global.php");
	$database = "if15_kar1ns";

	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT number_plate, color FROM car_plates WHERE id=? AND deleted IS NULL");
		echo $mysqli->error;
		$stmt->bind_param("i", $edit_id); //bind_param asendab küsimärgid (hetkel id)
		$stmt->bind_result($number_plate, $color); //võtab tabeli tlemused, () tuleb panna kõik mis on selecti järgi
		$stmt->execute();
		
		//object
		$car = new StdClass();
		
		if($stmt->fetch()){ //fetcf annab ühe re andmed
			$car->number_plate = $number_plate;
			$car->color = $color;
		}else{
			//ei saanud, id ei ole olemas
			//dlited ei ole 0
			header("Location: table.php");
		}
		return $car;
		
		$stmt->close();
		$mysqli->close();
	}

	function updateCar($id, $number_plate, $color){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if($stmt->execute()){
			//sai kustutatud
			header("Location: table.php");
	
		}
	}
	
?>