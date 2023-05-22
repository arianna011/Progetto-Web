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
SELECT nickname, descrizione, foto_profilo, nome_citta, mail
FROM v_profilo_utente
WHERE id_utente = $1";

$result = pg_prepare($dbconn, "usr", $query);
if (!$result) { echo pg_last_error($dbconn); exit; }

$result = pg_execute($dbconn, "usr", array($id));
if (!$result) { echo pg_last_error($dbconn); exit; }

$utente = pg_fetch_assoc($result);
if (!$utente) { echo "utente non trovato; ".pg_last_error($dbconn); exit; }

pg_close($dbconn);


$avatarSrc = $utente["foto_profilo"];
$description = $utente["descrizione"];
$name = $utente["nickname"];
$infos = array(
    $utente["nome_citta"],
    $utente["mail"]
);
$imgs = array();
    
  


require_once "profilo_template.php";
?>