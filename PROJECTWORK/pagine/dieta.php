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




$id = $_SESSION["username"];
$pass = $_SESSION["password"];
$sql = "SELECT * FROM utente WHERE username = '$id' AND password = '$pass'";
$righe = eseguiquery($sql);
$TDEE = $righe[0]["TDEE"];
if($TDEE != 0){

  $righe = 5;
  $colonne = 8;
  $tabella = caricaTabella($righe, $giorni, $colonne, "");

  $flag = 0;
  if(array_key_exists("invia", $_POST)){
    $flag = 1;
    $righe = $_POST["pasti"];
    $obiettivo = $_POST["obiettivo"];
    echo $TDEE;
    $TDEE = calcoloTDEE($obiettivo, $TDEE);

    $nodes = array();
    for ($i=0; $i<7; $i++) {
      for ($j=0; $j<$_POST["pasti"]; $j++) {
        $randomAPI = array_rand($APIkey, 1);
        $mealtype = tipoPasto($j, $_POST["pasti"]);
        $rangeCalorie = calcoloRange($mealtype, $_POST["pasti"], $TDEE);
        $fromCalories = round($rangeCalorie * 0.95);
        $toCalories = round($rangeCalorie * 1.05);
        $tipocucina = tipoCucina($_POST["cucina"]);
        $tipodieta = tipoDieta($_POST["dieta"]);



        $query = "https://api.edamam.com/search?q=";
        $query.= "$tipocucina";
        $query.= "&from=0";
        $query.= "&to=100";
        $query.= "$mealtype";
        $query.= "$tipodieta";
        $query.= "&calories={$fromCalories}-{$toCalories}";
        $query.= "&app_id={$APIkey[$randomAPI][0]}&app_key={$APIkey[$randomAPI][1]}";
        array_push($nodes, $query);

      }
    }
    $tabella = caricaTabella($righe, $giorni, $colonne, "");
    $output = chiamataDieta($nodes);
    $output = json_encode($output);
    $jsonFile = "../json/chiamataDieta.json";
    file_put_contents($jsonFile, $output);
  }
}else{
  header('Location: TDEE.php');
}





$html = "<!DOCTYPE html>
<html lang='en' dir='ltr'>
<head>
  <meta charset='utf-8'>
  <title>ProjectWork</title>
  <script src='../js/paginaUtente.js' charset='utf-8'></script>
  <link rel='stylesheet' href='../css/dieta.css'>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body onload='main({$flag})'>
<a href='paginaUtente.php'>Torna alla home</a>

<div class='container'>
  <form method='POST' action='dieta.php'>
  <div class='field is-horizontal'>
    <div class='field-label is-normal'>
      <label class='label'>Tipo di dieta</label>
    </div>

    <div class='field-body'>
      <div class='field is-narrow'>
        <div class='control'>
          <div class='select is-fullwidth'>
            <select id='dieta' name='dieta'>
              <option value='-' selected>Nessuna preferenza</option>
              <option value='dairy-free'>senza lattosio</option>
              <option value='gluten-free'>senza glutine</option>
              <option value='keto-friendly'>chetogenica</option>
              <option value='paleo'>paleo</option>
              <option value='vegetarian'>vegetariana</option>
              <option value='vegan'>vegana</option>
            </select>
          </div>
        </div>
      </div>
    </div>



    <div class='field-label is-normal'>
      <label class='label'>Tipo di cucina</label>
    </div>
    <div class='field-body'>
      <div class='field is-narrow'>
        <div class='control'>
          <div class='select is-fullwidth'>
            <select id='cucina' name='cucina'>
              <option value='-' selected>Nessuna preferenza</option>
              <option value='american'>Americana</option>
              <option value='asian'>Asiatica</option>
              <option value='british'>Inglese</option>
              <option value='caribbean'>Caraibica</option>
              <option value='central%20europe'>Centroeuropea</option>
              <option value='chinese'>Cinese</option>
              <option value='eastern%20europe'>Europea occidentale</option>
              <option value='french'>Francese</option>
              <option value='indian'>Indiana</option>
              <option value='italian'>Italiana</option>
              <option value='japanese'>Giapponese</option>
              <option value='kosher'>Kosher</option>
              <option value='mediterranean'>Mediterranea</option>
              <option value='mexican'>Messicana</option>
              <option value='middle%20eastern'>Europea orientale</option>
              <option value='nordic'>Nordica</option>
              <option value='south american'>Sudamericana</option>
              <option value='south%20east%20asian'>Sud Est Asiatica</option>
            </select>
          </div>
        </div>
      </div>
    </div>



    <div class='field-label is-normal'>
      <label class='label'>Numero pasti giornalieri</label>
    </div>
    <div class='field-body'>
      <div class='field is-narrow'>
        <div class='control'>
          <div class='select is-fullwidth'>
            <select id='pasti' name='pasti'>
              <option value='3' selected hidden>3</option>
              <option value='1'>1</option>
              <option value='2'>2</option>
              <option value='3'>3</option>
              <option value='4'>4</option>
              <option value='5'>5</option>
              <option value='6'>6</option>
            </select>
          </div>
        </div>
      </div>
    </div>



    <div class='field-label is-normal'>
      <label class='label'>Obiettivo</label>
    </div>
    <div class='field-body'>
      <div class='field is-narrow'>
        <div class='control'>
          <div class='select is-fullwidth'>
            <select id='obiettivo' name='obiettivo'>
              <option value='1' selected>mantenimento</option>
              <option value='2'>dimagrimento moderato</option>
              <option value='3'>dimagrimento veloce</option>
              <option value='4'>aumento peso moderato</option>
              <option value='5'>aumento peso veloce</option>
            </select>
          </div>
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
