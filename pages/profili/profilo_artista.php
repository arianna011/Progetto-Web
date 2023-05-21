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

//controlli per verificare che l'utente abbia fatto il login
if (isset($_COOKIE["univoco"])) $univoco = $_COOKIE["univoco"];
else $univoco = ""; 

$check_utente = "select * from profilo_utente where id_utente = ".$row["id_artista"]." and univoco = '".$univoco."'";
$result = pg_fetch_row(pg_query($dbconn, $check_utente));

if ($result) $isUtente = true;
else $isUtente = false;

pg_close($dbconn); 

$id = $row["id_artista"];
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
include $_SERVER['DOCUMENT_ROOT'].'/pages/recensioni/recensioni.php';
?>