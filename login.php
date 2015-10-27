<?php
  //login leht
  require_once("functions.php");
  if(isset($_SESSION["logged_in_user_id"])){
    header("Location: home.php");
  }
  // Errorid
  $email_error= "";
  $password_error= "";
  $email_error_reg= "";
  $password_error_reg= "";
  $nickname_error= "";
  // Väärtused
  $email= "";
  $password= "";
  $email_reg= "";
  $password_reg= "";
  $nickname= "";

  //Sisse logimis kontroll
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["login"])){
      if(empty($_POST["email"])){
        $email_error= "Kohustuslik väli";
      }
      else{
        $email= ($_POST["email"]);
      }
      if(empty($_POST["password"])){
        $password_error= "Kohustuslik väli";
      }
      else{
        $password= ($_POST["password"]);
      }
      if($email_error== "" && $password_error== ""){
        session_start();
        //$hashed = hash("sha512", $password);
        loginUser($email, $password);
      }
    }

    //Registreerumine
    elseif(isset($_POST["register"])){
      if(empty($_POST["email_reg"])){
        $email_error_reg= "Kohustuslik väli";
      }
      else{
        $email_reg= ($_POST["email_reg"]);
      }
      if(empty($_POST["password_reg"])){
        $password_error_reg= "Kohustuslik väli";
      }
      else{
        //if(strlen($_POST["password_reg"]) < 4){
        //  $password_error_reg= "Password too short, 4 symbols required.";
        //}
        //else{
          $password_reg = ($_POST["password_reg"]);
        //}
      }
      if(empty($_POST["nickname"])){
        $nickname_error= "Kohustuslik väli";
      }
      else{
        $nickname= ($_POST["nickname"]);
      }
      if($email_error_reg== "" && $password_error_reg== "" && $nickname_error== ""){
        //$hashed= ("sha512", $password);
        registerUser($email_reg, $password_reg, $nickname);
      }
    }
  }
?>
<html>
  <head>
    <title>Login Leht</title>
  </head>
  <body>
    <h3>Login here</h3>
    <form action="login.php" method="post">
      <input name="email" type="email" placeholder="Email"><?php echo $email_error; ?><br><br>
      <input name="password" type="password" placeholder="Password"><?php echo $password_error; ?><br><br>
      <input name="login" type="submit" value="Log in">
    </form>
    <h3>Register</h3>
    <form action="login.php" method="post">
      <input name="email_reg" type="email" placeholder="Email"><?php echo $email_error_reg; ?><br><br>
      <input name="password_reg" type="password" placeholder="Password"><?php echo $password_error_reg; ?><br><br>
      <input name="nickname" type="text" placeholder="Nickname"><?php echo $nickname_error; ?><br><br>
      <input name="register" type="submit" value="Register">
    </form>
</html>
