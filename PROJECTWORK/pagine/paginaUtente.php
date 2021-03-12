<?php
session_start();
include('../FunzioniPHP/Funzioni.php');

<<<<<<< HEAD
<<<<<<< HEAD
=======
$TDEE = $_SESSION["TDEE"];

>>>>>>> parent of b2151b1 (riempimento tabella con ricette)
=======
$TDEE = $_SESSION["TDEE"];

>>>>>>> parent of b2151b1 (riempimento tabella con ricette)
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
  $u = $_POST["username"];
  $p = encrypt_decrypt("encrypt", $_POST["password"]);
  $sql = "SELECT * FROM utente WHERE username = '$u' AND password = '$p'";
  $righe = eseguiquery($sql);

  if(count($righe) == 0){
    header('Location: risultato.php');
<<<<<<< HEAD
=======
  }else{
    if($TDEE == 0){
      $TDEE = $righe[0]["TDEE"];
      if($TDEE == 0){
        header('Location: TDEE.php');
      }
    }else{
      $sql = "UPDATE utente SET TDEE = '$TDEE' WHERE username = '$u' AND password = '$p'";
      $righe = eseguiquery($sql);

    }
>>>>>>> parent of b2151b1 (riempimento tabella con ricette)
  }
}else{
  $nodes = array();


  for ($i=0; $i<7; $i++) {
    for ($j=0; $j<$_POST["pasti"]; $j++) {
      $from = rand(0, 99);
      $to = $from+1;
      $randomAPI = array_rand($APIkey, 1);
      $mealtype = tipoPasto($j, $_POST["pasti"]);
<<<<<<< HEAD
=======
      $rangeCalorie = calcoloRange($mealtype, $_POST["pasti"], $TDEE);
      $fromCalories = round($rangeCalorie * 0.95);
      $toCalories = round($rangeCalorie * 1.05);
      if($_POST["dieta"] == '-'){
        $dieta = "";
      }else{
        $dieta = "&health=" . $_POST["dieta"];
      }

>>>>>>> parent of b2151b1 (riempimento tabella con ricette)
      $query = "https://api.edamam.com/search?q=";
      $query.= "&cuisineType=italian";
      $query.= "&from=$from";
      $query.= "&to=$to";
      $query.= "$mealtype";
      $query.= "&app_id={$APIkey[$randomAPI][0]}&app_key={$APIkey[$randomAPI][1]}";
      echo $query;
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

   $tabella = "<table>";
   for ($i=0; $i<$righe; $i++) {
     if($i == 0){
       $tabella .= "<tr>";
       $tabella .= "<td>Giorno</td>";
       for($k=0; $k<count($giorni); $k++){
         $tabella .= "<td>{$giorni[$k]}</td>";
       }
       $tabella .= "</tr>";
     }
     for($j=0; $j<$colonne; $j++){
       $tabella .= "<td class='sasso'>ciao</td>";
     }
     $tabella .= "</tr>";

     if($i == ($righe-1)){
       $tabella .= "<tr>";
       $tabella .= "<td>Totale</td>";
       for($k=0; $k<count($giorni); $k++){
         $tabella .= "<td>Totale {$giorni[$k]}</td>";
       }
       $tabella .= "</tr>";
     }
   }
   $tabella .= "</table>";

}





$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <script src='../js/paginaUtente.js' charset='utf-8'></script>
  </head>

  <body onload='main()'>
  <form method='POST' action='paginaUtente.php'>
    <input type='hidden' name='jsonarray' value='$length' id='hidden'>

    Tipo di dieta:
    <select id='dieta' name='dieta'>
      <option value='default' selected>Nessuna preferenza</option>
      <option value='senza-lattosio'>senza lattosio</option>
      <option value='senza-glutine'>senza glutine</option>
      <option value='chetogenica'>chetogenica</option>
      <option value='paleo'>paleo</option>
      <option value='vegetariana'>vegetariana</option>
      <option value='vegana'>vegana</option>
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
