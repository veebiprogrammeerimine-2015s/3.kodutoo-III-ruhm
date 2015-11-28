<?php
	require_once("../configglobal.php");
	$database = "if15_arkadi_3";
	
	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT footballer, rating, comment FROM jalgpallurid WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($footballer, $rating, $comment);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->footballer =$footballer;
			$review->rating=$rating;
			$review->comment=$comment;
			
			
		}else{
			header("Location:table.php");
		}
		return $review;
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $footballer, $rating, $comment){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE jalgpallurid SET footballer=?, rating=?, comment=? WHERE id=?");
		$stmt->bind_param("sssi", $footballer, $rating, $comment, $id);
		if($stmt->execute()){
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
?>
