<?php
  include "connessione.php";
  header('Content-type: text/javascript');
  $sql = "SELECT * FROM articolo";
  $result = eseguiquery($sql);
  $output = json_encode($result, JSON_PRETTY_PRINT);
  print_r($output);
 ?>
