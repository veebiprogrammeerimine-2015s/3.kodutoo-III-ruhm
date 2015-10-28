<?php
	//Home.php
	require_once("functions.php");
	$message= "";
	$message_error= "";
	$array_of_messages = getMessageData();
	$nickname= ($_SESSION["logged_in_user_nickname"]);
	$id= $_SESSION["logged_in_user_id"];
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	if(isset($_GET["logout"])){
			session_destroy();
			header("Location: login.php");
	}
	if(isset($_POST["save"])){
		echo $_POST["message"];
		updateChat($_POST["id"], $_POST["message"]);
	}
	//echo $_SESSION["logged_in_user_id"] = $id_from_db;
	//echo $_SESSION["logged_in_user_email"] = $email_from_db;
	//echo $_SESSION["logged_in_user_nickname"] = $nickname_from_db;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["send"])){
      $message= ($_POST["message"]);
			sendMessage($message, $nickname);
      }
	}
?>
<html>
	<head>
		<title>Home</title>
	</head>
	<body>
		<p>Tere, <?= $nickname;?></p>
		<a href="?logout=1"> Logi välja? <a>
		<h1>Chat window</h1>
		<h2>Tabel</h2>
<table border="1">
<tr>
	<!--<th>id</th>-->
	<th>nickname</th>
	<th>message</th>
	<th>timestamp</th>
	<th>edit</th>
</tr>
<?php
	for($i = 0; $i < count($array_of_messages); $i++){
		if(isset($_GET["edit"]) && $array_of_messages[$i]->id ==$_GET["edit"]){
						echo "<tr>";
						echo "<form method='post' action='home.php'>";
						//echo "<td>".$array_of_messages[$i]->id."</td>";
						echo "<td>".$array_of_messages[$i]->nickname."</td>";
						//echo "<input type='hidden' name='id' value='".$array_of_messages[$i]->id."'";
						echo "<td><input name='message'></td>";
						echo "<td>".$array_of_messages[$i]->timestamp."</td>";
						echo "<td><a href='?cancel=".$array_of_messages[$i]->id."'>cancel</a></td>";
						echo "<td><input type='submit' name='save' value='save'></td>";
						echo "</tr>";
						echo "</form>";
		}
		else{
		echo "<tr>";
		//echo "<td>".$array_of_messages[$i]->id."</td>";
		echo "<td>".$array_of_messages[$i]->nickname."</td>";
		echo "<td>".$array_of_messages[$i]->message."</td>";
		echo "<td>".$array_of_messages[$i]->timestamp."</td>";
		echo "<td><a href='?edit=".$array_of_messages[$i]->id."'>edit</a></td>";
		echo "</tr>";
		}
	}
?>
</table>
		<form action="home.php" method="post">
			<input name="message" type="text" placeholder="Message here...">
			<input name="send" type="submit" value="Send">
		</form>
	</body>
</html>
