<?php 
	
	require_once("../config_global.php");
	$database = "if15_mikkmae";
	
	
	function getCarData($keyword=""){
		
		echo "Otsin ".$keyword;	
		
		$search = "%%";
		
		if($keyword == ""){
			// ei otsi midagi
			echo "Ei otsi midagi";
			
			
		}else{
			
			echo "Otsin ".$keyword;	
			$search = "%".$keyword."%";
		}
		
		
	
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color from car_plates WHERE deleted IS NULL AND (number_plate LIKE ? OR color LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $number_plate, $color);
		$stmt->execute();
		
		// tühi massiiv, kus hoian moose ja objekte
		$car_array = array();
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
				
			// tekitan objekti, kus hakkan hoitma oma moose ja väärtusi
			$car = new StdClass();
			$car->id=$id;
			$car->plate= $number_plate;
			$car->color=$color;
			$car->user=$user_id_from_database;
			
			//lisan massiivi ühe rea jurde
			array_push($car_array, $car);
			
			
			//echo "<pre>";
			//ütleb muutuja sisu ja tüübi **    var_dump($car_array);
			//echo "</pre><br>";
		}
		//tagastan massiivi, kus kõik asjad sees, read.
		return $car_array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	//käivitan funktsiooni
	function deleteCar($id) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()) {
			// sai kustutatud
			// kustutame adressirea tühjaks
			header("Location: table.php");
			
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	
	function updateCar($id, $number_plate, $color) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if($stmt->execute()) {
			// sai uuendatud
			// kustutame adressirea tühjaks
			// header("Location: table.php");
			
			
		}
		$stmt->close();
		$mysqli->close();
		
		
		
		
	}
	
	
?>