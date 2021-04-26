<?php
include('../FunzioniPHP/Funzioni.php');
session_start();

  $giorni = [
      'Lunedì',
      'Martedì',
      'Mercoledì',
      'Giovedì',
      'Venerdì',
      'Sabato',
      'Domenica'
  ];

  $muscoli = [
      'Petto',
      'Dorso',
      'Gambe',
      'Spalle',
      'Tricipiti',
      'Bicipiti',
      'Addome',
      'Cardio'
  ];



    $righe = 8;
    $colonne = 8;
    $tabella = caricaTabella($righe, $giorni, $colonne, $muscoli);


    if(array_key_exists("invia", $_POST)){
      $authed = jwt_auth_for_token("alessandrofexrx", "Ckptn63w");
      $authed = (array) $authed;
      $token = $authed["token"];


      $nodes = queryAllenamento($_POST["attrezzatura"]);




      $res = jwt_request($token, $nodes);
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
      <link rel='stylesheet' href='../css/dieta.css'>
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
    </head>

    <body onload='main()'>
    <a href='paginaUtente.php'>Torna alla home</a>

    <div class='container is-max-widescreen'>
      <form method='POST' action='allenamento.php'>
      <div class='field is-horizontal'>
        <div class='field-label is-normal'>
          <label class='label'>Giorni allenamento a settimana</label>
        </div>

        <div class='field-body'>
          <div class='field is-narrow'>
            <div class='control'>
              <label class='checkbox'>
                <input type='checkbox' name='Lunedì'>Lunedì<br>
                <input type='checkbox' name='Martedì'>Martedì<br>
                <input type='checkbox' name='Mercoledì'>Mercoledì<br>
                <input type='checkbox' name='Giovedì'>Giovedì<br>
                <input type='checkbox' name='Venerdì'>Venerdì<br>
                <input type='checkbox' name='Sabato'>Sabato<br>
                <input type='checkbox' name='Domenica'>Domenica<br>
              </label>
            </div>
          </div>
        </div>



        <div class='field-label is-normal'>
          <label class='label'>Tipo di allenamento</label>
        </div>
        <div class='field-body'>
          <div class='field is-narrow'>
            <div class='control'>
              <label class='radio'>
                <input type='radio' name='tipo'>
                  Monofrequenza
              </label><br>
              <label class='radio'>
                <input type='radio' name='tipo'>
                  Multifrequenza
              </label>
            </div>
          </div>
        </div>


        <div class='field-label is-normal'>
          <label class='label'>Giorni Cardio</label>
        </div>

        <div class='field-body'>
          <div class='field is-narrow'>
            <div class='control'>
              <div class='select is-fullwidth'>
                <select id='pesi' name='pesi'>
                  <option value='0' selected>0</option>
                  <option value='1' selected>1</option>
                  <option value='2' selected>2</option>
                  <option value='3' selected>3</option>
                  <option value='4' selected>4</option>
                  <option value='5' selected>5</option>
                  <option value='6' selected>6</option>
                  <option value='7' selected>7</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class='field-label is-normal'>
          <label class='label'>Giorni Pesi</label>
        </div>

        <div class='field-body'>
          <div class='field is-narrow'>
            <div class='control'>
              <div class='select is-fullwidth'>
                <select id='pesi' name='pesi'>
                  <option value='0' selected>0</option>
                  <option value='1' selected>1</option>
                  <option value='2' selected>2</option>
                  <option value='3' selected>3</option>
                  <option value='4' selected>4</option>
                  <option value='5' selected>5</option>
                  <option value='6' selected>6</option>
                  <option value='7' selected>7</option>
                </select>
              </div>
            </div>
          </div>
        </div>



        <div class='field-label is-normal'>
          <label class='label'>Attrezzatura</label>
        </div>
        <div class='field-body'>
          <div class='field is-narrow'>
            <div class='control'>
              <label class='radio'>
                <input type='radio' name='attrezzatura' value='palestra'>
                  Accesso alla palestra
              </label><br>
              <label class='radio'>
                <input type='radio' name='attrezzatura' value='pesi'>
                  Bilanciere e manubri con pesi
              </label><br>
              <label class='radio'>
                <input type='radio' name='attrezzatura' value='niente'>
                  Corpo libero
              </label>
            </div>
          </div>
        </div>




        <div class='field-label'>
          <!-- Left empty for spacing -->
        </div>
        <div class='field-body'>
          <div class='field'>
            <div class='control'>
              <button class='button is-primary' name='invia'>
                Invia
              </button>
            </div>
          </div>
        </div>
        </div>
      </form>
    </div>

  $tabella

    </body>
    </html>
  ";

  print($html);
?>
