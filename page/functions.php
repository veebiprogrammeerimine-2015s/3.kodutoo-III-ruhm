<?php
	//functions.php
	// siia tulevad funktsioonid, kõik mis seotud andmebaasiga
	
	//loon andmebaasi ühenduse
	require_once("../configglobal.php");
	$database = "if15_siim_3";
	
	function getCarData($keyword=""){
		$search="%%";
		if($keyword==""){
			echo "ei otsi";
		}else{
			echo "otsin".$keyword;
			$search="%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$stmt=$mysqli->prepare("SELECT id,user_id,number_plate,color FROM car_plates WHERE Deleted IS NULL AND (number_plate LIKE ? OR color LIKE ?)");
		$stmt->bind_param("ss",$search,$search);
		$stmt->bind_result($id,$user_id_from_db,$number_plate,$color);
		$stmt->execute();
		
		//tekitan massiivi
		$car_array=array();
		
		//tee midagi seni kuni saame ab-st ühe rea anmdeid
		while($stmt->fetch()){
			//seda siin tehakse nii mitu korda kui on ridu
			
			//tekitan objekti,kus hakkan hoidma väärtust
			$car=new StdClass();
			$car->id=$id;
			$car->plate=$number_plate;
			$car->color=$color;
			$car->user_id=$user_id_from_db;
			//lisan massiivi
			array_push($car_array,$car);
			//echo "<pre>";
			//var_dump ($car_array);
			//echo"</pre><br>";
		}
		
		//tagastan massiivi,kus kõik read sees
		return $car_array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteCar($id){
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$stmt=$mysqli->prepare("UPDATE car_plates SET Deleted=NOW() WHERE id=?");
		$stmt->bind_param("i",$id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadressirea tühjaks
			header("Location:table.php");
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function updateCar($id,$number_plate,$color){
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$stmt=$mysqli->prepare("UPDATE car_plates SET number_plate=?,color=? WHERE id=?");
		$stmt->bind_param("ssi",$number_plate,$color,$id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadressirea tühjaks
			header("Location:table.php");
		}
		
		$stmt->close();
		$mysqli->close();
		
		
	}
?>