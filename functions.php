<?php 
	
	require_once("../config_global.php");
	require_once("User.class.php");
	
	$database = "if15_meritak";
	
	session_start();
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//saadan �henduse classi ja loon uue classi
	$User = new User($mysqli);
	
	//var_dump($User->connection);
	
?>
