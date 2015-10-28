<?php

	require_once("functions.php");
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}

	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_nickname_error = "";
	$create_name_error = "";
	$create_surname_error = "";
	$create_date_error = "";

  
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_nickname = "";
	$create_name = "";
	$create_surname = "";
	$create_date = "";
	

	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){

			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
        
				$email = cleanInput($_POST["email"]);
			}

			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}

      
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password.". ";
				
				$hash = hash("sha512", $password);
				
				loginUser($email, $hash);
				
			}

		} 

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
			
			if ( empty($_POST["create_nickname"]) ) {
				$create_nickname_error = "See väli on kohustuslik";
			}else{
				$create_nickname = cleanInput($_POST["create_nickname"]);
			}
			
			if ( empty($_POST["create_name"]) ) {
				$create_name_error = "See väli on kohustuslik";
			}else{
				$create_name = cleanInput($_POST["create_name"]);
			}
			
			if ( empty($_POST["create_surname"]) ) {
				$create_surname_error = "See väli on kohustuslik";
			}else{
				$create_surname = cleanInput($_POST["create_surname"]);
			}
			
			if ( empty($_POST["create_date"]) ) {
				$create_date_error = "See väli on kohustuslik";
			}else{
				$create_date = cleanInput($_POST["create_date"]);
			}

			if(	$create_email_error == "" && $create_password_error == "" && $create_nickname_error == "" && $create_name_error == "" && $create_surname_error == "" && $create_date_error == ""){
				
				$hash = hash("sha512", $create_password);
				
				echo "Võib kasutajat luua!"; //Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi (hash) on".$hash;
				
				createUser($create_email, $hash, $create_nickname, $create_name, $create_surname, $create_date);
			}

    } 

	}

  
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
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
	<input name="create_nickname" type="text" placeholder="Nickname" value="<?php echo $create_nickname; ?>"> <?php echo $create_nickname_error; ?> <br><br>
	<input name="create_name" type="text" placeholder="Nimi" value="<?php echo $create_name; ?>"> <?php echo $create_name_error; ?> <br><br>
	<input name="create_surname" type="text" placeholder="Perekonnanimi" value="<?php echo $create_surname; ?>"> <?php echo $create_surname_error; ?> <br><br>
	<input name="create_date" type="text" placeholder="Sünniaasta" value="<?php echo $create_date; ?>"> <?php echo $create_date_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
