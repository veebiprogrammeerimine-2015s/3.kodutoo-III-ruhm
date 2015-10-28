<?php
	require_once("../config_global.php");
	$database = "if15_earis_3";
	
	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT medicine, rating, comment FROM ravimid WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($medicine, $rating, $comment);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->medicine =$medicine;
			$review->rating=$rating;
			$review->comment=$comment;
			
			
		}else{
			header("Location:tablek.php");
		}
		return $review;
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $medicine, $rating, $comment){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE ravimid SET medicine=?, rating=?, comment=? WHERE id=?");
		$stmt->bind_param("sssi", $medicine, $rating, $comment, $id);
		if($stmt->execute()){

			
		}
		$stmt->close();
		$mysqli->close();
		
	}

?>