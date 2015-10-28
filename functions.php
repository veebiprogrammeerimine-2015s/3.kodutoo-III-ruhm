<?php
	// functions.php
	// siia tulevd funktsioonid, kõik mis seotud AB'ga
	
	// Loon AB'i ühenduse
	require_once("../config_global.php");
	$database = "if15_Jork";
	
	// tekitatakse sessioon, mida hoitakse serveris
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	function register($create_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, first_name, last_name) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $create_email, $hash, $first_name, $last_name);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		
	}
	
	function cleanInput($data) {
  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);
  	  return $data;
    }
	
	function login($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		//Kontrollin kas tulemusi leiti
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			// suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "valed kasutajatunnused";
		}
				
		$stmt->close();
		
		$mysqli->close();
		
	}
	
?>