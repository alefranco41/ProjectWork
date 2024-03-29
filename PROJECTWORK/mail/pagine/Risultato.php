<?php
session_start();
include('../FunzioniPHP/Funzioni.php');


if(!array_key_exists("TDEE", $_SESSION)){
  $messaggio = "Effettua il Login";
}else{
  $TDEE = $_SESSION['TDEE'];
  if(isset($_SESSION['username'])){
    $utente = $_SESSION['username'];
  }else{
    $utente = "utente";
  }
  $messaggio = "Benvenuto $utente, in base ai dati inseriti, il tuo fabbisogno calorico giornaliero risulta essere di $TDEE kcal";
}

$_SESSION["ERRORE"] = 0;

if(array_key_exists("login", $_POST)){
  $username = $_POST["username"];
  $password = encrypt_decrypt("encrypt", $_POST["password"]);
  $sql = "SELECT username, password FROM utente WHERE username = '$username' AND password = '$password'";
	$righe = eseguiquery($sql);

  if(!count($righe)){
    $_SESSION["ERRORE"] = 1;
    $link = "<a class='underlineHover' href='registrati.php'>Registrati</a>";
    $errori = "utente non riconsciuto, $link";
  }
}else{
  $errori = "";
}
$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>

  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <link rel='stylesheet' href='../css/risultatoStyle.php'>
    <link href='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
    <script src='../js/risultato.js' charset='utf-8'></script>
    <script src='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  </head>

  <body>
    <p>$messaggio</p>
      <div class='wrapper fadeInDown'>
        <div id='formContent'>
          <div class='fadeIn first'>
            $errori
          </div>
        <form action='paginaUtente.php' method='post'>
          <input type='text' name='username' id='login' class='fadeIn second' placeholder='username'>
          <input type='password' name='password' id='password' class='fadeIn third' placeholder='password'>
          <input type='submit' name ='login' class='fadeIn fourth' value='Log In'>
        </form>
        <div id='formFooter'>
          <a class='underlineHover' href='recuperoPass.php'>Recupero Password</a><br>
          <a class='underlineHover' href='registrati.php'>Registrati</a>
        </div>
      </div>
    </div>
  </body>
  </html>";

print($html);
?>
