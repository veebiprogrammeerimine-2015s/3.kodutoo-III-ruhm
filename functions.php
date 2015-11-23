<?php
	
	require_once("../configglobal.php");
	$database = "if15_arkadi_3";
	
	
	session_start();
	
	function createUser($email_add, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $email_add, $hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	function cleanInput($data) {
  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);
  	  return $data;
    }
	
	function loginUser($login_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM login WHERE email=? AND password=?");
		$stmt->bind_param("ss", $login_email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		//Kontrollin kas tulemusi leiti
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			// suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "valed kasutajatunnused";
		}
				
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function addReview($jalgpallurinimi, $hinnang, $kommentaar){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO jalgpallurid (user_id, jalgpallurinimi, hinnang, kommentaar) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("isss", $_SESSION["logged_in_user_id"], $jalgpallurinimi, $hinnang, $kommentaar);
		
		//sõnum
		$message= "";
		
		if($stmt->execute()){
			//kui on tõene, INSERT õnnestus
			$message = "Sai edukalt lisatud";
			
			
		}else{
			//kui on väär, kuvame errori
			echo $stmt->error;
		}
		return $message;
		
		$stmt->close();
		$mysqli->close();
	}
	function getReviewData($keyword=""){
		
		$search="%%";
		
		//kas otsisõna on tühi
		if($keyword==""){
			//ei otsi midagi
			//echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin " .$keyword;
			$search="%".$keyword."%";
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, jalgpallurinimi, hinnang, kommentaar FROM jalgpallurid WHERE deleted IS NULL AND (jalgpallurinimi LIKE ?)");
		echo $mysqli->error; 
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $user_id, $footballer, $rating, $comment);
		$stmt->execute();
		
		//tekitan tühja massiivi, kus edaspidi hoian objekte
		$review_array = array ();
		
		//tee midagi seni, kuni saame andmebaasist ühe rea andmeid
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu
			
			//tekitan objekti, kus hakkan hoidma väärtusi
			$review = new StdClass();
			$review->id = $id;
			$review->footballer =$footballer;
			$review->user_id=$user_id;
			$review->rating=$rating;
			$review->comment=$comment;
			//lisan massiivi ühe rea juurde
			
			array_push($review_array, $review);
			
			
		}
		//tagastan massiivi, kus kõik read sees
		return $review_array;
		
		$stmt->close();
		$mysqli->close();
		
	}
	function deleteReview($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE jalgpallurid SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			//sai kustutatud, kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $footballer, $rating, $comment){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE jalgpallurid SET jalgpallurinimi=?, hinnang=?, kommentaar=? WHERE id=? AND user_id =?");
		echo $mysqli->error;
		$stmt->bind_param("sssii", $footballer, $rating, $comment, $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			//sai kustutatud, kustutame aadressirea tühjaks
			//header("Location: table.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	
	
?>	