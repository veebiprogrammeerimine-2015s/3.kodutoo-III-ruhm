<?php
  require_once("../config_global.php");
  $database = "if15_robing_3";
  session_start();

  //Kasutaja loomine
  function registerUser($email_reg, $password_reg, $nickname){
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO IRC (email, password, nickname) VALUES (?,?,?)");
    $stmt->bind_param("sss", $email_reg, $password_reg, $nickname);
    $stmt->execute();
    $stmt->close();

  }
  function loginUser($email, $password){

    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT id, email, nickname FROM IRC WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->bind_result($id_from_db, $email_from_db, $nickname_from_db);
    $stmt->execute();
    if($stmt->fetch()){
      $_SESSION["logged_in_user_id"] = $id_from_db;
      $_SESSION["logged_in_user_email"] = $email_from_db;
      $_SESSION["logged_in_user_nickname"] = $nickname_from_db;
      header("Location: home.php");
    }
    else{
      echo "Valed andmed";
    }
  }
  function sendMessage($message, $email, $nickname){
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO chat (message, email, nickname) VALUES (?,?,?)");
    $stmt->bind_param("sss", $message, $email, $nickname);
    $stmt->execute();
    $stmt->close();
  }



?>
