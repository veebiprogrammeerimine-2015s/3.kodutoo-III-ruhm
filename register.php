<?php

	require_once("../config.php");
	require_once("hidden/functions.php");
	$database = "if15_hendval";
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	// LOGIN.PHP
	$email_error = "";
	$password_repeat_error = "";
	$password_error = "";
	$name_error = "";
	$age_error = "";
	$username_error = "";
	
	// muutujad andmebaasi väärtuste jaoks
	$email = "";
	$password = "";
	$password_repeat = "";
	$name = "";
	$age = "";
	$username = "";
	
	
	// kontrollime, et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//echo "keegi vajutas nuppu";
		
		//vajutas register nuppu
		
		if(isset($_POST["register"])) {
			
			if(empty($_POST["email"]))  {
				$email_error = "VEATEADE: Email on kohustuslik!";
			} else {
				$email = test_input($_POST["email"]);
			}
			if(empty($_POST["name"])) {
				$name_error = "VEATEADE: Eesnimi on kohustuslik!";
			} else {
				$name = test_input($_POST["name"]);
			}
			if(empty($_POST["age"])) {
				$age_error = "VEATEADE: Vanuse sisestus on kohustuslik!";
			} else {
				$age = test_input($_POST["age"]);
			}
			if(empty($_POST["username"])) {
				$username_error = "VEATEADE: Kasutajanimi on kohustuslik!";
			} else {
				$username = test_input($_POST["username"]);
			}
			if(empty($_POST["password"])) {
				$password_error = "VEATEADE: Parool on kohustuslik!";
			} else {
				//kui oleme siia jõudnud siis parool ei ole tühi
				//kontrollin et olek vähemalt 8 sümbolit pikk
				if(strlen($_POST["password"]) < 8) {
					$password_error = "VEATEADE: Parool peab olema vähemalt 8 tähemärki pikk!";
				}else {
					if($_POST["password"] != $_POST["password_repeat"]) {
						$password_repeat_error = "VEATEADE: Paroolid peavad kattuma!";
					}else{
						
						$password = test_input($_POST["password"]);
					}
					
				}
				
			}
			
			if($email_error == "" && $password_error == "" && $password_repeat_error == "" && $name_error == "" && $age_error == "" && $username_error == ""){
				$hash = hash("sha512", $password);
				createUser($username, $email, $hash, $name, $age);
			}
		}
		
		
	}


	function test_input($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		// tagurpidi kaldkriipsud
		$data = stripslashes($data);
		// teeb htmli tekstiks
		$data = htmlspecialchars($data);
		return $data;
	}



?>
<?php
	$page_title = "Registreerimine";
	$page_file_name = "register.php";
?>
<div id="container">
<div id="header">
<div class="headerblock">
<?php require_once("header.php"); ?>
</div>
<div class="loginblockleft">
<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>" placeholder="Otsing">
	<input type="submit" value="Otsi">
</form>
</div>
<div class="loginblockright">
<div class="loginblockright">
<?php if(isset($_SESSION["logged_in_user_id"])){echo "<span class='login'>Teretulemast ".$_SESSION["logged_in_user_name"]."! <a href='?logout=1'>Logi välja</a><br>Krediit: ".$_SESSION["logged_in_user_credits"]."</span>"; 
} else { echo "<span class='login'><a href='login.php'>Logi sisse</a> / <a href='register.php'>Registreeri</a></span>"; } ?><br>
</div>
</div>
</div>
<div id="content" class="clearfix">
<div id="menu">
<div class="menublockupper">
<?php require_once("menu.php"); ?>
</div>
<?php if(isset($_SESSION["logged_in_user_id"])){
	echo "<div class='menublocklower'><ul><li><a href='data.php'>Seaded</a></li><li><a href='?logout=1'>Logi välja</a></li></ul></div>";
} ?>
</div>
<div id="main">
<div class="mainblock">
<?php require_once("header.php"); ?>
		<h2>Registreeri</h2>
			<form action="register.php" method="post">
				Kasutajanimi:<br>
				<input name="username" type="text" placeholder="Kasutajanimi"> <?php echo $username_error; ?><br>
				Email:<br>
				<input name="email" type="email" placeholder="E-post"> <?php echo $email_error; ?><br>
				Parool:<br>
				<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?><br>
				Parool uuesti:<br>
				<input name="password_repeat" type="password" placeholder="Parool uuesti"> <?php echo $password_error; ?><br>
				Eesnimi:<br>
				<input name="name" type="text" placeholder="Eesnimi"> <?php echo $name_error; ?><br>
				Vanus:<br>
				<input name="age" type="number" step="1" min="1" placeholder="18"> <?php echo $age_error; ?><br><br>
				<input name="register" type="submit" value="Registreeri"><br>
				<?php echo $password_repeat_error; ?>
			</form>
<a href="login.php">Kasutaja olemas? Logi sisse siin!</a>
</div>
</div>
</div>
</div>
<br>
<center>Lehe tegi Hendrik Vallimägi</center>