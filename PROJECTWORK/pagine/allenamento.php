<?php
include('../FunzioniPHP/Funzioni.php');

  if(array_key_exists("invia", $_POST)){
    $authed = jwt_auth_for_token("alessandrofexrx", "Ckptn63w");
    $authed = (array) $authed;
    $token = $authed["token"];
    $nodes = array("http://204.235.60.194/exrxapi/v1/allinclusive/exercises", "http://204.235.60.194/exrxapi/v1/allinclusive/exercises");
    $res = jwt_request($token, $global_get_params, $nodes);
    $res = (array) $res;
    $res = json_encode($res);
    $jsonFile = "../json/chiamataAllenamento.json";
    file_put_contents($jsonFile, $res);
  }

  $html = "<!DOCTYPE html>
    <html lang='en' dir='ltr'>
    <head>
      <meta charset='utf-8'>
      <title>ProjectWork</title>
      <script src='../js/allenamento.js' charset='utf-8'></script>
    </head>

    <body>
    <a href='paginaUtente.php'>Torna alla home</a>
    <form method='POST' action='allenamento.php' '>
      <input type='button' name='invia' onclick='main()' value='invia'>
    </form>


    </body>
    </html>
  ";

  print($html);
?>
