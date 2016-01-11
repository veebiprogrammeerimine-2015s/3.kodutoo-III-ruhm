<?php 
	
	require_once("../../config_global.php");
	$database = "if15_mikkmae";
	
	
	function getReviewData($keyword=""){
		
		//echo "Otsin ".$keyword;	
		
		$search = "%%";
		
		if($keyword == ""){
			// ei otsi midagi
			//echo "Ei otsi midagi";
			
			
		}else{
			
			echo "Otsin ".$keyword;	
			$search = "%".$keyword."%";
		}
		
		
	
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, location, date, feedback, grade from review WHERE deleted IS NULL AND (location LIKE ? OR date LIKE ? OR feedback LIKE ? OR grade LIKE ? )");
		$stmt->bind_param("ssss", $search, $search, $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $location, $date, $feedback, $grade);
		$stmt->execute();
		
		// tühi massiiv, kus hoian moose ja objekte
		$review_array = array();
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
				
			// tekitan objekti, kus hakkan hoitma oma moose ja väärtusi
			$review = new StdClass();
			$review->id=$id;
			$review->user_id=$user_id_from_database;
			$review->location= $location;
			$review->date=$date;
			$review->user=$user_id_from_database;
			$review->feedback=$feedback;
			$review->grade=$grade;
			
			//lisan massiivi
			
			array_push($review_array, $review);
			
			
			
		}
		//tagastan massiivi, kus kõik asjad sees, read.
		return $review_array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	//käivitan funktsiooni
	function deleteReview($id) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE review SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()) {
			// sai kustutatud
			// kustutame adressirea tühjaks
			header("Location: table.php");
			
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	
	function updateReview($id, $location, $date, $feedback, $grade) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE review SET location=?, date=?, feedback=?, grade=? WHERE id=?");
		$stmt->bind_param("ssssi", $location, $date, $feedback, $grade, $id);
		if($stmt->execute()) {
			// sai uuendatud
			// kustutame adressirea tühjaks
			// header("Location: table.php");
			
			
		}
		$stmt->close();
		$mysqli->close();
		
		
		
		
	}

	
	// Loon AB'i ühenduse
	require_once("../../config_global.php");
	$database = "if15_mikkmae";
	
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	// võtab andmed ja sisestab ab'i
	// võtame vastu 2 muutujat
	function createUser($create_email, $hash, $firstname, $lastname ){
		
		// Global muutujad, et kätte saada config failist andmed
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, first_name, last_name) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $create_email, $hash, $firstname, $lastname);
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
			echo "Vale email või parool!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	// fn sample
	function hello($name, $age){
		echo $name." ".$age;
	}
	
	
	// kuigi muuutujad on erinevad jõuab väärtus kohale
	function addReview($location, $date, $feedback, $grade) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO review (user_id, location, date, feedback, grade) VALUES (?,?,?,?,?)");
		$stmt->bind_param("issss", $_SESSION["logged_in_user_id"], $location, $date, $feedback, $grade);
		
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
	
?>
	
	

