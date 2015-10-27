
<?php
	
	// LOGIN.PHP
	
	// loon andmebaasi ühenduse
	require_once("functions.php");
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	
	// muutujad errorite jaoks
	$name_error = "";
	$email_error = "";
	$password_error = "";
	$create_password_error = "";
	$create_email_error = "";
	
	//muutujad andmebaasi väärtuste jaoks
	
	$email = "";
	$username = "";
	$fullname ="";
	$create_email="";
	
	//kontrollime, et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// LOGI SISSE
		
		if (isset($_POST["login"])) {
			
			//kontrollin, et e-post ei ole tühi
			if (empty($_POST["email"])) {
				$email_error = "See väli on kohustuslik";
				
			}else{
				$email = test_input($_POST["email"]);
			}
				
			//kontrollin, et parool ei ole tühi
			if (empty($_POST["password"])) {
				$password_error = "See väli on kohustuslik";
			} else {
				$password = test_input($_POST["password"]);				
			}
			
			// võib sisse logida
			
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$hash = hash("sha512", $password);
				
				loginUser($email, $hash);
				
			}
			
		}
		
		// LOO KASUTAJA
		
		elseif (isset($_POST["create"])) //registration field errors
		{
			
			
			if (empty($_POST["username"])) {
				$name_error = "See väli on kohustuslik";	
			} else {
				$username = test_input($_POST["username"]);
			}
			
			
			
			
			if (empty($_POST["fullname"])) {
				$name_error = "See väli on kohustuslik";	
			} else {
				$fullname = test_input($_POST["fullname"]);
			}
			
			
			
			
			
			if (empty($_POST["create_email"])) {
				$create_email_error = "See väli on kohustuslik";
				
			}else{
				
				$create_email = test_input($_POST["create_email"]);
			}
			
			
			
			if (empty($_POST["create_password"])) {
				$create_password_error = "See väli on kohustuslik";
			
				
			}else{
				if(strlen($_POST["create_password"]) <8) {
					
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk";
				
				}else{
					$create_password = test_input($_POST["create_password"]);
				}
				
			}
			
			if ($name_error == ""){
				echo "salvestasin andmebaasi ".$username;
			}
			
			if(	$create_email_error == "" && $create_password_error == "" && $name_error == ""){
				
				$hash = hash("sha512", $create_password);
				echo "Kasutaja on loodud! Registreeritud e-mail on ".$create_email.", kasutajanimi on ".$username." ja parool on ".$create_password."ja räsi on ".$hash;
				createUser($create_email, $hash, $username, $fullname);
				
			}
			
		}
		
	}	
	
	function test_input($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		//tagurpidi kaldkriipsud
		$data = stripslashes($data);
		//teeb html'i tekstiks
		$data = htmlspecialchars($data);
		return $data;
	}
	
		
	
?>
<?php
	$page_title = "Kasutaja leht";
	$page_file_name = "login.php"
?>	


<html>
<head>
	<title>Kasutaja leht</title>
</head>
<body>
	<FONT FACE="arial">
	
	<h2>Logi sisse</h2>
	
	<form action="login.php" method="post">
		<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?> <br><br>
		<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?> <br><br>
		<input type="submit" name="login" value="Logi sisse">
	</form>	
		
	<h2>Loo kasutaja</h2>
	
	<form action="login.php" method="post">
		<input name="fullname" type="text" placeholder="Täisnimi" value="<?php echo $fullname; ?>"> <?php echo $name_error; ?> <br><br>
		<input name="username" type="name" placeholder="Kasutajanimi" value="<?php echo $username; ?>"> <?php echo $name_error; ?> <br><br>
		<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?> <br><br>
		<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
		<input name="create" type="submit" value="Sisesta">
	</form>	
	
	</FONT>
	
</body>

</html>
