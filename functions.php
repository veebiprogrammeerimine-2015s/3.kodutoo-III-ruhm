<?php 
	
	// Loon AB'i ühenduse
	require_once("../config_global.php");
	$database = "if15_kar1ns";
	
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	// võtab andmed ja sisestab ab'i
	// võtame vastu 2 muutujat
	function createUser($create_email, $hash){
		
		// Global muutujad, et kätte saada config failist andmed
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		
		//sõnum
		$message = "";
		
		if($stmt->execute()){
			//kui on tõene siis insert õnnestus
			$message = "Sai edukalt lisatud";
			
		}else{
			//kui on väär kuvame errori
			echo $stmt->error;
		}
		
		return $message;
		
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);		
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	// fn sample
	function hello($name, $age){
		echo $name." ".$age;
	}
	
	//hello("Romil", 5);
	// kuigi muuutujad on erinevad jõuab väärtus kohale
	function addDream($dream_post) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO dream_post (user_id, blog_post) VALUES (?,?)");
			echo $mysqli->error;
		$stmt->bind_param("is", $_SESSION["logged_in_user_id"], $dream_post);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
		
	}
	
	function getDreamData(){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("SELECT id, user_id, blog_post from dream_post");
		$stmt->bind_result($id, $user_id_from_database, $blog_post);
		$stmt->execute();
		
		$dream_array=array();
		$row = 0;
		
		//tee midagi seni kuni saame ab'st ühe rea andmeid
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu
			$dream = new StdClass();
			$dream->id = $id;
			$dream->post = $blog_post;
			$dream->user_id = $id;
			
			
			//lisan massiivi
			array_push($dream_array, $dream);

	}
	return $dream_array;
	
	$stmt->close();
	$mysqli->close();
}

function deleteDream($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE dream_post SET deleted=NOW() WHERE id=?");
		
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//sai kustutatud
			header("Location: table.php");
		}
	
	}
	
	function updateDream($id, $blog_post){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE dream_post SET blog_post=? WHERE id=?");
		
		$stmt->bind_param("si", $blog_post, $id);
		if($stmt->execute()){
			//sai kustutatud
			header("Location: table.php");
	
		}
	}
	
?>