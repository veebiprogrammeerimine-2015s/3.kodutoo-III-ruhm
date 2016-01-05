<?php
	// Loon andmebaasi ühenduse
	require_once("../config_global.php");
	$database = "if15_henrrom";
	session_start();
	
		//võtab andmed ja sisestab andmebaasi
	function createUser($user_email, $hash, $lastname, $firstname){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare('INSERT INTO user_info (email, password, lastname, firstname) VALUES (?, ?, ?, ?)');
		// asendame küsimärgid. ss - s on string email, s on string password
		$stmt->bind_param("ssss", $user_email, $hash, $lastname, $firstname);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}

	function loginUser($log_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT email, id FROM user_info WHERE email=? AND password=?");
		$stmt->bind_param("ss", $log_email, $hash);
		//muutujad tulemustele
		$stmt->bind_result($email_from_db, $id_from_db);
		$stmt->execute();
		//kontrolli, kas tulemus leiti
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
			echo "wrong credentials";
		}			
		$stmt->close();
		$mysqli->close();	
	}
	
	function addPost($tweet){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO posts (user_id, tweet) VALUES (?,?)");
		$stmt->bind_param("is", $_SESSION["logged_in_user_id"], $tweet);
		
		//Sõnum
		$message = "";
		
		if($stmt->execute()){
			//kui on tõene siis INSERT õnnestut
			$message = "Sai edukalt lisatud";
			
		}else{
			// kui on väär, siis kuvame error
			echo $stmt->error;
		}
		return $message;
		
		$stmt->close();
		$mysqli->close();
	}
	function getPostData($keyword=""){

		$search = "%%";
		
		if($keyword == ""){

		}else{
			//otsin
			echo"Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, tweet from posts WHERE deleted IS NULL AND (tweet LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $user_id_from_database, $tweet);
		$stmt->execute();
		
		//tekitan tühja massiivi, kus edaspidi hoian objekte 
		$posts_array = array();
		
		//tee midagi seni, kuni saad ab'st ühe rea andmeid.
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu.
			
			//tekitan objekti; kus hakkan hoidma väärtusi
			$post = new StdClass();
			$post->id = $id;
			$post->user_id = $user_id_from_database;
			$post->tweet = $tweet;
			
			//lisan massiivi
			array_push($posts_array, $post);
			//var_dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus kõik read sees
		return $posts_array;
			
		$stmt->close();
		$mysqli->close();
	}
	
	function deletePost($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE posts SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function updatePost($id, $tweet){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE posts SET tweet=? WHERE id=? AND user_id=?");
		$stmt->bind_param("sii", $tweet, $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){

			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	/*function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT tweet FROM posts WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($tweet);
		$stmt->execute();
		
		
		//objekt
		$post = new StdClass();
		//kas sain ühe rea andmeid kätte
		//$stmt->fetch() annab ühe rea andmeid
		if($stmt->fetch()){
			//sain
			$post->tweet = $tweet;
		}else{
			//ei saanud
			//id ei olnud olemas, id=123523453456743
			//rida kustutatud, deleted ei ole NULL
			header("Location: table.php");
		}
		
		return $post;
		
		$stmt->close();
		$mysqli->close();
	}*/

?>