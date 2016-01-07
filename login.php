<?php
		
	// kõik funktsioonid, kus tegeleme AB'iga
	require_once("functions.php");
	
	//kui kasutaja on sisseloginud,
	//siis suuunan data.php lehele
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	
	
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_name_error = "";
	$create_gender_error = "";
	$create_bday_error = "";

  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_name = "";
	$create_gender = "";
	$create_bday = "";


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
				
				// kasutaja sisselogimise fn, failist functions.php
				loginUser($email, $hash);
				
				
			}

		} // login if end

		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
		
				if ( empty($_POST["create_name"]) ) {
					$create_name_error = "See väli on kohustuslik";
				}else{
					$create_name = cleanInput($_POST["create_name"]);
				}

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
				
				if ( empty($_POST["create_gender"]) ) {
					$create_gender_error = "See väli on kohustuslik";
				}else{
					$create_gender = cleanInput($_POST["create_gender"]);
				}
				
				if ( empty($_POST["create_bday"]) ) {
					$create_bday_error = "See väli on kohustuslik";
				}else{
					$create_bday = cleanInput($_POST["create_bday"]);
				}

				if(	$create_email_error == "" && $create_password_error == ""){
					
					// räsi paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash;
					
					// kasutaja loomise fn, failist functions.php,
					// saadame kaasa muutujad
					createUser($create_email, $hash);
					
				}
		} // create if end

	}

  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
	
	
	
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="create_email" >E-mail</label><br>
  	<input name="create_email" type="email" placeholder="something@something.sth" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<label for="create_password" >Parool</label><br>
	<input name="create_password" type="password" placeholder="********"> <?php echo $create_password_error; ?> <br><br>
	<label for="create_name" >Nimi</label><br>
	<input name="create_name" type="name" placeholder="Ees- ja perekonnanimi"> <?php echo $create_name_error; ?> <br><br>
	<label for="create_gender" >Sugu</label><br>
	<input name="create_gender" type="gender" placeholder="mees/naine"> <?php echo $create_gender_error; ?> <br><br>
	<label for="create_bday" >Sünnipäev</label><br>
	<input name="create_bday" type="bday" placeholder="dd/mm/yyyy"> <?php echo $create_bday_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
