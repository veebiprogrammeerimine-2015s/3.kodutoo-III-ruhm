<?php
		
	// k�ik funktsioonid, kus tegeleme AB'iga
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
	$lastname_error = "";
 	$firstname_error = "";
  // muutujad v��rtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$lastname = "";
 	$firstname= "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		// *********************
		// **** LOGI SISSE *****
		// *********************
		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "See v�li on kohustuslik";
			}else{
			// puhastame muutuja v�imalikest �leliigsetest s�mbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See v�li on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia j�udnud, v�ime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "V�ib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
				$hash = hash("sha512", $password);
				
				// kasutaja sisselogimise fn, failist functions.php
				$login_response = $User->loginUser($email, $hash);
				
				//kasutaja logis edukalt sisse
				if(isset($login_response->success)){
					
					// id, emaili
					$_SESSION["logged_in_user_id"] = $login_response->user->id;
					$_SESSION["logged_in_user_email"] = $login_response->user->email;
					
					//saadan s�numi teise faili kasutades SESSIOONI
					$_SESSION["login_success_message"] = $login_response->success->message;
					
					header("Location: data.php");
					
				}
				
				
			}
		} // login if end
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
				if ( empty($_POST["create_email"]) ) {
					$create_email_error = "See v�li on kohustuslik";
				}else{
					$create_email = cleanInput($_POST["create_email"]);
				}
				if ( empty($_POST["create_password"]) ) {
					$create_password_error = "See v�li on kohustuslik";
				} else {
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error = "Peab olema v�hemalt 8 t�hem�rki pikk!";
					}else{
						$create_password = cleanInput($_POST["create_password"]);
					}
					if ( empty($_POST["firstname"]) ) {
					$firstname_error = "See v�li on kohustuslik";
				}
				if ( empty($_POST["lastname"]) ) {
					$lastname_error = "See v�li on kohustuslik";
				}
				if(	$create_email_error == "" && $create_password_error == "")
					
					// r�si paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "V�ib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja r�si on ".$hash;
					
					// kasutaja loomise fn, failist functions.php,
					// saadame kaasa muutujad
					
					// fn User klassist
					$create_response = $User->createUser($create_email, $hash);
					
				}
		} // create if end
	}
  // funktsioon, mis eemaldab k�ikv�imaliku �leliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
	
	
	
?>
<html>
<head>
<title>search</title>
</head>
<body>
<form action='search.php' method='GET'>
<left>
<h1>Search</h1>
<input type='text' size='20' name='search'></br></br>
<input type='submit' name='submit' value='Search!' ></br></br></br>
</left>
</form>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
    <?php if(isset($login_response->error)): ?>
  
	<p style="color:red;">
		<?=$login_response->error->message;?>
	</p>
  
  <?php elseif(isset($login_response->success)): ?>
	
	<p style="color:green;" >
		<?=$login_response->success->message;?>
	</p>
	
  <?php endif; ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  
  <?php if(isset($create_response->error)): ?>
  
	<p style="color:red;">
		<?=$create_response->error->message;?>
	</p>
  
  <?php elseif(isset($create_response->success)): ?>
	
	<p style="color:green;" >
		<?=$create_response->success->message;?>
	</p>
	
		<?php endif; ?>
  
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
	<input name="firstname" type="firstname" placeholder="Nimi"> <?php echo $firstname_error; ?> <br><br>
	<input name="lastname" type="lastname" placeholder="Perekonnanimi"> <?php echo $lastname_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
</body>
</html>