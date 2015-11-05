<?php
	require_once("../config_global.php");
	$database = "if15_Jork";
	
	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT picture, rating, comment FROM pildid WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($picture, $rating, $comment);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->picture =$picture;
			$review->rating=$rating;
			$review->comment=$comment;
			
			
		}else{
			header("Location:table.php");
		}
		return $review;
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $picture, $rating, $comment){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE ravimid SET picture=?, rating=?, comment=? WHERE id=?");
		$stmt->bind_param("sssi", $picture, $rating, $comment, $id);
		if($stmt->execute()){
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
?>