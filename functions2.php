<?php

	//loob AB'i ¸henduse
	
	require_once("../config_global.php");
	$database = "if15_mkoinc_3";
	

	session_start();
	
	
	
	function createUser($name, $surename, $mail, $hash){
		$mysqli = new mysqli($GLOBALS["servername"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS ["database"]);
		
		$stmt = $mysqli -> prepare("INSERT INTO Clients (name, surename, email, password) VALUES(?, ?, ?, ?)");
		
				$stmt ->bind_param("ssss", $name, $surename, $mail, $hash);
				$stmt ->execute();
				$stmt ->close();
		
		$mysqli->close();
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM Clients WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute(); 
		if($stmt->fetch()){
					//ab'i oli midagi
					echo "Email ja parool ıiged, kasutaja id=".$id_from_db;
					
					//tekitan sessiooni muutujad
					$_SESSION["logged_in_user_id"] = $id_from_db;
					$_SESSION["logged_in_user_email"] = $email_from_db;
					
					//suunan data.php lehele
					header("Location: data.php");

					
				}else{
					//ei leitud
					echo "Wrong credentials!";
				}
		
	$stmt->close();
		
		$mysqli->close();
	}
	
	
	function addOrders($product, $product_material) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO Orders (user_id, product, product_material) VALUES (?,?,?)");
		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"], $product, $product_material);
		
		//sınum
		$message = "";
		
		if($stmt->execute()){
			// kui on tıene,
			//siis INSERT ınnestus
			$message = "Sai edukalt lisatud";
			 
			
		}else{
			// kui on v‰‰rtus FALSE
			// siis kuvame errori
			echo $stmt->error;
			
		}
		
		return $message;
		
		
		$stmt->close();
		
		$mysqli->close();
		
		
	}

function getOrdersData($keyword=""){
		
		$search="%%";
		
		//kas otsisõna on tühi
		if($keyword==""){
			//ei otsi midagi
			//echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin " .$keyword;
			$search="%".$keyword."%";
			// "linex"
			// "%linex%"
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, product, product_material FROM Orders WHERE deleted IS NULL AND (product LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $user_id, $product, $product_material);
		$stmt->execute();
		
		$Client_array = array ();
		
		
		while($stmt->fetch()){
			
			$Client = new StdClass();
			$Client->id = $id;
			$Client->product =$product;
			$Client->product_material = $product_material;
						
			array_push($Client_array, $Client);
			//var dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
			
		}
		//tagastan massiivi, kus kõik read sees
		return $Cleint_array;
		
		$stmt->close();
		$mysqli->close();
		
	}
	function deleteCleint($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE Clients SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
		
			header("Location: table.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	function updateClient($id, $product, $product_material){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE Orders SET product=?, product_material=? WHERE id=? AND user_id =?");
		echo $mysqli->error;
		$stmt->bind_param("ssii", $product, $product_material, $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			//sai kustutatud, kustutame aadressirea tühjaks
			//header("Location: table.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	
	
?>	
