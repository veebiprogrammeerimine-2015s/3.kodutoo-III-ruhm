<?php

require_once("../../configglobal.php");
$database = "if15_siim_3";

function getEditData($edit_id){
	$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
	$stmt=$mysqli->prepare("SELECT location,place_condition,description,date_visited FROM interesting_places WHERE id=? AND deleted IS NULL");
	echo $mysqli->error;
	$stmt->bind_param("i",$edit_id);
	$stmt->bind_result($location,$condition,$description,$date_visited);
	$stmt->execute();
	$place=new StdClass();
	//kas sain ühre rea namdeid kätte
	if($stmt->fetch()){
		$place->location=$location;
		$place->condition=$condition;
		$place->description=$description;
		$place->date_visited=$date_visited;
	}else{
		//ei saanud
		//id ei olnud olemas,id=12223546364
		//rida on kustutatud, deleted ei ole NULL
		header("Location:table.php");
	}
	return $place;
	
	$stmt->close();
	$mysqli->close();
	
	
}
function updatePlace($id,$location,$condition,$description,$date_visited){
		$mysqli = new mysqli($GLOBALS["server_name"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$stmt=$mysqli->prepare("UPDATE interesting_places SET location=?,place_condition=?,description=?,date_visited=? WHERE id=?");
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

