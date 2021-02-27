<?php
session_start();
include('../FunzioniPHP/Funzioni.php');
if(array_key_exists("invia", $_POST)){

}else{
  $u = $_POST["username"];
  $p = encrypt_decrypt("encrypt", $_POST["password"]);
  $sql = "SELECT * FROM utente WHERE username = '$u' AND password = '$p'";
  $righe = eseguiquery($sql);

  if(count($righe) == 0){
    header('Location: risultato.php');
  }
}






/*$query = "https://api.edamam.com/search?q=chicken&app_id=faa0810d&app_key=4f4d26e1dacc3ddb0e32f16acc203356&from=0&to=1&calories=591-722&health=alcohol-free";
$output = chiamataAPI($query);*/








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
  </body>
  </html>
";

print($html);




 ?>
