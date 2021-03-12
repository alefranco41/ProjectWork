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



	function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'k;WGg{sdHx.sHe@2A/)6=q,G';
        $secret_iv = '^CkcW7-#Hu9\-eEu<C6>QLfK';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }


		$APIkey = array(
		0 => array('faa0810d','4f4d26e1dacc3ddb0e32f16acc203356'),
		1 => array('359fdd13','dc7302c318e206fa9ee88d27256c9bc7'),
		2 => array('7114a79b','2208d449b18982bda22638d90a748ec4'),
		3 => array('c0b1ad26','75d270134a65e6675967e6672ec68730'),
		4 => array('86e59a6c','ecca68486eb31c7d9ec93edb956d9872'),
		5 => array('0f044339','58deb5e2a042f65191126dbb3243049a'),
		6 => array('9464aeae','945d042a99892ce7de61a0f2fa194ba3'),
		7 => array('2b3e688d','ed6c9a4bc53eb6e0cf1fdbfc67a0c484'),
		8 => array('60883be7','1fc898f8c0f108e63d0b7ea03ed99dfb'),
		9 => array('b014acc4','5bf69d645a0fbd047485a8aa53337753')
		);


		function chiamataAPI($nodes)
			{
				$node_count = count($nodes);
				$apiResultArray = array();
				$curl_arr = array();
				$master = curl_multi_init();

				for($i = 0; $i < $node_count; $i++){
			    $url =$nodes[$i];
			    $curl_arr[$i] = curl_init($url);
			    curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
			    curl_multi_add_handle($master, $curl_arr[$i]);
				}
				do {
				    curl_multi_exec($master,$running);
				} while($running > 0);

				for($i = 0; $i < $node_count; $i++){
			    $results = curl_multi_getcontent  ($curl_arr[$i]);
					array_push($apiResultArray, $results);
				}
				return $apiResultArray;
			}

			function tipoPasto($j, $pasti){
				if($pasti == 1){
					$tipoPasto = "";
				}else if($pasti == 2){
					if($j == 0){
						$tipoPasto = "&mealType=lunch";
					}else if($j == 1){
						$tipoPasto = "&mealType=dinner";
					}
				}else if($pasti == 3){
					if($j == 0){
						$tipoPasto = "&mealType=breakfast";
					}else if($j == 1){
						$tipoPasto = "&mealType=lunch";
					}else if($j == 2){
						$tipoPasto = "&mealType=dinner";
					}
				}else if($pasti == 4){
					if($j == 0){
						$tipoPasto = "&mealType=breakfast";
					}else if($j == 1){
						$tipoPasto = "&mealType=lunch";
					}else if($j == 2){
						$tipoPasto = "&mealType=snack";
					}else if($j == 3){
						$tipoPasto = "&mealType=dinner";
					}
				}else if($pasti == 5){
					if($j == 0){
						$tipoPasto = "&mealType=breakfast";
					}else if($j == 1){
						$tipoPasto = "&mealType=snack";
					}else if($j == 2){
						$tipoPasto = "&mealType=lunch";
					}else if($j == 3){
						$tipoPasto = "&mealType=snack";
					}else if($j == 4){
						$tipoPasto = "&mealType=dinner";
					}
				}else if($pasti == 6){
					if($j == 0){
						$tipoPasto = "&mealType=breakfast";
					}else if($j == 1){
						$tipoPasto = "&mealType=snack";
					}else if($j == 2){
						$tipoPasto = "&mealType=lunch";
					}else if($j == 3){
						$tipoPasto = "&mealType=snack";
					}else if($j == 4){
						$tipoPasto = "&mealType=dinner";
					}else if($j == 5){
						$tipoPasto = "&mealType=snack";
					}
				}

				return $tipoPasto;
			}

<<<<<<< HEAD
=======
			function calcoloRange($tipoPasto, $numPasti, $TDEE){
				if($numPasti == 1){
					$range = $TDEE;
				}else if($numPasti == 2){
					$range = $TDEE / 2;
				}else if($numPasti == 3){
					if($tipoPasto == "&mealType=breakfast"){
						$range = $TDEE / 5;
					}else{
						$range = $TDEE / 5 * 2;
					}
				}else if($numPasti == 4){
					if($tipoPasto == "&mealType=breakfast"){
						$range = $TDEE / 5;
					}else if($tipoPasto == "&mealType=snack"){
						$range = $TDEE / 10;
					}else{
						$range = $TDEE / 100 * 35;
					}
				}else if($numPasti == 5){
					if($tipoPasto == "&mealType=breakfast"){
						$range = $TDEE / 5;
					}else if($tipoPasto == "&mealType=snack"){
						$range = $TDEE / 10;
					}else{
						$range = $TDEE / 100 * 30;
					}

				}else if($numPasti == 6){
					if($tipoPasto == "&mealType=breakfast"){
						$range = $TDEE / 5;
					}else if($tipoPasto == "&mealType=snack"){
						$range = $TDEE / 10;
					}else{
						$range = $TDEE / 100 * 25;
					}
				}

				return round($range);
			}

<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> parent of b2151b1 (riempimento tabella con ricette)
=======
>>>>>>> parent of b2151b1 (riempimento tabella con ricette)
=======
>>>>>>> parent of b2151b1 (riempimento tabella con ricette)
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
