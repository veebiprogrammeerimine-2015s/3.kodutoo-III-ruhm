<?php

	// LOGIN.PHP
	
	require_once("../../config.php");
	$database = "if15_ruzjaa_3";
	$mysqli = new mysqli($servername, $username, $password, $database);
	
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
	$email = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"])){ 
			
			echo "vajutas login nuppu!";

			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}
			
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				
				if(strlen($_POST["password"]) < 8) { 
				
					$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}
				
			}
			
			if($email_error == "" && $password_error ==""){
				
				echo "kontrollin sisselogimist ".$email." ja parool ";
			}
		
		
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$hash = hash("sha512", $password);
				
				$stmt = $mysqli->prepare("SELECT id, email FROM newfile WHERE email=? AND password=?");
				echo $mysqli->error;
				$stmt->bind_param("ss", $email, $hash);
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				if($stmt->fetch()){
					echo "Email ja parool oiged, kasutaja id=".$id_from_db;
				}else{
					echo "Wrong redentials";
				}
				
				$stmt->close();
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
			}
			
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				
				if(strlen($_POST["create_password"]) < 8) { 
				
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}
			}
				
			if ( empty($_POST["create_password_confirm"]) ) {
				$create_password_confirm_error = "See väli on kohustuslik";
			}else {
				
				if(strlen($_POST["create_password_confirm"]) < 8) { 
				
					$create_password_confirm_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}
			}
				if(	$create_email_error == "" && $create_password_error == ""){
					
				$hash = hash("sha512", $create_password);
				
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password. " ja räsi on".$hash;
				
				$stmt = $mysqli->prepare("INSERT INTO newfile (email, password, firstname, lastname) VALUES (?,?,?,?)");
				echo $mysqli->error;
				echo $stmt->error;
				$stmt->bind_param("ssss", $create_email, $hash, $firstname, $lastname);
				$stmt->execute();
				$stmt->close();
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
	$mysqli->close();
?>
<html>
<head>
	<title>Login page</title>
</head>
<body>
	<h2>Log in</h2>
	
		<form action="newfile.php" method="post" >
			<input name="email" type="email" placeholder="Email"> <?php echo $email_error; ?><br><br>
			<input name="password" type="password" placeholder="Password"> <?php echo $password_error; ?><br><br>
			<input name="login" type="submit" value="Log in">
		</form>
		
	<h2>Create user</h2>
		<form action="newfile.php" method="post" >
			<input name="firstname" type="name" placeholder="First name"> <?php echo $firstname_error; ?>*<br><br>
			<input name="lastname" type="name" placeholder="Last name"> <?php echo $lastname_error; ?>*<br><br>
			<?php
			// Число
			echo "<select name='sel_date'>";
			$i = 1;
			while ($i <= 31) {
				echo "<option value='" . $i . "'>$i</option>";
				$i++;
			}
			echo "</select>";
			// Месяц
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
			// Год
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
			<input name="create" type="submit" value="Create">
		</form>
		
		<form>
		Minu idee on selline, et teha päeviku, kus saab salvestada oma mõtted, ideed ja tuleviku plaanid, et pärast neid ei
		unusta või lihtsalt kirjutada oma elust, et pärast lugeda parimatest momentidest ja näidata oma lugud näiteks oma tuleviku lapsele.
		Seda päeviku võib ka kasutada nagu blogi ja jagada postitused sõpradele... Postitusel võib olla tekst, pildid, videod
		või muusika...
		</form>
</body>
</html>