<?php

	// LOGIN.PHP
	require_once("functions.php");
	
	//kui kasutaja on sisseloginud,siis suunan data.php lehele
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	//muutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$fname_error = "";
	$lname_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$age_error = "";
	$city_error = "";
	
	//muutujad v��rtuste jaoks
	$email = "";
	$password = "";
	$fname = "";
	$lname = "";
	$create_email = "";
	$create_passw = "";
	$age = "";
	$city = "";
	$hash = "";
	
	
	// kontrollime et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		//kontrollin millist nuppu vajutati
		if(isset($_POST["login"])){
		//kontrollin et e-post ei ole t�hi
			if (empty($_POST["email"])){
			$email_error = "see väli on kohustulik";	
			} else {
				$email=test_input($_POST["email"]);
			}
			//kontrollin et parool ei ole t�hi
			if (empty($_POST["password"])){
			$password_error = "see väli on kohustulik";
			} else {
			
				//kui oleme siia j�udnud, siis parool pole t�hi
				if(strlen($_POST["password"]) < 8){
				$password_error="peab olema vähemalt 8 tähemärki";
				} else {
					$password=test_input($_POST["password"]);
				}
			}
			
			// Kui oleme siia j�udnud, v�ime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
			
				$hash = hash("sha512", $password);	
				loginUser($email,$hash);				
			}	
		}
	
	
		//Kasutaja loomine
		if(isset($_POST["submit"])){
		//kontrollin et eesnimi ei ole t�hi
			if (empty($_POST["first_name"])){
				$fname_error = "see väli on kohustulik";
			}else{
				$fname=test_input($_POST["first_name"]);
			}
			if (empty($_POST["last_name"])){
				$lname_error = "see väli on kohustulik";
			}else{
				$lname=test_input($_POST["last_name"]);
			}
			if (empty($_POST["create_email"])){
				$create_email_error = " see väli on kohustulik";			
			} else {
				$create_email=test_input($_POST["create_email"]);
			}
			if (empty($_POST["create_password"])){
				$create_password_error = "see väli on kohustulik";	
			} else {			
				if(strlen($_POST["create_password"]) < 8){
					$create_password_error="peab olema vähemalt 8 tähemärki";
				
				} else{
					$create_password = test_input($_POST["create_password"]);
				//k�ik korras
				//test_input eemaldab pahatahlikud osad
				}
			}	
			if (empty($_POST["age"])){
				$age_error = " see väli on kohustulik";			
			} else {
					$age = intval($age);
				if($age > 5 && $age <100  ){
					$age_error = "Pane sait kohe kinni, oled interneti kasutamiseks liiga noor või liiga vana";
				}else{
					$age=test_input($_POST["age"]);
					}
			}		
			if (empty($_POST["city"])){
				$city_error = " see väli on kohustulik";			
			} else {
				$city=test_input($_POST["city"]);	
				}
		
			if($fname_error =="" && $lname_error =="" && $create_email_error =="" && $create_password_error =="" && $age_error ="" && $city_error ="");
			
				//r�si paroolist, mille salvestame andmebaasi
			$hash = hash("sha512",$create_password);
				
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash.$fname.$lname;
				
				createUser($create_email,$hash,$fname,$lname,$age,$city);
				
						
		}
	}
	
	
function test_input($data) {
	//v�tab �ra t�hikud,enterid jne
	$data = trim($data);
	//v�tab �ra tagurpidi kaldkriipsud
	$data = stripslashes($data);
	//teeb html-i tekstiks
	$data = htmlspecialchars($data);
	return $data;
	}

	

?>
<?php
	$page_title = "Login" ;
	$page_file_name = "login.php";
?>
<?php require_once("../header.php");?>
	<h2>Log in</h2>
	
		<form action="login.php" method="post">
			<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
			<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?> <br><br>
			<input name="login" type="submit" value="log in"> <br><br>
		</form>
		
	<h2>Create user</h2>
	
		<form action="login.php" method="post">
			<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"><?php echo $create_email_error; ?><br><br>
			<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
			<input name="first_name" type="text" placeholder="Eesnimi" value="<?php echo $fname; ?>"> <?php echo $fname_error; ?><br><br>
			<input name="last_name" type="text" placeholder="Perekonnanimi" value="<?php echo $lname; ?>"> <?php echo $lname_error; ?><br><br>
			<input name="age" type="number_format" placeholder="Vanus" value="<?php echo $age; ?>"><?php echo $age_error; ?><br><br>
			<input name="city" type="text" placeholder="Linn" value="<?php echo $city; ?>"><?php echo $city_error; ?><br><br>
			<input name="submit" type="submit" value="Submit"><br><br>
		</form>	
	
<?php require_once("../footer.php");?>