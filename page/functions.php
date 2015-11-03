<?php
	//functions.php
	// siia tulevad funktsioonid, kõik mis seotud andmebaasiga
	
	//loon andmebaasi ühenduse
	require_once("../../configglobal.php");
	$database = "if15_siim_3";
	
	session_start();
	
	function createUser($create_email,$hash,$fname,$lname,$age,$city){
		// salvestame andmebaasi
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
				$stmt = $mysqli->prepare("INSERT INTO users(email,password,first_name,last_name,age,city) VALUES (?,?,?,?,?,?)");
				echo $mysqli->error;
 				echo $stmt->error;
				//asendame ? märgid, ss - s on string email, s on string password,i on integer
				$stmt->bind_param("ssssis",$create_email,$hash,$fname,$lname,$age,$city);
				$stmt->execute();
				$stmt->close();
				
				//paneme ühenduse kinni
	$mysqli->close();
	}
	function loginUser($email,$hash){
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id,email FROM users WHERE email=? AND password=? ");
		$stmt->bind_param("ss",$email,$hash);
				
				//muutujuad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
				
				//kontrollin kas tulemusi leiti
		if($stmt->fetch()){
					//ab's oli midagi
			echo " Email ja parool õiged, kasutaja id=".$id_from_db;
			
			//tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location:data.php");
			
		}else{
					//ei leidnud
			echo "Wrong credentials";
				}
		$stmt->close();
		$mysqli->close();
	}	
		
	function addPlace ($location,$condition,$description,$date_visited){
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
			$stmt = $mysqli->prepare("INSERT INTO interesting_places(user_id,location,condition,description,date_visited) VALUES (?,?,?,?,?)");
			//asendame ? märgid, ss - s on string email, s on string password,i on integer
			$stmt->bind_param("issss",$_SESSION["logged_in_user_id"],$location,$condition,$description,$date_visited);
			
			//sõnum
			$message="";
			if($stmt->execute()){
				//kui on tõene,siis insert õnnestus
				$message="Sai edukalt lisatud";
			}else{
				//kui on väär kuvame errori
				echo $stmt->error;
			}
			return $message;
			
			$stmt->close();
			$mysqli->close();	
	}
	
	function getPlaceData($keyword=""){
		$search="%%";
		if($keyword==""){
			echo "ei otsi";
		}else{
			echo "otsin".$keyword;
			$search="%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$stmt=$mysqli->prepare("SELECT id,user_id,location,condition,description,date_visited FROM interesting_places WHERE deleted IS NULL AND (location LIKE ? OR condition LIKE ? OR description LIKE ? OR date_visited LIKE ?)");
		$stmt->bind_param("ssss",$search,$search,$search,$search);
		$stmt->bind_result($id,$user_id_from_db,$location,$condition,$description,$date_visited);
		$stmt->execute();
		
		//tekitan massiivi
		$place_array=array();
		
		//tee midagi seni kuni saame ab-st ühe rea anmdeid
		while($stmt->fetch()){
			//seda siin tehakse nii mitu korda kui on ridu
			
			//tekitan objekti,kus hakkan hoidma väärtust
			$place=new StdClass();
			$place->id=$id;
			$place->location=$location;
			$place->condition=$condition;
			$place->description=$description;
			$place->date_visited=$date_visited;
			$place->user_id=$user_id_from_db;
			//lisan massiivi
			array_push($place_array,$place);
			//echo "<pre>";
			//var_dump ($car_array);
			//echo"</pre><br>";
		}
		
		//tagastan massiivi,kus kõik read sees
		return $place_array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deletePlace($id){
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$stmt=$mysqli->prepare("UPDATE interesting_places SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i",$id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadressirea tühjaks
			header("Location:table.php");
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function updatePlace($id,$location,$condition,$description,$date_visited){
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$stmt=$mysqli->prepare("UPDATE interesting_places SET location=?,condition=?,description=?,date_visited=? WHERE id=?");
		$stmt->bind_param("ssssi",$location,$condition,$description,$date_visited,$id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadressirea tühjaks
			header("Location:table.php");
		}
		
		$stmt->close();
		$mysqli->close();
		
		
	}
?>