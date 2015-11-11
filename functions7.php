<?php

	//loob AB'i ühenduse
	
	require_once("../config_global.php");
	$database = "if15_mkoinc_3";
	
	function getClientData($keyword=""){
		$search = "%%";

	if($keyword == ""){
		//ei otsi midagi
		echo "Ei otsi";
		
	}else{
		//otsin
		echo "Otsin".$keyword;
		search = "%".$keyword."%";
	}
		
		$mysqli = new mysqli($GLOBALS["servername"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS ["database"]);

		$stmt = $mysqli -> prepare("SELECT id, user_id, product, product_material FROM Clients WHERE deleted is NULL AND(product LIKE ? OR product_material LIKE ?)");
		
				$stmt->bind_param("ss", $search, $search);
				$stmt->bind_result($id, $user_id_from_database, $product, $product_material);
				$stmt ->execute();
		
		//tekitan tühja massiivi,kus edaspidi hoian andmeid
		$Client_array = array();
		
		
		while($stmt->fetch()){
			
		//tekitan objekti, kus hakkan hoidma väärtusi
		$Client = new StdClass();
		$Client->id = $id;
		$Client->product = $Cleint;
		
		//lisan massiivi
		array_push($Client_array, $Client;
		//vardump ütleb tüübi ja sisu
		//echo"<pre>";
		//var_dump($Client_array);
		//echo"</pre><br>";
		}
		
		//tagastan massiivi kus kõik read sees
		return $Cleint_array;
		
		
		$stmt->close();
		
		$mysqli->close();
	}
	
	function deleteClient($id){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
		$stmt = $mysqli->prepare("UPDATE product SET deleted=NOW() WHERE id=?");
		
		$stmt->bind_param("i", $id);
			if($stmt->execute()){
				//sai kustutatud
				header("Location: table.php");
			}
			
			$stmt->close();
			$mysqli->close();
		}
	
	
	function updateClient($id, $product, $product_material){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET product=?, product_material=? WHERE id=?");
		$stmt->bind_param("ssi", $product, $product_material, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}

	
?>