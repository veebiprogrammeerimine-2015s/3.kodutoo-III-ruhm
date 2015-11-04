<?php

	//Loome ühenduse andmebaasiga
	require_once("../../config_global.php");
	$database = "if15_Harri_3";
	session_start();
	
	//hakkame andmeid andmebaasi sisestama (exam, grade, mistakes)
	function createUser($firstname, $lastname, $email2, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_reg1 (email, password, firstname, lastname) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss", $email2, $hash, $firstname, $lastname);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	function loginUser($email1, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM user_reg1 WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email1, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Email ja parool õiged, kasutaja id=" .$id_from_db;
			
			//tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			

			header("Location: data.php");
			
		}else{
			echo "Wrong credentials";
		}
		$stmt->close();
		$mysqli->close();
		
	} 
	function addReview($exam, $grade, $mistakes){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO eksam (user_id, exam, grade, mistakes) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("isss", $_SESSION["logged_in_user_id"], $exam, $grade, $mistakes);

		$message= "";
		
		if($stmt->execute()){
			$message = "Sai edukalt lisatud";
		}
		else{
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $message;
	}
	
	

	function getReviewData($keyword=""){
		
		$search="%%";
		if($keyword!=""){
			echo "Otsin " .$keyword;
			$search="%".$keyword."%";
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, exam, grade, mistakes FROM eksam WHERE deleted IS NULL AND (exam LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $user_id, $exam, $grade, $mistakes);
		$stmt->execute();

		$review_array = array ();

		while($stmt->fetch()){

			$review = new StdClass();
			$review->id = $id;
			$review->exam =$exam;
			$review->user_id=$user_id;
			$review->grade=$grade;
			$review->mistakes=$mistakes;

			array_push($review_array, $review);
		}
		$stmt->close();
		$mysqli->close();
		return $review_array;		
	}

	function deleteReview($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE eksam SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			header("Location: data.php");
		}
		$stmt->close();
		$mysqli->close();
	}

	function updateReview($id, $exam, $grade, $mistakes){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE eksam SET exam=?, grade=?, mistakes=? WHERE id=? AND user_id =?");
		echo $mysqli->error;
		$stmt->bind_param("sssii", $exam, $grade, $mistakes, $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute());
		$stmt->close();
		$mysqli->close();
	}
?>