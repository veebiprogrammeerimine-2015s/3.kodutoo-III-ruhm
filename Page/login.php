<?php


	// Loon andmebaasi ühenduse
	require_once("../../config.php");
	$database= "if15_mats_3";
	$mysqli = new mysqli($servername, $username, $password, $database);

		// LOGIN.PHP
		//echo $_POST["email"];
		//echo $_POST["password"];
		// errori muutujad peavad igal juhul olemas olema
		$email_error = "";
		$password_error= "";	
		$username_error= "";
		$create_email_error= "";
		$create_password_error="";
		
		//muutujad andmebaasi väärtuste jaoks
		$username= "";
		$email= "";
		$password="";
		$create_password="";
		$create_email="";
		
		
		//kontrollime et keegi vajutas input nuppu
		if($_SERVER["REQUEST_METHOD"] == "POST")  {
			//echo "keegi vajutas nuppu";
			
			//vajutas login nuppu
			if(isset($_POST["login"])){	
				
				
				
			
				//kontrollin et e-post ei oleks tühi
				
				if (empty($_POST["email"]) ) {
					$email_error = "See väli on kohustuslik";
				}else{
					$email = test_input($_POST["email"]);
					
				}
				
				//kontrollin, et parool ei ole tühi
				if (empty($_POST["password"]) ) {
					$password_error= "Kirjuta parool";
				} else {
					// kui oleme siia jõudnud, siis parool ei ole veel tühi
					// kontrollin
					if(strlen($_POST["password"]) < 8) {
					$password_error= "Peab olema vähemalt 8 tähemärki pikk"; 
					}else{
						
						$password = test_input($_POST["password"]);
					}
					
				}
			
			if($email_error== "" && $password_error == "") {
				
				
				
				$hash= hash("sha512", $password);
				$stmt = $mysqli->prepare ("SELECT id, email FROM creatednames WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $hash);
				
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute ();
				if($stmt->fetch()){
					
					//andmebaasis oli midagi
					echo "Email ja parool õiged, kasutaja id=".$id_from_db;
				}else{
					//ei leidnud
					echo  "Wrong credentials";
				}
				
				$stmt->close();
				
			}
			
			
			
			
			
			// keegi vajutas create nuppu	
			}elseif(isset($_POST["create"])){
			
				echo "vajutas create nuppu";
				
				if (empty($_POST["username"]) ) {
					$username_error = "Kirjuta oma kasutajanimi";
				
					
				}else{
					$username=test_input($_POST["username"]);
				}
				
				
		
				
				
				if (empty($_POST["create_email"]) ) {
					$create_email_error = "Kirjuta oma email";
				}else{
					$create_email = test_input($_POST["create_email"]);
					
				}
				
				
				if (empty($_POST["create_password"]) ) {
					$create_password_error= "Kirjuta parool";
				} else {
				
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error= "Peab olema vähemalt 8 tähemärki pikk"; 
					}else{
						
						$create_password = test_input($_POST["create_password"]);
					}
					
				}
				
				
			
		
				if ($create_email_error=="" && $create_password_error=="" && $username_error=="" ){
						
						$hash= hash("sha512", $create_password);
						
						echo "Võib kasutajat luua! Kasutajanimi on ".$username." email on ".$create_email. "ja parool on ".$create_password." ja räsi on ".$hash;
						
						$stmt = $mysqli->prepare("INSERT INTO creatednames (user,email,password) VALUES (?,?,?)");
						echo $mysqli->error;
						echo $stmt->error;
						$stmt->bind_param("sss", $username, $create_email, $hash);
						$stmt->execute();
						$stmt->close();
					
					
				}
				
			}
			
		}
		
	function test_input($data) {
		// võtab ära tühikud, enterid, tabid
	$data = trim($data);
	   // tagurpidi kaldkriipsud
	$data = stripslashes($data);
	 // teeb html tekstiks < läheb &lt;
	$data = htmlspecialchars($data);
	return $data;
	}
	$mysqli->close();
?>
<?php
	$page_title = "Sisselogimise leht";
	$page_file_name="login.php";

?>
<?php require_once("../header.php"); ?>

	<h2>Login</h2>
		<form action="login.php" method="post" >
			<input name="email" type="email" placeholder="E-post" value="<?php echo $email;?>"><?php echo $email_error; ?><br><br>
			<input name="password" type="password" placeholder="Parool"><?php echo $password_error;?> <br><br>
			<input name="login" type="submit" value="Log in"> 
		</form>
		
	<h2>Loo kasutaja</h2>
		<form action="login.php" method="post"> 
			<input name="username" type="text" placeholder="Kasutaja"><?php echo $username_error; ?><br></br>  
			<input name="create_email" type="email" placeholder="E-post"><?php echo $create_email_error;?> <br></br>
			<input name="create_password" type="password" placeholder="Parool"><?php echo $create_password_error;?> <br></br>
			<input name="create" type="submit" value="Loo kasutaja">
		</form>
<?php require_once("../footer.php"); ?>	