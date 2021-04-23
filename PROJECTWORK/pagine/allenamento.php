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
      Giorni allenamento alla settimana:
        <input type='checkbox' name='allenamento' value='lunedi'>Lunedì
        <input type='checkbox' name='allenamento' value='martedi'>Martedì
        <input type='checkbox' name='allenamento' value='mercoledi'>Mercoledì
        <input type='checkbox' name='allenamento' value='giovedi'>Giovedì
        <input type='checkbox' name='allenamento' value='venerdi'>Venerdì
        <input type='checkbox' name='allenamento' value='sabato'>Sabato
        <input type='checkbox' name='allenamento' value='domenica'>Domenica<br>

      Tipo allenamento:
        <input type='radio' name='tipo' value='mono'>Monofrequenza
        <input type='radio' name='tipo' value 'multi'>Multifrequenza<br>

      Cardio:
        <input type='radio' name='cardio' value='si'>SI
        <input type='radio' name='cardio' value='no'>NO<br>

      Attrezzatura:
        <input type='radio' name='attrezzatura' value='free'>Pesi/Bilancieri/Manubri
        <input type='radio' name='attrezzatura' value='macchine'>Accesso a palestra
        <input type='radio' name='attrezzatura' value='corpolibero'>Corpo Libero<br>

      <input type='button' name='invia' onclick='main()' value='invia'>
    </form>


    </body>
    </html>
  ";

  print($html);
?>
