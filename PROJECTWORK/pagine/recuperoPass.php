<?php
include('../FunzioniPHP/Funzioni.php');
if(isset($_POST['email'])){
  $errore=0;
  if($_POST['email']==""){
    $errore=1;
  }else{
    $email = $_POST['email'];
    $sql = "SELECT username, password FROM utente WHERE email='$email'";
    $righe = eseguiquery($sql);


    if(count($righe)>0){
      $hash=$righe[0]['password'];
    }else
      $errore=1;
  }

  //se non ci sono stati errori, invio l’email all’utente con il link da confermare
  if($errore==0){


    $header= "From: sito.it <info@sito.it>\n";
    $header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $header .= "Content-Transfer-Encoding: 7bit\n\n";


    $subject= "sito.it - Nuova password utente";

    $mess_invio="<html><body>";

    $mess_invio.="
    Clicca sul <a href=\"http://www.sito.it/nuova_password.php?hash=".$hash."\">link</a> per confermare la nuova password.<br />
    Se il link non è visibile, copia la riga qui sotto e incollala sul tuo browser: <br />
    http://www.sito.it/nuova_password.php?hash=".$hash."
    ";

    $mess_invio.='</body><html>';

    inviaMail($email, $subject, $mess_invio);
  }
}
?>

<head>
  <meta charset='utf-8'>
  <link rel='stylesheet' href='../css/risultatoStyle.php'>
  <link href='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
  <script src='../js/risultato.js' charset='utf-8'></script>
  <script src='//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
</head>
<form action="" method="post" id="login">
  <div class='wrapper fadeInDown'>
    <div id='formContent'>
      <div class='fadeIn second'>Inserisci la tua email per ricevere la nuova password</div>
      <input type="text" name="email" value="<?=@$_POST['email']?>" class="campo" />
      <input type="submit" class='fadeIn second' value="invia email" />
    </div>
  </div>
</form>
