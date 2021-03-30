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



if(!array_key_exists("invia", $_POST)){
  $length = 0;
  $tabella = "";
  $u = $_POST["username"];
  $p = encrypt_decrypt("encrypt", $_POST["password"]);

  $_SESSION["username"] = $u;
  $_SESSION["password"] = $p;

  $sql = "SELECT * FROM utente WHERE username = '$u' AND password = '$p'";
  $righe = eseguiquery($sql);

  if(count($righe) == 0){
    header('Location: risultato.php');
  }else{
    if(!array_key_exists("TDEE", $_SESSION)){
      $TDEE = $righe[0]["TDEE"];
      if($TDEE == 0){
        header('Location: TDEE.php');
      }
    }else{
      $TDEE = $_SESSION["TDEE"];
      $sql = "UPDATE utente SET TDEE = '$TDEE' WHERE username = '$u' AND password = '$p'";
      $righe = eseguiquery($sql);

    }
  }
}else{


  $nodes = array();
  $id = $_SESSION["username"];
  $pass = $_SESSION["password"];

  if(array_key_exists("TDEE", $_SESSION)){
    $TDEE = $_SESSION["TDEE"];
  }else{
    $sql = "SELECT * FROM utente WHERE username = '$id' AND password = '$pass'";
    $righe = eseguiquery($sql);
    $TDEE = $righe[0]["TDEE"];
  }


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


  $output = chiamataAPI($nodes);
  $length = count($output);
  $output = json_encode($output);
  $jsonFile = "../json/chiamataAPI.json";
  file_put_contents($jsonFile, $output);




   $righe = $_POST["pasti"];
   $colonne = 8;

   $tabella = "<div class='table-wrapper'><table id='tabellaPasti' class='fl-table'>";
   for ($i=0; $i<$righe; $i++) {
     if($i == 0){
       $tabella .= "<thead><tr>";
       $tabella .= "<th>Giorno</th>";
       for($k=0; $k<count($giorni); $k++){
         $tabella .= "<th>{$giorni[$k]}</th>";
       }
       $tabella .= "</tr></thead>";
     }
     for($j=0; $j<$colonne; $j++){
       if($j == 0){
         $npasto = $i + 1;
         $tabella .= "<th class='contGiorni'>pasto $npasto </th>";
       }else{
         $tabella .= "<td class='pasto'></td>";
       }
     }
     $tabella .= "</tr>";

     if($i == ($righe-1)){
       $tabella .= "<tfoot><tr>";
       $tabella .= "<td>Totale</td>";
       for($k=0; $k<count($giorni); $k++){
         $tabella .= "<td>Totale {$giorni[$k]}</td>";
       }
       $tabella .= "</tr></tfoot>";
     }
   }
   $tabella .= "</table></div>";

}





$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <script src='../js/paginaUtente.js' charset='utf-8'></script>
    <link rel='stylesheet' href='../css/paginaUtente.css'>
  </head>

  <body onload='main()'>
  <form method='POST' action='paginaUtente.php'>
    <input type='hidden' name='jsonarray' value='$length' id='hidden'>

    Tipo di dieta: 
    <select id='dieta' name='dieta'>
      <option value='-' selected>Nessuna preferenza</option>
      <option value='dairy-free'>senza lattosio</option>
      <option value='gluten-free'>senza glutine</option>
      <option value='keto-friendly'>chetogenica</option>
      <option value='paleo'>paleo</option>
      <option value='vegetarian'>vegetariana</option>
      <option value='vegan'>vegana</option>
    </select><br>

    Tipo di cucina:
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
    </select><br>

    Numero pasti giornalieri:
    <select id='pasti' name='pasti'>
      <option value='3' selected hidden>3</option>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
    </select><br>
    <input type='submit' name='invia'>
  </form>

  $tabella
  </body>
  </html>
";

print($html);




 ?>
