<?php
include('../FunzioniPHP/Funzioni.php');
session_start();
if(!array_key_exists("login", $_POST)){
  $length = 0;
  $tabella = "";
  if(array_key_exists('username', $_SESSION)){
    $u = $_SESSION["username"];
    $p = $_SESSION["password"];
    $sql = "SELECT * FROM utente WHERE username = '$u' AND password = '$p'";
    $righe = eseguiquery($sql);
    if(count($righe) == 0){
      header('Location: risultato.php');
    }
  }else{
    header('Location: risultato.php');
  }
}
else{
  $u = $_POST["username"];
  $p = encrypt_decrypt("encrypt", $_POST["password"]);
  $_SESSION["username"] = $u;
  $_SESSION["password"] = $p;
  $sql = "SELECT * FROM utente WHERE username = '$u' AND password = '$p'";
  $righe = eseguiquery($sql);
  if(count($righe) == 0){
    header('Location: risultato.php');
  }
}




$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <script src='../js/paginaUtente.js' charset='utf-8'></script>
    <link rel='stylesheet' href='../css/paginaUtente.css'>
  </head>

  <body>
    <a href='dieta.php'>Crea il tuo piano alimentare</a><br>
    <a href='allenamento.php'>Crea il tuo piano d'allenamento</a><br>
    <a href='logout.php'>Logout</a>
  </body>
  </html>
";

print($html);




 ?>
