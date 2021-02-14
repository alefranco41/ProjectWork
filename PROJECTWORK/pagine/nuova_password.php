<?php
include('../FunzioniPHP/Funzioni.php');

if(isset($_GET['hash']) && isset($_POST['invia'])){
	$sql = "SELECT * FROM utente WHERE password_hashed='{$_GET['hash']}'";
	$righe = eseguiquery($sql);

	if(count($righe)>0){

		$password_old = $righe[0]['password'];
		$email = $righe[0]['email'];
		$password = $_POST['pw'];
		$nuovo_hash = password_hash($password, PASSWORD_DEFAULT);

		$sql = "UPDATE utente SET password = '$password', password_hashed = '$nuovo_hash' WHERE password = '$password_old'";
		eseguiquery($sql);


		$subject= "sito.it - Nuova password utente";

		$mess_invio="<html><body>";

		$mess_invio.="
		La sua nuova password utente è ".$password."<br />
		Ora puoi accedere all'area <a href='Risultato.php' style=\"color: red\">Login</a>.
		";

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
          <div class='fadeIn second'>Inserisci la nuova password</div>
          <input type='password' name='pw' placeholder='password' class='campo'/>
          <input type='password' name='pwc' placeholder='conferma password' class='campo'/>
          <input type='submit' name='invia' class='fadeIn second' value='cambia password'/>
        </div>
      </div>
    </form>
  </body>
</html>";

print($html);
?>
