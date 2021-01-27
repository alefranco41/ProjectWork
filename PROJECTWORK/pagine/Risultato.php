<?php

$TDEE = $_POST["TDEE"];
$TDEE = (round($TDEE, 0));



$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>

  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <script src='../js/risultato.js' charset='utf-8'></script>
    <link rel='stylesheet' href='../css/indexStyle.css'>
  </head>

  <body>
    <p>Benvenuto Utente, in base ai dati inseriti, il tuo fabbisogno calorico giornaliero risulta essere di $TDEE kcal </p>
    <p>Per poter usufruire dei nostri servizi, è necessario eseguire il Login</p>
  </body>
  </html>
";

print($html);


 ?>
