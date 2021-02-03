<?php
session_start();
include('../FunzioniPHP/Funzioni.php');

$TDEE = (round($_SESSION["TDEE"], 0));
$_SESSION["ERRORE"] = 0;

if(array_key_exists("login", $_POST)){
  $username = $_POST["username"];
  $password = $_POST["password"];
  $sql = "SELECT username, password FROM utente WHERE username = '$username' AND password = '$password'";
	$righe = eseguiquery($sql);

  if(count($righe)){
    header('Location: paginaUtente.php');
  }else{
    $_SESSION["ERRORE"] = 1;
    $link = "<a class='underlineHover' href='#'>Registrati</a>";
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
    <p>Benvenuto Utente, in base ai dati inseriti, il tuo fabbisogno calorico giornaliero risulta essere di $TDEE kcal </p>
    <p>Per poter usufruire dei nostri servizi, è necessario eseguire il Login</p>




      <div class='wrapper fadeInDown'>
        <div id='formContent'>
          <div class='fadeIn first'>
            $errori
          </div>
        <form action='Risultato.php' method='post'>
          <input type='text' name='username' id='login' class='fadeIn second' name='login' placeholder='username'>
          <input type='password' name='password' id='password' class='fadeIn third' name='login' placeholder='password'>
          <input type='submit' name ='login' class='fadeIn fourth' value='Log In'>
        </form>
        <div id='formFooter'>
          <a class='underlineHover' href='#'>Recupero Password</a><br>
          <a class='underlineHover' href='#'>Registrati</a>
        </div>
      </div>
    </div>
  </body>
  </html>";

print($html);


 ?>
