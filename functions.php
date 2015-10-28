<?php 
	
	require_once("../config_global.php");
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
	
	
?>