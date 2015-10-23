<?php

	//Loome ühenduse andmebaasiga
	require_once("../config_global.php");
	$database = "if15_earis_3";

	//annan vaikeväärtuse
	function getReviewData($keyword=""){
		
		$search="%%";
		
		//kas otsisõna on tühi
		if($keyword==""){
			//ei otsi midagi
			echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin" .$keyword;
			$search="%".$keyword."%";
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, raviminimi, hinnang, kommentaar FROM ravimid WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id, $raviminimi, $hinnang, $kommentaar);
		$stmt->execute();
		
		//tekitan tühja massiivi, kus edaspidi hoian objekte
		$review_array = array ();
		
		//tee midagi seni, kuni saame andmebaasist ühe rea andmeid
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu
			
			//tekitan objekti, kus hakkan hoidma väärtusi
			$review = new StdClass();
			$review->id = $id;
			$review->raviminimi =$raviminimi;
			$review->user_id=$user_id;
			$review->hinnang=$hinnang;
			$review->kommentaar=$kommentaar;
			//lisan massiivi ühe rea juurde
			
			array_push($review_array, $review);
			//var dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
			
		}
		//tagastan massiivi, kus kõik read sees
		return $review_array;
		
		$stmt->close();
		$mysqli->close();
		
	}
	function deleteReview($id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE ravimid SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//sai kustutatud, kustutame aadressirea tühjaks
			header("Location: tablek.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	function updateReview($id, $raviminimi, $hinnang, $kommentaar){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE ravimid SET raviminimi=?, hinnang=?, kommentaar0? WHERE id=?");
		$stmt->bind_param("sssi", $raviminimi, $hinnang, $kommentaar, $id);
		if($stmt->execute()){
			//sai kustutatud, kustutame aadressirea tühjaks
			//header("Location: table.php");
			
		}
		$stmt->close();
		$mysqli->close();
		
	}
	
	
?>