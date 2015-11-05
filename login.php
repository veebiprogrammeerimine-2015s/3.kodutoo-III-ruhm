<?php
	
	// kõik funktsioonid
	require_once("functions.php");
	// kui kasutaja on sisse loginud,
	// siis suunan data.php lehele
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
		
	}
	
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$first_name_error = "";
	$last_name_error = "";
  // muutujad väärtuste jaoks
	$first_name = "";
	$last_name = "";
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// *********************
		// **** LOGI SISSE *****
		// *********************
		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
				$hash = hash("sha512", $password);
				// kasutaja sisselogimise funktsioon, failist functions.php
				login($email, $hash);
				
			}
		} // login if end
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
				if ( empty($_POST["create_email"]) ) {
					$create_email_error = "See väli on kohustuslik";
				}else{
					$create_email = cleanInput($_POST["create_email"]);
				}
				if ( empty($_POST["create_password"]) ) {
					$create_password_error = "See väli on kohustuslik";
				} else {
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					}else{
						$create_password = cleanInput($_POST["create_password"]);
					}
				}
				if (empty ($_POST["first_name"])){
					$first_name_error = "Seda välja ei tohi tühjaks jätta!";
				}else{
					$first_name = cleanInput($_POST["first_name"]);
				}
				
				if (empty ($_POST["last_name"])){
					$last_name_error = "Seda välja ei tohi tühjaks jätta!";
				}else{
					$last_name = cleanInput($_POST["last_name"]);
				}
				if(	$create_email_error == "" && $create_password_error == "" && $first_name_error=="" && $last_name_error==""){
					
					// räsi paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash;
					
					// kasutaja loomise funktsioon, failist functions.php
					// saadame kaasa muutujad
					register($create_email, $hash);
					
				}
		} // create if end
	}
	
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
<h2>Log in</h2>
		<form action="login.php" method="post" >
			<input name="email" type="email" placeholder="Email"> <?php echo $email_error ?> <br><br>
			<input name="password" type="password" placeholder="Parool"> <?php echo $password_error ?> <br><br>
			<input name="login" type="submit" value="login">
		</form>
	
	<h2>Create user</h2>
	Tärniga märgitud lahtrid on kohustuslikud
		<form action="login.php" method="post" >
			<input name="create_email" type="email" placeholder="E-mail" >*<?php echo $create_email_error; ?> <br><br>
			<input name="create_password" type="password" placeholder="Parool" >*<?php echo $create_password_error; ?> <br><br>
			<input name="first_name" type="text" placeholder="Eesnimi" >* <?php echo $first_name_error; ?> <br><br>
			<input name="last_name" type="text" placeholder="Perekonnanimi" >* <?php echo $last_name_error; ?> <br><br>
			<input name="create" type="submit" value="Create user" >
		</form>	
<body>
<html>