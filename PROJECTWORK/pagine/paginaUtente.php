<?php
session_start();
include('../FunzioniPHP/Funzioni.php');


$query = "https://api.edamam.com/search?q=chicken&app_id=faa0810d&app_key=4f4d26e1dacc3ddb0e32f16acc203356&from=0&to=1&calories=591-722&health=alcohol-free";
$output = chiamataAPI($query);








$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <script src='../js/paginaUtente.js' charset='utf-8'></script>
  </head>

  <body onload='prova()'>
    <input type='hidden' name='jsonarray' value='$output' id='jsonarray'>
  </body>
  </html>
";

print($html);




 ?>
