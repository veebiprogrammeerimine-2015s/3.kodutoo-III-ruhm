<?php

	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT title, note FROM note_table WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($title, $note);
		$stmt->execute();
		
		//object
		$note = new StdClass();
		
		// kas sain uhe rea andmeid katte
		//$stmt->fetch() annab uhe rea andmeid
		if($stmt->fetch()){
			//sain
			$Note1->title = $title;
			$Note1->note = $note;
			
		}else{
			// ei saanud
			// id ei olnud olemas, id=123123123
			// rida on kustutatud, deleted ei ole NULL
			header("Location: table.php");
		}
		
		return $Note1;
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	
		function updateNote($id, $title, $note){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE note_table SET title=?, note=? WHERE id=?");
		$stmt->bind_param("ssi", $title, $note, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tuhjaks
			// header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}


?>
