<?php
include "connessione.php";
header('Content-type: text/javascript');
$sql = "SELECT * FROM cliente, ordine WHERE fk_id_cliente = cliente.id ";
$righe = eseguiquery($sql);
$output = json_encode($righe, JSON_PRETTY_PRINT);
echo $output;
 ?>
