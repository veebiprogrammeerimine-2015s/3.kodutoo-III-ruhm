<?php
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		// see  katkestab faili edasise lugemise
		exit();
	}
	
	if(isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
	}
	
	//********************
	// Faili üleslaadimine
	//********************
	
	$target_dir = "profile_pics/";
	
	// profile_pics/1.jpg
	$target_file = $target_dir.$_SESSION["logged_in_user_id"].".jpg";
	
	if(isset($_POST["submit"])) {
	
		
		
		
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
	
		
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size - 500000 = ~500kB
		if ($_FILES["fileToUpload"]["size"] > 1024000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				
				//see koht ab'i salvestamiseks
				
				header("Location: data.php");
			
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		
	} // endif post submit
	
	
	
	// kustuta pilt
	
	if(isset($_GET["delete"])){
		
		unlink($target_file);
		
		header("Location: data.php");
		
	}
	
	
	
	
	
	
	
	
?>

<?php if(isset($_SESSION["login_success_message"])): ?>
	
	<p style="color:green;" >
		<?=$_SESSION["login_success_message"];?>
	</p>

<?php 
	//kustutan selle sõnumi pärast esimest näitamist
	unset($_SESSION["login_success_message"]);
	
	endif; ?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>
<html>
  <head>
  <h1>Amazing search</h1>
    <script src="https://www.google.com/jsapi"
        type="text/javascript"></script>
    <script type="text/javascript">
      google.load("search", "1");

      // Call this function when the page has been loaded
      function initialize() {
        var searchControl = new google.search.SearchControl();
        searchControl.addSearcher(new google.search.WebSearch());
        searchControl.addSearcher(new google.search.NewsSearch());
        searchControl.draw(document.getElementById("searchcontrol"));
      }
      google.setOnLoadCallback(initialize);
    </script>

  </head>
  <body>
    <div id="searchcontrol"></div>
  </body>

</html>
<html>
<head>
<title>search</title>
</head>
<body>
<form action='search.php' method='GET'>
<left>
<h1>Search</h1>
<input type='text' size='20' name='search'></br></br>
<input type='submit' name='submit' value='Search!' ></br></br></br>
</left>
</form>
</body>
</html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<center>
<h1>Comment</h1>
</center>
</head>
 
<body>
<center>
<form action="../commentindex.php" method="POST">
<table>
<tr><td>Name: <br><input type="text" name="name"/></td></tr>
<tr><td colspan="2">Comment: </td></tr>
<tr><td colspan="5"><textarea name="comment" rows="10" cols="50"></textarea></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Comment"></td></tr>
</table>
</form>

