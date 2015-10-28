<?php
	require_once("functions.php");
	
	
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  
  
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//ainult admin saab uusi kasutajaid luua
	if($_SESSION["logged_in_user_role"] == 9){
		
	
	
	// uue kasutaja loomine
		if(isset($_POST["create"])){
				$create_email_error = "";
				$create_password_error = "";
				$is_admin_error  = "";
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

				if(	$create_email_error == "" && $create_password_error == ""){
					$is_admin = cleanInput($_POST["is_admin"]);
					// räsi paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash;
					
					// kasutaja loomise fn, failist functions.php,
					// saadame kaasa muutujad
					createUser($create_email, $hash, $is_admin);
					
				}
		} // create if end

	}
	else{
	echo "pole oigusi";
	header("Location: login.php");
	}


	
?>

	
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="UTF-8">
</head>
<body>


  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br>
  	<input name="is_admin" type="text" placeholder="admin siis sisesta 9"> <?php echo $is_admin_error; ?>  <br>
  	<br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>

<html>
