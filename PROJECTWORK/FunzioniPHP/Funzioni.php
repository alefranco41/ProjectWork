<?php
require_once '../mail/PHPMailerAutoload.php';
require_once '../mail/class.phpmailer.php';
require_once '../mail/class.smtp.php';



$global_get_params = ["exercisename"=>"burpee"];
$global_auth_link = "http://204.235.60.194/consumer/login";
$user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13";

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);


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
		9 => array('b014acc4','5bf69d645a0fbd047485a8aa53337753'),
		10 => array('2d642a7a', 'b953642fd9d087b232400df13004ed6d')
		);


		function chiamataDieta($nodes)
			{

				$headers = ['Accept-Encoding: gzip'];


				$node_count = count($nodes);
				$apiResultArray = array();
				$curl_arr = array();
				$master = curl_multi_init();

				for($i = 0; $i < $node_count; $i++){
			    $url =$nodes[$i];
			    $curl_arr[$i] = curl_init($url);
					curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl_arr[$i], CURLOPT_HTTPHEADER, $headers);
					curl_setopt($curl_arr[$i], CURLOPT_ENCODING , "gzip");
					curl_setopt($curl_arr[$i], CURLOPT_SSL_VERIFYPEER, false);

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


			function jwt_request($token, $get, $nodes) {
					$node_count = count($nodes);
					$apiResultArray = array();
					$curl_arr = array();
					$master = curl_multi_init();
					global $user_agent;

					for($i = 0; $i < $node_count; $i++){
						$url =$nodes[$i];
						$ch[$i] = curl_init($url . "?" . http_build_query($get)); // Initialise cURL
		        $data_type = "Content-type: application/json";
		        $authorization = "Authorization: Bearer $token"; // Prepare the authorisation token
		        curl_setopt($ch[$i], CURLOPT_USERAGENT, $user_agent); // Fusio requires
		        curl_setopt($ch[$i], CURLOPT_HTTPHEADER, [$data_type , $authorization]); // Inject the token into the header
		        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);  //Return data instead printing directly in Browser
		        curl_setopt($ch[$i], CURLOPT_POST, false);
		        curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, true); // This will follow any redirects
						curl_multi_add_handle($master, $ch[$i]);
					}

					do {
					    curl_multi_exec($master,$running);
					} while($running > 0);

					for($i = 0; $i < $node_count; $i++){
				    $results = curl_multi_getcontent  ($ch[$i]);

						array_push($apiResultArray, $results);
					}


	        return $apiResultArray;
	 		 }


			function jwt_auth_for_token($username, $password) {
       global $global_auth_link, $user_agent;

       $ch = curl_init($global_auth_link);
       $data_type = "Content-type: application/json";
       $post_fields = json_encode(["username"=>$username, "password"=>$password]);
       curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
       curl_setopt($ch, CURLOPT_HTTPHEADER, [$data_type]);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
       $result = curl_exec($ch);
       curl_close($ch);
       return json_decode($result);
   }

			function calcoloTDEE($obiettivo, $TDEE){
				if($obiettivo == 1){
					return $TDEE;
				}else if($obiettivo == 2){
					return $TDEE - 300;
				}
				else if($obiettivo == 3){
					return $TDEE - 500;
				}else if($obiettivo == 4){
					return $TDEE + 300;
				}else if($obiettivo == 5){
					return $TDEE + 500;
				}
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


			function tipoCucina($c){
				if($c == "-"){
					return "";
				}else{
					return "&cuisineType={$c}";
				}
			}

			function tipoDieta($d){
				if($d == "-"){
					return "";
				}else{
					return "&health={$d}";
				}
			}

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
			echo $mailer->ErrorInfo;
	    echo "Email non inviata";
	} else {
		echo "Email inviata con successo. Controlla la tua email<br /><br />";
		unset($_POST);
	}

}
?>
