<?php
	require_once("edit_functions.php");
	$grade = "";
	$mistakes = "";
	$mistakes_error = "";
	
	if(isset($_POST["update_review"])){
		updateReview($_POST["id"], $_POST["exam"], $_POST["grade"], $_POST["mistakes"]);
	}
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		$review = getEditData($_GET["edit_id"]);
		var_dump($review);
		
	}else{
		echo "edit_id is not set";
		header("Location:data.php");
		
	}
?>
