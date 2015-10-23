<?php
	require_once("functionsk.php");
	//kas kustutame, ?delete = vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		echo "Kustutame id" .$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id
		deleteReview($_GET["delete"]);
	
	}
	//salvestan andmebaasi
	if(isset($_POST["save"])){
		updateReview($_POST["id"], $_POST["raviminimi"], $_POST["hinnang"], $_POST["kommentaar"]);
	}
	
	$keyword="";
	
	//aadressireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin	
		$keyword= $_GET["keyword"];
		$review_array = getCarData($keyword);
		
	}else{
		//küsin kõik andmed
	//käivitan funktsiooni
	$review_array = getCarData();
	}
	

?>