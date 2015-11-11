<?php 
	
	require_once("../config.php");
	$database = "if15_hendrik7";
	
	session_start();
	
	
	//function createUser($create_email, $hash){
	function createUser($create_email, $hash, $username, $fullname){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		echo $mysqli->error;
		$stmt = $mysqli->prepare("INSERT INTO users (email, password, username, fullname) VALUES (?, ?, ?, ?)");
				
		$stmt->bind_param("ssss", $create_email, $hash, $username, $fullname);
		$stmt->execute();
		echo $stmt->error;
		$stmt->close();
		
		
	}
	
	
	function loginUser($email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
				
		//muutujad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
				
			//kontrollin kas tulemusi leiti
			if($stmt->fetch()){
			//ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
					
					//tekitan sessiooni muutujad
					$_SESSION["logged_in_user_id"] = $id_from_db;
					$_SESSION["logged_in_user_email"] = $email_from_db;
					
					//suunan data.php lehele
					header("Location: data.php");
					
			}else{
			//ei leidnud
				echo "wrong credentails!";
					
			}
				
		$stmt->close();
		$mysqli->close();
	}
	
	function postMedia($title, $media){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_content (user_id, title, media) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("iss",$_SESSION["logged_in_user_id"], $title, $media);
		$stmt->execute();
		echo $stmt->error;
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getPosts($keyword=""){
		
		$search = "%%";
		
		if($keyword == ""){
			//ei otsi midagi
			echo "Ei otsi";
		}else{
			//otsin
			echo "Otsin ";
			$search= "%".$keyword."%";
		}
		
		
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, title, media from user_content WHERE deleted IS NULL AND
		(title LIKE ?)");
		echo $mysqli->error;
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $user_id_from_database, $title, $media);
		$stmt->execute();
		
		// tekitan tühja massiivi, kus edaspidi hoian objekte
		$content_array = array();
		
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
			// tekitan objekti, kus hakkan hoidma väärtusi
			$content = new StdClass();
			$content->id = $id;
			$content->title = $title;
			$content->media = $media;
			$content->user_id = $user_id_from_database;
			
			
			//lisan massiivi ühe rea juurde
			array_push($content_array, $content);
			//var dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus kõik read sees
		return $content_array;
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	function deleteContent($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE user_content SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateContent($id, $title, $media){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE user_content SET title=?, media=? WHERE id=? AND user_id=?");
		$stmt->bind_param("ssii", $title, $media, $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	
	
?>