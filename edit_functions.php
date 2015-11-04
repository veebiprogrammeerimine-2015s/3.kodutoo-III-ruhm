<?php
	require_once("../config_global.php");
	$database = "if15_Harri_3";
	
	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT exam, grade, mistakes FROM eksam WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($exam, $grade, $mistakes);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->exam =$exam;
			$review->grade=$grade;
			$review->mistakes=$mistakes;
			
			
		}else{
			header("Location:data.php");
		}
		return $review;
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $exam, $grade, $mistakes){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE eksam SET exam=?, grade=?, mistakes=? WHERE id=?");
		$stmt->bind_param("sssi", $exam, $grade, $mistakes, $id);
		if($stmt->execute()){

			
		}
		$stmt->close();
		$mysqli->close();
		
	}

?>