<?php
include('../FunzioniPHP/Funzioni.php');
if(isset($_POST['email'])){
  $errore=0;
  if($_POST['email']==""){
    $errore=1;
  }else{
    $email = $_POST['email'];
    $sql = "SELECT * FROM utente WHERE email='$email'";
    $righe = eseguiquery($sql);


    if(count($righe)>0){
      $hash = $righe[0]['password_hashed'];

    }else
      $errore=1;
  }

  //se non ci sono stati errori, invio l’email all’utente con il link da confermare
  if($errore==0){

    $subject= "ProjectWork - Richiesta di cambiamento password";

    $mess_invio="<html><body>";

    $mess_invio.="
    Clicca sul <a href=\"http://80.181.245.128/projectwork/PROJECTWORK/pagine/nuova_password.php?hash=".$hash."\">link</a> per impostare una nuova password.<br/>";

    $mess_invio.='</body><html>';

    inviaMail($email, $subject, $mess_invio);
  }
}
$html = "<!DOCTYPE html>
<html lang='en' dir='ltr'>
<head>
  <meta charset='utf-8'>
  <link rel='stylesheet' href='../css/risultatoStyle.php'>
  <link href='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
  <script src='../js/risultato.js' charset='utf-8'></script>
  <script src='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
</head>
  <body>
    <form action='' method='post' id='login'>
      <div class='wrapper fadeInDown'>
        <div id='formContent'>
          <div class='fadeIn second'>Inserisci la tua email per ricevere la nuova password</div>
          <input type='text' name='email' placeholder='email' class='campo' />
          <input type='submit' class='fadeIn second' value='invia email' />
        </div>
      </div>
    </form>
  </body>
</html>";

print($html);
?>
