<?php
	require_once("../functions.php"); // Andmebaasi ühendus

	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}

	$email1_error = "";
	$email2_error = "";
	$password1_error = "";
	$password2_error = "";
	$password3_error ="";
	$firstname_error ="";
	$lastname_error ="";
	$email1 ="";
	$email2 ="";
	$firstname ="";
	$lastname ="";
	$password1 ="";
	$password2 ="";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['login'])){
			if ( empty($_POST["email1"]) ) {
				$email1_error = "See väli on kohustuslik";
			}
			else{
				$email1 = test_input($_POST["email1"]);
			}

			if ( empty($_POST["password1"]) ) {
				$password1_error = "See väli on kohustuslik";	
			}
			else{
				$password1 = test_input($_POST["password1"]);
			}

			if($password1_error == "" && $email1_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email1." ja parool on ".$password1;
				$hash = hash("sha512", $password1);
				loginUser($email1, $hash);
			}
		}elseif(isset($_POST['registreeri'])) {
			if ( empty($_POST["firstname"]) ) {
				$firstname_error = "See väli on kohustuslik";
			}
			else{
				$firstname = test_input($_POST["firstname"]);
			}			
			if ( empty($_POST["lastname"]) ) {
				$lastname_error = "See väli on kohustuslik";
			}
			else{
				$lastname = test_input($_POST["lastname"]);
			}

			if ( empty($_POST["email2"]) ) {
				$email2_error = "See väli on kohustuslik";
			}
			else{
				$email2 = test_input($_POST["email2"]);
			}
			
			if ( empty($_POST["password2"]) ) {
				$password2_error = "See väli on kohustuslik";	
			}
			if ( empty($_POST["password3"]) ) {
				$password3_error = "See väli on kohustuslik";	
			}
			else{	
				if(strlen($_POST["password2"]) < 8) {
					$password2_error ="Peab olema vähemalt 8 sümbolit pikk!";
				}
				else{
					$password2 = test_input($_POST["password2"]);
				}
			}
			
			if ($_POST["password2"] != $_POST["password3"]) {
				$password3_error = "Paroolid ei kattu. Proovi uuesti.";	
			}	
				
			if(	$email2_error == "" && $password2_error == ""){
				$hash = hash("sha512", $password2);
				echo "Võib kasutajat luua! Kasutajanimi on ".$email2." ja parool on ".$password2. "ja räsi on ".$hash;
				createUser($firstname, $lastname, $email2, $hash);
			}	
		}
	} 
		
		
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
		<link rel="stylesheet" type="text/css" href="../style.css">
		<metadata encoding="UTF8">
	</head>
	<body>
		<div class="loginContainer">
			<h2>Log in</h2>
			<form class="form-style-4" action="login.php" method="post">
				<input name="email1" type="email" value="<?php echo $email1 ?>" placeholder="E-post"> <?php echo $email1_error; ?><br>
				<input name="password1" type="password" placeholder="Parool"> <?php echo $password1_error; ?> <br>
				<input type="submit" name="login" value="Log in"><br>
			</form>
			
			<h2>Loo kasutaja</h2>
			<form class="form-style-4" action ="login.php" method="post">
				<input type="text" name="firstname" value ="<?php echo $firstname ?>" placeholder="Eesnimi"><?php echo $firstname_error;?><br>
				<input type="text" name="lastname" value ="<?php echo $lastname ?>" placeholder="Perekonnanimi"><?php echo $lastname_error;?><br>
				<input name="email2" type="email" placeholder="E-post" value ="<?php echo $email2 ?>"><?php echo $email2_error; ?><br>
				<input name="password2" type="password" placeholder="Parool"><?php echo $password2_error; ?><br>
				<input name="password3" type="password" placeholder="Korda parooli"><?php echo $password3_error; ?><br>
				<input type="submit" name="registreeri" value="Registreeri"><br>
			</form>
		</div>
	</body>
</html>