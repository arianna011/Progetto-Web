<?php
require_once  $_SERVER['DOCUMENT_ROOT'].'/connection.php'; 
require_once  $_SERVER['DOCUMENT_ROOT'].'/pages/common/util.php'; 

//controllo che l'id sia presente
if (!isset($_GET['id'])) 
{
    echo "id utente non presente. Assicurati di aver raggiunto questa pagina tramite un link valido";
    exit;
}
$id = $_GET['id'];

//uso di prepared statement per prevenire SQL injection (si spera)
$query = "
SELECT *
FROM v_profilo_artista
WHERE id_artista = $1";

$result = pg_prepare($dbconn, "", $query);
if (!$result) { echo pg_last_error($dbconn); exit; }

$result = pg_execute($dbconn, "", array($id));
if (!$result) { echo pg_last_error($dbconn); exit; }

$row = pg_fetch_assoc($result);
if (!$row) { echo "artista non trovato: ".pg_last_error($dbconn); exit; }

pg_close($dbconn);


$avatarSrc = $row["foto_profilo"];
$description = $row["descrizione"];
$name = $row["nome"];
$infos = [
    $row["nome_citta"],
    "<h3>{$row["min_prezzo"]} - {$row["max_prezzo"]} €</h3>",
    toStars($row["valutazione_media"]),
    toBadges($row["strumenti_musicali"], "bg-secondary"),
    toBadges($row["generi_musicali"], "bg-info"),
    toBadges($row["servizi_forniti"], "bg-danger"),
];
$imgs = fromPgArray($row["foto_galleria"]);
  


require_once "profilo_template.php";
?>