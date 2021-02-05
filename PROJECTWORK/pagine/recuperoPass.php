<?php
if(isset($_POST['email'])){
  $errore=0;
  if($_POST['email']==""){
    $errore=1;
  }else{
    $result=mysql_query("select username, password from utente where email='".$_POST['email']."' limit 0,1", $db);
    if(mysql_num_rows($result)>0){
      $row=mysql_fetch_array($result);
      //l’hash ci servirà per recuperare i dati utente e confermare la richiesta
      //la password nel database si presume criptata
      $hash=$row['password']."".$row['id'];
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

    //invio email
    if(@mail($_POST['email'], $subject, $mess_invio, $header)){
      echo "<div class=\"campo_contatti\" style=\"margin-left: 20px; height: 300px\">";
        echo "Email inviata con successo. Controlla la tua email<br /><br />";
      echo "</div>
      <div class=\"clear\"></div>";
      unset($_POST); //elimino le variabili post, in modo che non appaiano nel form
    }
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
