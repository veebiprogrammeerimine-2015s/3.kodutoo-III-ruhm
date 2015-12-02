<?php
   require_once("functions.php");
   if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//addressireal on olemas muutuja logout
		//kustutame kõik sessioonimuutujad
		session_destroy();
		header("Location: login.php");
	}
   $post="";
   $post_error= "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {

   
		if(isset($_POST["add_post"])){

			if ( empty($_POST["post"])) {
				$post_error = "See väli on kohustuslik";
			}else{
        
				$post = cleanInput($_POST["post"]);
			}

			
     
			if($post_error == "") {
				echo "Salvestatud!";
				$msg= createPost($post);
				
				if($msg !=""){
					//õnnestus, teeme inputi väljad tühjaks
					$post="";
					
					
					echo $msg;
				}
				
			}
		}		
   
	   
	 
	   
	   
   }
   function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
	
	
   
 ?> 
 <a href="poststable.php">Posituste vaatamine</a>
 <p>Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja <a>
</p>

<h2>Lisa postitus </h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="post">Postitus</label><br>
  	<input id="post" name="post" type="text"  value="<?php echo $post; ?>"> <?php echo $post_error; ?><br><br>
	
  	<input type="submit" name="add_post" value="Salvesta">
  </form>	