<?php

	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT pealkiri, märkus FROM p2evik WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($pealkiri, $märkus);
		$stmt->execute();
		
		//object
		$note = new StdClass();
		
		// kas sain uhe rea andmeid katte
		//$stmt->fetch() annab uhe rea andmeid
		if($stmt->fetch()){
			//sain
			$note->pealkiri = $pealkiri;
			$note->märkus = $märkus;
			
		}else{
			// ei saanud
			// id ei olnud olemas, id=123123123
			// rida on kustutatud, deleted ei ole NULL
			header("Location: table.php");
		}
		
		return $note;
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	
		function updateNote($id, $pealkiri, $märkus){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE p2evik SET pealkiri=?, märkus=? WHERE id=?");
		$stmt->bind_param("ssi", $pealkiri, $märkus, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tuhjaks
			// header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}


?>
