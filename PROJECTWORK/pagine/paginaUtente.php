<?php
session_start();
include('../FunzioniPHP/Funzioni.php');

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
  }
}else{
  $nodes = array();
  for ($i=0; $i<$_POST["pasti"]; $i++) {
    $randomAPI = array_rand($APIkey, 1);
    $query = "https://api.edamam.com/search?q=breakfast&from=0&to=1&app_id={$APIkey[$randomAPI][0]}&app_key={$APIkey[$randomAPI][1]}";
    array_push($nodes, $query);
  }
  $output = chiamataAPI($nodes);
  $output = json_encode($output);


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

  <body onload='prova()'>
  <form method='POST' action='paginaUtente.php'>
    <input type='hidden' name='jsonarray' value='$output' id='jsonarray'>

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
