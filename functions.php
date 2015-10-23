<?php 

	// Loon andmebaasi ühenduse
	require_once("../../config_global.php");
	$database = "if15_martin";
	
	// tekitakse sessioon, mida hoitakse serveris 
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();

	// võtab andmed ja sisestab andmebaasi
	function createUser($reg_username, $reg_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt =  $mysqli->prepare("INSERT INTO martin_login2 (email, username, password) VALUES (?,?,?)");
		$stmt->bind_param("sss", $reg_email, $reg_username, $hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function loginUser($username, $email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, username FROM martin_login WHERE email=? AND username=? AND password=?");
		$stmt->bind_param("sss",$email, $username, $hash);
		$stmt->bind_result($id_from_db, $username_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			//andmebaasis oli midagi
			echo "Email, username ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_username"] = username_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Valed andmed!";
		}
			
		$stmt->close();
			
		$mysqli->close();
		
	}
	
	//Kuigi muutujad on erinevad, jõuab väärtus kohale
	function addThread($in_thread, $in_post){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt =  $mysqli->prepare("INSERT INTO martin_threads (user_id, thread, post) VALUES (?,?,?)");
				echo $mysqli->error;

		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"],$in_thread, $in_post);
		
		//sõnum
		$message = "";
		
		if($stmt->execute()){
			// kui on tõene
			// siis INSERT õnnestus
			$message = "Successfully added";
			
				
		}else{
			// Kui on väärtus FALSE
			// siis kuvame errori
			echo $stmt->error;
			
		}
		
		return $message;
		
		
		echo $stmt->error;
		$stmt->close();
		
		$mysqli->close();

	}

	function deleteCar($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE martin_threads SET deleted=NOW() WHERE id=?");
		
		$stmt->bind_param("i", $id);
		
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	function updateCar($id, $number_plate, $color);
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE martin_threads SET thread=?, post=? WHERE id=?");
		
		$stmt->bind_param("ssi", $thread, $post, $id);
		
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			//header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	
?>