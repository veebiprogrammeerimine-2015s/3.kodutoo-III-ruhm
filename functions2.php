<?php
	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";

	session_start();
	
	function createUser($create_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
	}

	function loginUser($email, $hash){
		echo "siin 4";
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			//ab'i oli midagi
			echo "siin 5";
			echo "Email ja parool oiged, kasutaja id=".$id_from_db;
			
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//header("Location: data.php");
			
		}else{
			//ei leidnud
			echo "Wrong redentials";
		}
		
		$stmt->close();
		
		$mysqli->close();
	}
	
	function addNote($note_title, $note_note){
		
		
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO note_table (user_id, title, note) VALUES (?,?,?)");
		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"], $note_title, $note_note);
		
		//sonum
		$message = "";
		
		if($stmt->execute()){
			//kui on tõene, siis INSERT õnnestus
			$message = "Sai edukalt lisatud";
		}else{
			//kui on väär, siis kuvame error
			echo $stmt->error;
		}
		
		return $message;
		
		$stmt->close();
		
		$mysqli->close();
	}
?>