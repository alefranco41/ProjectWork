<?php
  include "connessione.php";
  header('Content-type: text/javascript');

  $response = array();
  $sql = "SELECT * FROM cliente";
  $righe = eseguiquery($sql);
  foreach ($righe as $key => $riga) {
    $response[$key]['ID'] = $riga['ID'];
  }
  print_r($response);

 ?>
