<?php
	//Home.php
	require_once("functions.php");
	$message= "";
	$message_error= "";
	
	$nickname= ($_SESSION["logged_in_user_nickname"]);
	$id= $_SESSION["logged_in_user_id"];
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	if(isset($_GET["logout"])){
			session_destroy();
			header("Location: login.php");
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["save"])){
			echo "Save vajutatud!";
			updateChat($_POST["id"], $_POST["message"]);
		}
	}
	$keyword = "";	
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$array_of_messages = getMessageData($keyword);
		
	}else{
		$array_of_messages = getMessageData();
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["send"])){
		//echo ($_POST["message"]);
		$message= ($_POST["message"]);
		$id= ($_POST["id"]);
		echo $id;
		echo $message;
		updateChat($message, $id);
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
		<form action="home.php" method="get" >
			<input type="search" name="keyword" value="<?=$keyword;?>" >
			<input type="submit" value="Search">
		</form>
		<h1>Chat window</h1>
		<h2>Tabel</h2>
		<table border="1">
		<tr>
			<!--<th>id</th>-->
			<th>Nickname</th>
			<th>Message</th>
			<th>Timestamp</th>
			<th>Edit</th>
		</tr>
		<?php
			for($i = 0; $i < count($array_of_messages); $i++){
				if(isset($_GET["edit"]) && $array_of_messages[$i]->id ==$_GET["edit"]){
					echo "<tr>";
					echo "<form method='post' action='home.php'>";
					//echo "<td>".$array_of_messages[$i]->id."</td>";
					echo "<td>".$array_of_messages[$i]->nickname."</td>";
					echo "<input type='hidden' name='id' value='".$array_of_messages[$i]->id."'>";
					echo "<td><input name='message'></td>";
					echo "<td>".$array_of_messages[$i]->timestamp."</td>";
					echo "<td><a href='?cancel=".$array_of_messages[$i]->id."'>cancel</a></td>";
					echo "<td><input type='submit' name='send' value='save'></td>";
					echo "</form>";
					echo "</tr>";
					
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
