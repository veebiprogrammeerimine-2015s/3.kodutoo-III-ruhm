<?php

	//Loome ühenduse andmebaasiga
	require_once("../config_global.php");
	$database = "if15_earis_3";
	session_start();
	
	//hakkame andmeid andmebaasi sisestama (raviminimi, hinnang, kommentaar)
	function createUser($firstname, $lastname, $email2, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO users2 (email, password, firstname, lastname) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss", $email2, $hash, $firstname, $lastname);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	function loginUser($email1, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM users2 WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email1, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Email ja parool õiged, kasutaja id=" .$id_from_db;
			
			//tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan datak.php lehele
			header("Location: datak.php");
			
		}else{
			echo "Wrong credentials";
		}
		$stmt->close();
		$mysqli->close();
		
	} 
	function addReview($raviminimi, $hinnang, $kommentaar){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO ravimid (user_id, raviminimi, hinnang, kommentaar) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("isss", $_SESSION["logged_in_user_id"], $raviminimi, $hinnang, $kommentaar);
		
		//sõnum
		$message= "";
		
		if($stmt->execute()){
			//kui on tõene, INSERT õnnestus
			$message = "Sai edukalt lisatud";
			
			
		}else{
			//kui on väär, kuvame errori
			echo $stmt->error;
		}
		return $message;
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	//annan vaikeväärtuse
	function getReviewData($keyword=""){
		
		$search="%%";
		
		//kas otsisõna on tühi
		if($keyword==""){
			//ei otsi midagi
			//echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin " .$keyword;
			$search="%".$keyword."%";
			// "linex"
			// "%linex%"
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, raviminimi, hinnang, kommentaar FROM ravimid WHERE deleted IS NULL AND (raviminimi LIKE ?)");
		//echo $mysqli->error; //Unknown column 'deleted' in 'where clause' ??? - lahendatud
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $user_id, $raviminimi, $hinnang, $kommentaar);
		$stmt->execute();
		
		//tekitan tühja massiivi, kus edaspidi hoian objekte
		$review_array = array ();
		
		//tee midagi seni, kuni saame andmebaasist ühe rea andmeid
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu
			
			//tekitan objekti, kus hakkan hoidma väärtusi
			$review = new StdClass();
			$review->id = $id;
			$review->raviminimi =$raviminimi;
			$review->user_id=$user_id;
			$review->hinnang=$hinnang;
			$review->kommentaar=$kommentaar;
			//lisan massiivi ühe rea juurde
			
			array_push($review_array, $review);
			//var dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
			
		}
		//tagastan massiivi, kus kõik read sees
		return $review_array;
		
		$stmt->close();
		$mysqli->close();
		
	}
	function deleteReview($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE ravimid SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//sai kustutatud, kustutame aadressirea tühjaks
			header("Location: tablek.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $raviminimi, $hinnang, $kommentaar){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE ravimid SET raviminimi=?, hinnang=?, kommentaar=? WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("sssi", $raviminimi, $hinnang, $kommentaar, $id);
		if($stmt->execute()){
			//sai kustutatud, kustutame aadressirea tühjaks
			//header("Location: table.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	
	
?>