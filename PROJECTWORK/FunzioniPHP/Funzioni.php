<?php
require_once '../mail/PHPMailerAutoload.php';
require_once '../mail/class.phpmailer.php';
require_once '../mail/class.smtp.php';

	$conn = mysqli_connect("localhost", "root", "", "utenti");
	if (($conn == false) ||  ($conn -> connect_errno)) {
		echo "Errore in connessione a MySQL";
		exit();
	}

	function eseguiquery($sql) {
		global $conn;
		$resultset = $conn->query($sql);
		$righe = mysqli_fetch_all($resultset, MYSQLI_ASSOC);


		if (!$conn->query($sql)) {
    	printf("Error message: %s\n", $conn->error);
		}
		return $righe;
	}

	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function generaHash($len=32)
{
	return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
}


function inviaMail($to, $subject, $content){
	/* CONFIGURATION */
	$crendentials = array(
	    'email'     => 'alessandro.franceschini.2002@gmail.com',    //Your GMail adress
	    'password'  => 'diomede2017'               //Your GMail password
	    );

	/* SPECIFIC TO GMAIL SMTP */
	$smtp = array(

	'host' => 'smtp.gmail.com',
	'port' => 587,
	'username' => $crendentials['email'],
	'password' => $crendentials['password'],
	'secure' => 'tls' //SSL or TLS

	);




	$mailer = new PHPMailer();


	$mailer->isSMTP();
	$mailer->SMTPAuth   = true; //We need to authenticate
	$mailer->Host       = $smtp['host'];
	$mailer->Port       = $smtp['port'];
	$mailer->Username   = $smtp['username'];
	$mailer->Password   = $smtp['password'];
	$mailer->SMTPSecure = $smtp['secure'];

	//Now, send mail :
	//From - To :
	$mailer->From       = $crendentials['email'];
	$mailer->FromName   = 'Alessandro'; //Optional
	$mailer->addAddress($to);  // Add a recipient

	//Subject - Body :
	$mailer->Subject        = $subject;
	$mailer->Body           = $content;
	$mailer->isHTML(true); //Mail body contains HTML tags

	//Check if mail is sent :
	if(!$mailer->send()) {
	    echo "Email non inviata";
	} else {
		echo "Email inviata con successo. Controlla la tua email<br /><br />";
		unset($_POST);
	}

}
?>
