<?php
/*  costruire un WS per il recuperare gli ordini di un utente
	URI: ws_user_ordini.php
	params: usr in GET
	output:
		lista di oggetti json del tipo
		{
			"data_ordine" : "2021-05-01",
			"id_scontrino": 4,
			"articoli": [
				{
					"prezzo": 10.05,
					"quantita": 3
					"descrizione": "oggetto 1",
				},
				{
					"prezzo": 9.99,
					"quantita": 2,
					"descrizione": "oggetto 2",
				},
				...
			]
		}
*/

include "connessione.php";
header('Content-type: text/javascript');

$risultato = Array();

if(!isset($_GET['usr'])){
  echo "inserisci un utente come parametro";
}else{
  $user = $_GET['usr'];
  $sql = "SELECT dataOrdine, ordine.ID FROM ordine, cliente WHERE cliente.username = '{$user}'";
  $righe = eseguiquery($sql);
    foreach ($righe as $chiave => $riga) {
      $query = "SELECT (articoli_ordine.prezzo_unitario * quantita) AS prezzo, quantita, descrizione FROM articolo, articoli_ordine WHERE fk_id_ordine = '{$riga['ID']}' AND articolo.ID = fk_id_articolo";
      $rows = eseguiquery($query);
      array_push($risultato, Array("data_ordine"  => $riga['dataOrdine'],
                                   "id_scontrino" => $riga['ID'],
                                   "articoli" => $rows));
    }
}

$output = json_encode($risultato, JSON_PRETTY_PRINT);
echo $output;


?>
