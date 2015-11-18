<?php
	// Loon andmebaasi ühenduse
	require_once("../config_global.php");
	$database = "if15_henrrom";
	
	//tellitakse sessioon, mida hoitakse serveris.
	//kõik sessioni muutujad on kättesaadavad kuni viimase brauseri akna sulgemiseni.
	session_start();
	
	//võtab andmed ja sisestab andmebaasi
	function createUser($user_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare('INSERT INTO user_data (email, password) VALUES (?, ?)');
		// asendame küsimärgid. ss; s on string email, s on string password
		$stmt->bind_param("ss", $user_email, $hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}

	function loginUser($log_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM user_data WHERE email=? AND password=?");
		$stmt->bind_param("ss", $log_email, $hash);
		//muutujad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		//kontrolli, kas tulemus leiti
		if($stmt->fetch()){
			//ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;	
			
			//tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			//ei leidnud
			echo "wrong credentials";
		}			
		$stmt->close();
		$mysqli->close();	
	}
	
	function getCarData($keyword=""){
		$search = "%%";
		
		if($keyword == ""){
			//ei oti midagi
			echo "Ei otsi ";
		}else{
			//otsin
			echo"Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color from car_plates WHERE deleted IS NULL AND (number_plate LIKE ? OR color LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $number_plate, $color);
		$stmt->execute();
		
		//tekitan tühja massiivi, kus edaspidi hoian objekte 
		$car_array = array();
		
		//tee midagi seni, kuni saad ab'st ühe rea andmeid.
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu.
			
			//tekitan objekti; kus hakkan hoidma väärtusi
			$car = new StdClass();
			$car->id = $id;
			$car->user_id = $user_id_from_database;
			$car->plate = $number_plate;
			$car->color = $color;
			
			//lisan massiivi
			array_push($car_array, $car);
			//var_dump ütleb muutuja tüübi ja sisu
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
			//sai kustutatud
			//kustutame aadresirea tühjaks
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
			//sai uuendatud
			//kustutame aadresirea tühjaks
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}	
?>
?>