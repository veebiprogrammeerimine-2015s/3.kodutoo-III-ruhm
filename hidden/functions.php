<?php
	require_once("../config.php");
	$database = "if15_hendval";
	
	session_start();
	
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
	}
	
	function createUser($username, $email, $hash, $name, $age){
		$mysqli = new mysqli($GLOBALS["server_name"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO jackpot_users (kasutajanimi, email, password, name, age) VALUES (?,?,?,?,?)");
		$stmt->bind_param("ssssi", $username, $email, $hash, $name, $age);
		$stmt->execute();
		echo "Kasutaja on loodud!";
		$stmt->close();
		$mysqli->close();
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["server_name"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, name, krediit, age, kasutajanimi, created FROM jackpot_users where email=? and password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db, $name_from_db, $credits_from_db, $age_from_db, $username_from_db, $created_from_db);
		$stmt->execute();
		if($stmt->fetch()){
		
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			$_SESSION["logged_in_user_name"] = $name_from_db;
			$_SESSION["logged_in_user_credits"] = $credits_from_db;
			$_SESSION["logged_in_user_age"] = $age_from_db;
			$_SESSION["logged_in_user_username"] = $username_from_db;
			$_SESSION["logged_in_user_created"] = $created_from_db;
		
			// suunan data.php lehele
			header("Location: index.php");
		
		} else {
		//ei leidnud
		echo "Email või parool on vale!";
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function changePass($newhash, $id_from_db, $oldhash){
		$mysqli = new mysqli($GLOBALS["server_name"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE jackpot_users SET password=? WHERE id=? and password=?");
		$stmt->bind_param("sis", $newhash, $id_from_db, $oldhash);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Parool on muudetud!";
		} else {
			echo "Midagi läks valesti, proovige uuesti!";
		}
		$stmt->close();
		$mysqli->close();
	}
?>