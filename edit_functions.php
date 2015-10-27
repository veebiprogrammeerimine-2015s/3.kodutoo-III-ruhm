<?php

	require_once("../config.php");
	$database = "if15_hendrik7";
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT title, media FROM user_content WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id, $media);
		$stmt->bind_result($title, $media);
		$stmt->execute();
		
		$content = new StdClass();
		
		//kas sain ühe rea andmeid kätte
		//$stmt->fetch() annab ühe rea andmeid
		if($stmt->fetch()){
			$content->title = $title;
			$content->media = $media;
			
		}else{
			header("Location: table.php");
			
		}
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	function updateContent($id, $title, $media){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE user_content SET title=?, media=? WHERE id=?");
		$stmt->bind_param("ssi", $title, $media, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	return $content;
	
	$stmt->close();
	
	

?>