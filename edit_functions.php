<?php
	
	require_once("../config_global.php");
	$database = "if15_mikkmae";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT location, date, feedback, grade FROM review WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($location, $date, $feedback, $grade);
		$stmt->execute();
		
		//object
		$review = new StdClass();
		
		// kas sain ühe rea andmeid kätte
		//$stmt->fetch() annab ühe rea andmeid
		if($stmt->fetch()){
			//sain
			$review->location = $location;
			$review->date = $date;
			$review->feedback = $feedback;
			$review->grade = $grade;
			
		}else{
			// ei saanud
			// id ei olnud olemas, id=123123123
			// rida on kustutatud, deleted ei ole NULL
			header("Location: table.php");
		}
		
		return $review;
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	
	function updateReview($id, $location, $date, $feedback, $grade){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE review SET location=?, date=?, feedback=?, grade=? WHERE id=?");
		$stmt->bind_param("ssssi", $location, $date, $feedback, $grade, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
?>