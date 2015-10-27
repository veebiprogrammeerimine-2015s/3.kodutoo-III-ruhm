<?php
	require_once("../config_global.php");
	$database = "if15_earis_3";
	
	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT raviminimi, hinnang, kommentaar FROM ravimid WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($raviminimi, $hinnang, $kommentaar);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->raviminimi =$raviminimi;
			$review->hinnang=$hinnang;
			$review->kommentaar=$kommentaar;
			
			
		}else{
			header("Location:tablek.php");
		}
		return $review;
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $raviminimi, $hinnang, $kommentaar){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE ravimid SET raviminimi=?, hinnang=?, kommentaar=? WHERE id=?");
		$stmt->bind_param("sssi", $raviminimi, $hinnang, $kommentaar, $id);
		if($stmt->execute()){

			
		}
		$stmt->close();
		$mysqli->close();
		
	}

?>