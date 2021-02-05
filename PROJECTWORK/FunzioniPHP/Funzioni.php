<?php
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

?>
