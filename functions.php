<?php 
	
	// Loon AB'i ühenduse
	require_once("../config_global.php");
	$database = "if15_helepuh_3";
	
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	// võtab andmed ja sisestab ab'i
	// võtame vastu 2 muutujat
	function createUser($create_email, $hash){
		
		// Global muutujad, et kätte saada config failist andmed
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);		
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	// fn sample
	function hello($name, $age){
		echo $name." ".$age;
	}
	
	//hello("Romil", 5);
	// kuigi muuutujad on erinevad jõuab väärtus kohale
	function addAnimal($animal, $animal_name) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO animals (user_id, animal, animal_name) VALUES (?,?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"], $animal, $animal_name);
		
		//sõnum
		$message = "";
		
		if($stmt->execute()){
			// kui on tõene,
			//siis INSERT õnnestus
			$message = "Sai edukalt lisatud";
			 
			
		}else{
			// kui on väärtus FALSE
			// siis kuvame errori
			echo $stmt->error;
			
		}
		
		return $message;
		
		
		$stmt->close();
		
		$mysqli->close();
		
		
	}
	
	//SEE OSA VEEL MUUTA
	function getAnimalData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, animal, animal_name from animals WHERE deleted IS NULL ");
		$stmt->bind_result($id, $user_id_from_database, $number_plate, $color);
		$stmt->execute();
		
		// tekitan tühja massiivi, kus edaspidi hoian objekte
		$car_array = array();
		
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
			// tekitan objekti, kus hakkan hoidma väärtusi
			$car = new StdClass();
			$car->id = $id;
			$car->plate = $number_plate;
			$car->user_id = $user_id_from_database;
			$car->color = $color;
			
			//lisan massiivi ühe rea juurde
			array_push($car_array, $car);
			//var dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus kõik read sees
		return $car_array;
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	function deleteCar($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateCar($id, $number_plate, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	
	
?>

?>