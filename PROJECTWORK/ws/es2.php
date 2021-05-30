<?php
  include "connessione.php";
  header('Content-type: text/javascript');
  $sql = "SELECT descrizione, articolo.prezzo_unitario, quantita FROM articolo, articoli_ordine WHERE articolo.ID = fk_id_articolo ";
  $result = eseguiquery($sql);
  $output = json_encode($result, JSON_PRETTY_PRINT);
  echo $output;
 ?>
