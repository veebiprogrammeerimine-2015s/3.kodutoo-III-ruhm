<?php
	//funktsioonid, mis on seotud andmebaasiga
	
	// loon andmebaasi ühenduse
	require_once("../config_global.php");
	$database = "if15_hendrik7";
	
	//tekitatakse sessioon, mida hoitakse serveris
	//kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	//võtab andmed ja sisestab andmebaasi
	function createUser($create_email, $hash){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
				
		// asendame ? märgid, ss - s on string email, s on string password
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
		
	}
	
	
	function loginUser($email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
				
		//muutujad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
				
			//kontrollin kas tulemusi leiti
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
				echo "wrong credentails!";
					
			}
				
		$stmt->close();
		$mysqli->close();
	}
	
	function addCarPlate($number_plate, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("iss",$_SESSION["logged_in_user_id"], $number_plate, $color);
		$stmt->execute();
		echo $stmt->error;
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	
	
?>