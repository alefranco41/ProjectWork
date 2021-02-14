<?php
session_start();
include('../FunzioniPHP/Funzioni.php');

if(array_key_exists("registrati", $_POST)){
  $errori = "";
  if (empty($_POST["nome"])) {
    $errori .= "Il nome è obbligatorio";
  } else {
    $nome = test_input($_POST["nome"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
      $errori .= "Errore nel campo nome";
    }
  }

  if (empty($_POST["cognome"])) {
    $errori .= "Il cognome è obbligatorio";
  } else {
    $cognome = test_input($_POST["cognome"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$cognome)) {
      $errori .= "Errore nel campo cognome";
    }
  }

  if (empty($_POST["email"])) {
    $errori .= "l'Email è obbligatoria";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errori .= "formato email non valido";
    }else{
      $mail = $_POST["email"];
      $sql = "SELECT email FROM utente WHERE email = '$mail'";
    	$righe = eseguiquery($sql);
      if(count($righe)){
        $errori .= "Email già in uso";
      }
    }
  }

  if (empty($_POST["username"])) {
    $errori .= "l'username è obbligatorio";
  } else {
    $username = test_input($_POST["username"]);
    if (!preg_match('/^[a-z\d_]{2,20}$/i', $username)) {
      $errori .= "Errore nel campo username";
    }else{
      $userID = $_POST["username"];
      $sql = "SELECT username FROM utente WHERE username = '$userID'";
    	$righe = eseguiquery($sql);
      if(count($righe)){
        $errori .= "username già in uso";
      }
    }
  }

  if (empty($_POST["password"])) {
    $errori .= "la password è obbligatoria";
  } else {
    $password = test_input($_POST["password"]);
    if (!preg_match('/^(?=.*\d)(?=.*[a-z]).{8,16}$/', $password)) {
      $errori .= "La password non soddisfa i requisiti";
    }else{
      $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
  }

  if($errori == ""){
    echo "ciao";
    $sql = "INSERT INTO utente (username, password, password_hashed, nome, cognome, email) VALUES ('{$_POST['username']}', '{$_POST['password']}', '$hashed_password', '{$_POST['nome']}', '{$_POST['cognome']}', '{$_POST['email']}')";
    eseguiquery($sql);
  }

}

$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>

  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <link rel='stylesheet' href='../css/risultatoStyle.php'>
    <link href='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
    <script src='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  </head>

  <body>
  <div>
  $errori
  </div>
      <div class='wrapper fadeInDown'>
        <div id='formContent'>
        <div class='fadeIn first'>
          Registrazione
        </div>
        <form action='registrati.php' method='post'>
          <input type='text' name='nome' id='nome' class='fadeIn second' placeholder='nome'>
          <input type='text' name='cognome' id='cognome' class='fadeIn second' placeholder='cognome'>
          <input type='text' name='email' id='email' class='fadeIn second' placeholder='email'>
          <input type='text' name='username' id='login' class='fadeIn second' placeholder='username'>
          <input type='password' name='password' id='password' class='fadeIn third' placeholder='password'>
          <input type='submit' name ='registrati' class='fadeIn fourth' value='Registrati'>
        </form>
      </div>
    </div>
  </body>
  </html>";

print($html);


 ?>
