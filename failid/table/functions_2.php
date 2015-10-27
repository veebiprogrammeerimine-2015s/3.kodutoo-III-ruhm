<?php
	require_once("../config_global.php");
	$database = "if15_janekos_3";
	
	function getCarData($keyword=""){
		
		$search = "%%";
		
		if($keyword == ""){
			echo "Ei otsi.";
		}else{
			echo "Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color FROM car_plates WHERE deleted IS NULL AND (number_plate LIKE ? OR color LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $number_plate, $color);
		$stmt->execute();
		$car_array = array();
		while($stmt->fetch()){
			$car = new StdClass();
			$car->id = $id;
			$car->user = $user_id_from_database;
			$car->plate = $number_plate;
			$car->color = $color;
			array_push($car_array, $car);
			//echo "<pre>";
			//var_dump($car_array);
			//echo "<pre>";
		}
		return $car_array;
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteCar($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if ($stmt->execute()){
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function updateCar($id, $number_plate, $color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if ($stmt->execute()){
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}

?>