<?php

	// LOGIN.PHP
	
	require_once("functions.php");
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}

	$email_error = "";
	$password_error = "";
	$firstname_error = "";
	$lastname_error = "";
	$create_email = "";
	$create_email_error = "";
	$create_email_confirm = "";
	$create_email_confirm_error = "";
	$create_password = "";
	$create_password_error = "";
	$create_password_confirm = "";
	$create_password_confirm_error = "";
	$firstname = "";
	$lastname = "";
	$login_email = "";
	$login_password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"])){ 
			
			echo "vajutas login nuppu!";

			if ( empty($_POST["email1"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
				$login_email = test_input($_POST["email1"]);
			}
			
			if ( empty($_POST["password1"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				
				if(strlen($_POST["password1"]) < 8) { 
				
					$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}else{
					$login_password = test_input($_POST["password1"]);
				}
				
			}
			
			if($email_error == "" && $password_error ==""){
				
				echo "kontrollin sisselogimist ".$login_email." ja parool ";
			}
		
		
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$login_email." ja parool on ".$login_password;
				
				$hash = hash("sha512", $login_password);
				
				echo $hash;
				
				loginUser($login_email, $hash);
			}
		}
		
		elseif(isset($_POST["create"])){
			
			echo "vajutas create nuppu!";
			
			//valideerimine create user vormile
			//kontrollin et e-post ei ole tühi
			if ( empty($_POST["firstname"]) ) {
				$firstname_error = "See väli on kohustuslik";
			}else{
				$firstname= test_input($_POST["firstname"]);
			}
			
			if ( empty($_POST["lastname"]) ) {
				$lastname_error = "See väli on kohustuslik";
			}else{
				$lastname = test_input($_POST["lastname"]);
			}
			
			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				
				$create_email = test_input($_POST["create_email"]);
			}
			
			if ( empty($_POST["create_email_confirm"]) ) {
				$create_email_confirm_error = "See väli on kojustuslik";
			}else{
				$create_email_confirm = test_input($_POST["create_email_confirm"]);
			}
			
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				
				if(strlen($_POST["create_password"]) < 8) { 
				
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}else{
					$create_password = test_input($_POST["create_password"]);
				}
			}
				
			if ( empty($_POST["create_password_confirm"]) ) {
				$create_password_confirm_error = "See väli on kohustuslik";
			}else {
				
				if(strlen($_POST["create_password_confirm"]) < 8) { 
				
					$create_password_confirm_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}else{
					$create_password_confirm = test_input($_POST["create_password_confirm"]);
				}
			}
				if(	$create_email_error == "" && $create_password_error == ""){
					
				$hash = hash("sha512", $create_password);
				
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password. " ja räsi on".$hash;
				
				createUser($create_email, $hash, $firstname, $lastname);
		  }
		}
		
		
		
	}
	// eemaldab tahapahtlikud osad
	function test_input($data) {
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 return $data;
	}
	
?>
<html>
<head>
	<title>Login page</title>
</head>
<body>
	<h2>Log in</h2>
	
		<form action="newfile.php" method="post" >
			<input name="email1" type="email" placeholder="Email"> <?php echo $email_error; ?><br><br>
			<input name="password1" type="password" placeholder="Password"> <?php echo $password_error; ?><br><br>
			<input name="login" type="submit" value="Log in">
		</form>
		
	<h2>Create user</h2>
		<form action="newfile.php" method="post" >
			<input name="firstname" type="name" placeholder="First name"> <?php echo $firstname_error; ?>*<br><br>
			<input name="lastname" type="name" placeholder="Last name"> <?php echo $lastname_error; ?>*<br><br>
			<?php
			echo "<select name='sel_date'>";
			$i = 1;
			while ($i <= 31) {
				echo "<option value='" . $i . "'>$i</option>";
				$i++;
			}
			echo "</select>";
			echo "<select name='sel_month'>";
			$month = array(
				"Jan",
				"Feb",
				"Mar",
				"Apr",
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec"
			);
			foreach ($month as $m) {
				echo "<option value='" . $m . "'>$m</option>";
			}
			echo "</select>";
			echo "<select name='sel_year'>";
			$j = 1920;
			while ($j <= 2015) {
				echo "<option value='" . $j . "'>$j</option>";
				$j++;
			}
			echo "</select>";
			?><br><br>
			<input name="create_email" type="email" placeholder="Email"> <?php echo $create_email_error; ?>*<br><br>
			<input name="create_email_confirm" type="email" placeholder="Re-enter email"> <?php echo $create_email_confirm_error; ?>*<br><br>
			<input name="create_password" type="password" placeholder="Password"> <?php echo $create_password_error; ?>*<br><br>
			<input name="create_password_confirm" type="password" placeholder="Password"> <?php echo $create_password_confirm_error; ?>*<br><br>
			<input name="create" type=<a href="data.php">submit</a> value="Create">
		</form>
		
		<form>
		Minu idee on selline, et teha päeviku, kus saab salvestada oma mõtted, ideed ja tuleviku plaanid, et pärast neid ei
		unusta või lihtsalt kirjutada oma elust, et pärast lugeda parimatest momentidest ja näidata oma lugud näiteks oma tuleviku lapsele.
		Seda päeviku võib ka kasutada nagu blogi ja jagada postitused sõpradele... Postitusel võib olla tekst, pildid, videod
		või muusika...
		</form>
</body>
</html>