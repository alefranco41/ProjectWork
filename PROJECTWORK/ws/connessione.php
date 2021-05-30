<?php
	// testconnessione.php
	$conn = mysqli_connect("localhost", "root", "", "webcommerce");

	// Controlla che la connessione sia stata stabilita correttamente
	if (($conn == false) ||  ($conn -> connect_errno)) {
		echo "Errore in connessione a MySQL";
		exit();
	}

	function eseguiquery($sql) {
		global $conn;
		$resultset = $conn->query($sql);
		$righe = mysqli_fetch_all($resultset, MYSQLI_ASSOC);
		return $righe;
	}

?>
