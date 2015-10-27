<?php
	//Home.php
	$message= "";
	$message_error= "";
	$email= $_SESSION["logged_in_user_email"];
	$nickname= $_SESSION["logged_in_user_nickname"];
	session_start();
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	if(isset($_GET["logout"])){
			echo "Logout";
			//aadressireal on olemas muutuja logout

			//kustutame kõik session muutujad ja peatame sessiooni
			session_destroy();

			header("Location: login.php");
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST[send])){
      if(empty($_POST["message"])){
        $message_error= "Pole midagi saata";
      }
      else{
        $message= ($_POST["message"]);
				sendMessage($message, $email, $nickname);
      }
		}
	}
?>
<html>
	<head>
		<title>Home</title>
	</head>
	<body>
		<p>Tere, <?= $_SESSION["logged_in_user_email"];?></p>
		<p>Nickname on <?= $_SESSION["logged_in_user_nickname"];?></p>
		<a href="?logout=1"> Logi välja? <a>
		<h1>Chat window</h1>
		<p>CHATHERE</p>
		<form action="login.php" method="post">
			<input name="message" type="text" placeholder="Message here...">
			<input name="send" type="submit" value="Send">
		</form>
	</body>
</html>
