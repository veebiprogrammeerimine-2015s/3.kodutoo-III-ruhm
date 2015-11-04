<?php
	require_once("../functions.php");

	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$exam ="";
	$grade = "";
	$mistakes = "";
	$exam_error = "";
	$grade_error = "";
	$mistakes_error = "";

	if(isset($_POST["add_review"])){
		if ( empty($_POST["exam"]) ) {
				$exam_error = "See väli on kohustuslik";
			}
			else{
				$exam = test_input($_POST["exam"]);
			}
	
		if ( empty($_POST["grade"]) ) {
				$grade_error = "See väli on kohustuslik";
			}
			else{
				$grade = test_input($_POST["grade"]);
			}
				
		if ( empty($_POST["mistakes"]) ) {
				$mistakes_error = "See väli on kohustuslik";
			}else{
				$mistakes = test_input($_POST["mistakes"]);
			}
				
		if($exam_error == "" && $grade_error == "" && $mistakes_error == ""){
			$message = addReview($exam, $grade, $mistakes);
			if($message != ""){
				$exam = "";
				$grade = "";
				$mistakes = "";
				
				echo $message;
			}
		}
	}
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	function test_input($data) {	
		$data = trim($data);	//võtab ära tühikud,enterid,tabid
		$data = stripslashes($data);  //võtab ära tagurpidi kaldkriipsud
		$data = htmlspecialchars($data);	//teeb htmli tekstiks, nt < läheb &lt
		return $data;
	}

	include("../table.php")

?>