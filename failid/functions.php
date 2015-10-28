<?php
	require_once("../../config_global.php");
	$database = "if15_janekos_3";
	
	session_start();
	
	function createUser($create_email, $hash, $create_nickname, $create_name, $create_surname, $create_date){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO users (email, password, nickname, name, surname, date) VALUES (?,?,?,?,?,?)");
		$stmt->bind_param("sssssi", $create_email, $hash, $create_nickname, $create_name, $create_surname, $create_date);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			header("Location: data.php");
			
		}else{
			echo "Email või parool valed.";
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function addArmor($logged_in_user_id, $armor_type, $armor_race, $armor_color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO armorid (user_id, type, race, color) VALUES (?,?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("isss",$logged_in_user_id, $armor_type, $armor_race, $armor_color);
		
		$message = "";
		
		if($stmt->execute()){
			$message = "Sai edukalt lisatud!";
		}else{
			echo $stmt->error;
		}
		return $message;
		echo $stmt->error;
		$stmt->close();
		$mysqli->close();
	}
	
	function getArmorData($keyword=""){
		
		$search = "%%";
		
		if($keyword != ""){
			echo "Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, type, race, color FROM armorid WHERE deleted IS NULL AND (type LIKE ? OR race LIKE ? OR color LIKE ?)");
		$stmt->bind_param("sss", $search, $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $armor_type, $armor_race, $armor_color);
		$stmt->execute();
		$armor_array = array();
		while($stmt->fetch()){
			$armor = new StdClass();
			$armor->id = $id;
			$armor->user = $user_id_from_database;
			$armor->type = $armor_type;
			$armor->race = $armor_race;
			$armor->color = $armor_color;
			array_push($armor_array, $armor);
		}
		
		return $armor_array;
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteArmor($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE armorid SET deleted=NOW() WHERE id=? AND deleted IS NULL AND user_id=?");
		$stmt->bind_param("ii", $id);
		if ($stmt->execute()){
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function updateArmor($id, $armor_type, $armor_race, $armor_color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE armorid SET type=?, race=?, color=? WHERE id=? AND deleted IS NULL AND user_id=?");
		$stmt->bind_param("sssii", $armor_type, $armor_race, $armor_color, $id);
		if ($stmt->execute()){
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT type, race, color FROM armorid WHERE id=? AND deleted IS NULL AND user_id=?");
		$stmt->bind_param("ii", $edit_id, $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($armor_type, $armor_race, $armor_color);
		$stmt->execute();
		$armor = new StdClass();
		if($stmt->fetch()){
			
			$armor->type = $armor_type;
			$armor->race = $armor_race;
			$armor->color = $armor_color;
			
		}else{
			header("Location: table.php");
		}
		return $armor;
		$stmt->close();
		$mysqli->close();
		
	}
 ?>