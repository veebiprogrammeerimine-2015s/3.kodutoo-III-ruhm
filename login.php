<?php
 		
 	// kõik funktsioonid, kus tegeleme AB'iga
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
	$first_name_error = "";
	$last_name_error = "";
   // muutujad väärtuste jaoks
 	$email = "";
 	$password = "";
 	$create_email = "";
 	$create_password = "";
	$first_name = "";
	$last_name = "";
 	if($_SERVER["REQUEST_METHOD"] == "POST") {
 		// *********************
 		// **** LOGI SISSE *****
 		// *********************
 		if(isset($_POST["login"])){
 			if ( empty($_POST["email"]) ) {
 				$email_error = "This field is obligatory!";
 			}else{
 			// puhastame muutuja võimalikest üleliigsetest sümbolitest
 				$email = cleanInput($_POST["email"]);
 			}
 			if ( empty($_POST["password"]) ) {
 				$password_error = "This field is obligatory!";
 			}else{
 				$password = cleanInput($_POST["password"]);
 			}
 			// Kui oleme siia jõudnud, võime kasutaja sisse logida
 			if($password_error == "" && $email_error == ""){
 				echo "Ready to log in! Username is ".$email. " and password is " .$password;
 			
 				$hash = hash("sha512", $password);
 				
 				// kasutaja sisselogimise fn, failist functions.php
 				loginUser($email, $hash);
 				
 				function hello($name){
 					echo $name;
 				}
 			}
 		} // login if end
 		// *********************
 		// ** LOO KASUTAJA *****
 		// *********************
		if(isset($_POST["create"])){		
			if (empty($_POST["email_create"])){
				$create_email_error = "This field is obligatory, you cannot leave it empty";
			}else{
				$create_email = cleanInput($_POST["email_create"]);
			}	
			
			if (empty($_POST["password_create"])){
				$create_password_error = "This field is obligatory, you cannot leave it empty";
			}else{
				if(strlen($_POST["password_create"]) <8) {
				$password_error_create = "Password is too short, it has to be at least 8 characters long!";
				}else{
				$password_create = cleanInput($_POST["password_create"]);
				}
			}
		
			if (empty ($_POST["first_name"])){
				$first_name_error = "This field is obligatory, you cannot leave it empty";
			}else{
				$first_name = cleanInput($_POST["first_name"]);
			}
			
			if (empty ($_POST["last_name"])){
				$last_name_error = "This field is obligatory, you cannot leave it empty";
			}else{
				$last_name = cleanInput($_POST["last_name"]);
			}
			
			if( $create_email_error== "" && $create_password_error=="" && $first_name_error=="" && $last_name_error==""){
					
				$hash = hash("sha512", $password_create);
				echo "Ready to create the user! The username is ".$create_email." and password is  ".$create_password." and hash is ".$hash;
			
				createUser($create_email, $hash, $first_name, $last_name);
			}
		}
 	}
   // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
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
		<input name="email" type="email" placeholder="E-mail" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
		<input name="password" type="password" placeholder="Password" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
		<input type="submit" name="login" value="Log in">
   </form>
 
	<h2>Create user</h2>
		
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input name="email_create" type="email" placeholder="e-mail" >*<?php echo $create_email_error; ?> <br><br>
		<input name="password_create" type="password" placeholder="password" >*<?php echo $create_password_error; ?> <br><br><br><br>
		<input name="first_name" type="text" placeholder="first name" >* <?php echo $first_name_error; ?> <br><br>
		<input name="last_name" type="text" placeholder="last name" >* <?php echo $last_name_error; ?> <br><br>
		<input name="create" type="submit" value="Create user" >
	</form>	
 </body>
 </html> 